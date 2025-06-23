<?php

namespace App\Livewire\Admin\Produks;

use App\Models\Produk;
use App\Models\KategoriProduk;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public $produkId;

    // Form fields
    public $nama, $kategori_id, $harga, $diskon, $keterangan, $status;
    public $thumbnail;
    public $template; // Field for file/zip uploads (matches DB schema)
    public $existingThumbnail;
    public $existingTemplate;



    // Wizard state
    public $currentStep = 1;
    public $totalSteps = 3; // Updated to 3 steps

    #[On('edit')]
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);

        // Set nilai awal form
        $this->produkId = $produk->id;
        $this->nama = $produk->nama;
        $this->kategori_id = $produk->kategori_id;
        $this->harga = $produk->harga;
        $this->diskon = $produk->diskon ?: 0; // Set diskon atau 0 jika null
        $this->keterangan = $produk->keterangan;
        $this->status = $produk->status;
        // Simpan file yang sudah ada
        $this->existingThumbnail = $produk->thumbnail;
        $this->existingTemplate = $produk->template;

        // Reset ke step pertama
        $this->currentStep = 1;
    }

    public function rules()
    {
        $rules = [];

        if ($this->currentStep == 1) {
            $rules = [
                'nama' => 'required|string|max:255',
                'kategori_id' => 'required|exists:kategori_produks,id',
                'harga' => 'required|numeric|min:0',
                'diskon' => 'nullable|integer|min:0|max:100',
                'keterangan' => 'nullable|string',
                'status' => 'required|in:aktif,tidak_aktif,habis',
            ];
        } elseif ($this->currentStep == 2) {
            $rules = [
                'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ];
        } elseif ($this->currentStep == 3) {
            $rules = [
                'template' => 'nullable|file|mimes:zip,rar|max:10240', // 10MB max
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'nama.required' => 'Nama produk wajib diisi',
            'nama.max' => 'Nama produk maksimal 255 karakter',
            'kategori_id.required' => 'Kategori wajib dipilih',
            'kategori_id.exists' => 'Kategori tidak valid',
            'harga.required' => 'Harga wajib diisi',
            'harga.numeric' => 'Harga harus berupa angka',
            'harga.min' => 'Harga tidak boleh kurang dari 0',
            'diskon.numeric' => 'Diskon harus berupa angka',
            'diskon.min' => 'Diskon tidak boleh kurang dari 0',
            'diskon.max' => 'Diskon maksimal 100%',
            'status.required' => 'Status produk wajib dipilih',
            'status.in' => 'Status tidak valid',
            'thumbnail.image' => 'File harus berupa gambar',
            'thumbnail.mimes' => 'Format gambar harus jpg, jpeg, png, atau webp',
            'thumbnail.max' => 'Ukuran gambar maksimal 2MB',
            'template.file' => 'File harus berupa file yang valid',
            'template.mimes' => 'Format file harus ZIP, RAR',
            'template.max' => 'Ukuran file maksimal 10MB',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /**
     * Method untuk mendapatkan informasi diskon
     */
    public function getDiscountInfo()
    {
        if (!$this->diskon || $this->diskon <= 0) {
            return null;
        }

        return [
            'percentage' => $this->diskon,
        ];
    }

    /**
     * Method untuk cek apakah produk memiliki diskon
     */
    public function hasDiscount()
    {
        return $this->diskon && $this->diskon > 0;
    }

    /**
     * Method untuk set diskon preset
     */
    public function setDiscountPreset($percentage)
    {
        $this->diskon = $percentage;
        $this->validateOnly('diskon');
    }

    /**
     * Method untuk clear diskon
     */
    public function clearDiscount()
    {
        $this->diskon = 0;
        $this->resetErrorBag('diskon');
    }

    /**
     * Method untuk menghapus gambar atau dokumen yang baru diupload
     */
    public function removeFile($field)
    {
        try {
            // Validasi field yang valid
            if (!in_array($field, ['thumbnail', 'template'])) {
                throw new \Exception('Field file tidak valid');
            }

            // Reset property file ke null
            $this->$field = null;

            // Reset error untuk field tersebut
            $this->resetErrorBag($field);

            $this->dispatch('toast:success', 'File berhasil dihapus dari preview');
        } catch (\Exception $e) {
            // Handle error
            $this->dispatch('toast:error', 'Gagal menghapus file: ' . $e->getMessage());
        }
    }

    /**
     * Method untuk menghapus file existing dari storage dan database
     */
    public function removeExistingFile($field)
    {
        try {
            // Validasi field yang valid
            if (!in_array($field, ['thumbnail', 'template'])) {
                throw new \Exception('Field file tidak valid');
            }

            $produk = Produk::findOrFail($this->produkId);
            $existingProperty = 'existing' . ucfirst($field);
            $filePath = $this->$existingProperty;

            // Cek apakah file ada di storage
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                // Hapus file dari storage
                Storage::disk('public')->delete($filePath);
            }

            // Update database - set field menjadi null
            $updateData = [$field => null];
            $produk->update($updateData);

            // Reset property existing file
            $this->$existingProperty = null;

            // Reset error untuk field tersebut
            $this->resetErrorBag($field);

            $fieldName = $field === 'thumbnail' ? 'gambar' : 'template';
            $this->dispatch('toast:success', ucfirst($fieldName) . ' berhasil dihapus');
        } catch (\Exception $e) {
            $this->dispatch('toast:error', 'Gagal menghapus file: ' . $e->getMessage());
        }
    }

    /**
     * Method untuk clear semua file
     */
    public function clearAllFiles()
    {
        try {
            $this->thumbnail = null;
            $this->template = null;
            $this->existingThumbnail = null;
            $this->existingTemplate = null;

            $this->resetErrorBag(['thumbnail', 'template']);

            $this->dispatch('toast:success', 'Semua file berhasil dihapus');
        } catch (\Exception $e) {
            $this->dispatch('toast:error', 'Gagal menghapus file: ' . $e->getMessage());
        }
    }

    /**
     * Method untuk menghapus semua file existing dari storage dan database
     */
    public function clearAllExistingFiles()
    {
        try {
            $produk = Produk::findOrFail($this->produkId);
            $deletedFiles = [];

            // Hapus thumbnail existing
            if ($this->existingThumbnail && Storage::disk('public')->exists($this->existingThumbnail)) {
                Storage::disk('public')->delete($this->existingThumbnail);
                $deletedFiles[] = 'gambar';
            }

            // Hapus template existing
            if ($this->existingTemplate && Storage::disk('public')->exists($this->existingTemplate)) {
                Storage::disk('public')->delete($this->existingTemplate);
                $deletedFiles[] = 'template';
            }

            // Update database
            $produk->update([
                'thumbnail' => null,
                'template' => null,
            ]);

            // Reset properties
            $this->existingThumbnail = null;
            $this->existingTemplate = null;

            // Reset error bags
            $this->resetErrorBag(['thumbnail', 'template']);

            if (count($deletedFiles) > 0) {
                $fileList = implode(' dan ', $deletedFiles);
                $this->dispatch('toast:success', 'File ' . $fileList . ' berhasil dihapus');
            } else {
                $this->dispatch('toast:info', 'Tidak ada file untuk dihapus');
            }
        } catch (\Exception $e) {
            $this->dispatch('toast:error', 'Gagal menghapus file: ' . $e->getMessage());
        }
    }

    /**
     * Real-time validation untuk setiap file
     */
    public function updatedThumbnail()
    {
        $this->validateOnly('thumbnail');
    }

    public function updatedTemplate()
    {
        $this->validateOnly('template');
    }

    /**
     * Method untuk validasi semua file
     */
    public function validateFiles()
    {
        return $this->validate([
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'template' => 'nullable|file|mimes:zip,rar|max:10240',
        ]);
    }

    /**
     * Method untuk mendapatkan jumlah file yang diupload
     */
    public function getUploadedFilesCount()
    {
        $count = 0;

        // Hitung file baru
        if ($this->thumbnail) $count++;
        if ($this->template) $count++;

        // Hitung file existing yang belum diganti
        if ($this->existingThumbnail && !$this->thumbnail) $count++;
        if ($this->existingTemplate && !$this->template) $count++;

        return $count;
    }

    /**
     * Method untuk cek apakah ada file yang diupload
     */
    public function hasUploadedFiles()
    {
        return $this->getUploadedFilesCount() > 0;
    }

    /**
     * Method untuk cek apakah ada file existing
     */
    public function hasExistingFiles()
    {
        return $this->existingThumbnail || $this->existingTemplate;
    }

    /**
     * Method untuk mendapatkan informasi file template
     */
    public function getTemplateInfo()
    {
        // Prioritas template baru
        if ($this->template) {
            return [
                'name' => $this->template->getClientOriginalName(),
                'size' => $this->formatFileSize($this->template->getSize()),
                'extension' => $this->template->getClientOriginalExtension(),
                'type' => 'new'
            ];
        }

        // Template existing
        if ($this->existingTemplate && Storage::disk('public')->exists($this->existingTemplate)) {
            $fileSize = Storage::disk('public')->size($this->existingTemplate);
            $fileName = basename($this->existingTemplate);
            $extension = pathinfo($this->existingTemplate, PATHINFO_EXTENSION);

            return [
                'name' => $fileName,
                'size' => $this->formatFileSize($fileSize),
                'extension' => $extension,
                'type' => 'existing'
            ];
        }

        return null;
    }

    /**
     * Method untuk mendapatkan informasi file thumbnail
     */
    public function getThumbnailInfo()
    {
        // Prioritas thumbnail baru
        if ($this->thumbnail) {
            return [
                'name' => $this->thumbnail->getClientOriginalName(),
                'size' => $this->formatFileSize($this->thumbnail->getSize()),
                'extension' => $this->thumbnail->getClientOriginalExtension(),
                'type' => 'new'
            ];
        }

        // Thumbnail existing
        if ($this->existingThumbnail && Storage::disk('public')->exists($this->existingThumbnail)) {
            $fileSize = Storage::disk('public')->size($this->existingThumbnail);
            $fileName = basename($this->existingThumbnail);
            $extension = pathinfo($this->existingThumbnail, PATHINFO_EXTENSION);

            return [
                'name' => $fileName,
                'size' => $this->formatFileSize($fileSize),
                'extension' => $extension,
                'type' => 'existing'
            ];
        }

        return null;
    }

    /**
     * Helper method untuk format ukuran file
     */
    private function formatFileSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    public function nextStep()
    {
        $this->validate();

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function goToStep($step)
    {
        if ($step >= 1 && $step <= $this->totalSteps) {
            // Validate current step before moving
            if ($step > $this->currentStep) {
                $this->validate();
            }
            $this->currentStep = $step;
        }
    }

    public function update()
    {
        try {
            // Validate all steps
            $this->validate([
                'nama' => 'required|string|max:255',
                'kategori_id' => 'required|exists:kategori_produks,id',
                'harga' => 'required|numeric|min:0',
                'diskon' => 'nullable|numeric|min:0|max:100',
                'keterangan' => 'nullable|string',
                'status' => 'required|in:aktif,tidak_aktif,habis',
                'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'template' => 'nullable|file|mimes:zip,rar|max:10240',
            ]);

            $produk = Produk::findOrFail($this->produkId);

            // Process file uploads
            $fileData = [];

            // Handle thumbnail upload
            if ($this->thumbnail) {
                // Ada gambar baru, hapus yang lama jika ada
                if ($produk->thumbnail && Storage::disk('public')->exists($produk->thumbnail)) {
                    Storage::disk('public')->delete($produk->thumbnail);
                }
                $fileData['thumbnail'] = $this->thumbnail->store('produks/images', 'public');
            } else {
                // Tidak ada gambar baru, gunakan existing
                $fileData['thumbnail'] = $this->existingThumbnail;
            }

            // Handle template upload
            if ($this->template) {
                // Ada template baru, hapus yang lama jika ada
                if ($produk->template && Storage::disk('public')->exists($produk->template)) {
                    Storage::disk('public')->delete($produk->template);
                }
                $fileData['template'] = $this->template->store('produks/templates', 'public');
            } else {
                // Tidak ada template baru, gunakan existing
                $fileData['template'] = $this->existingTemplate;
            }

            // Update product
            $produk->update([
                'nama' => $this->nama,
                'kategori_id' => $this->kategori_id,
                'harga' => $this->harga, // Simpan harga sebagai angka
                'diskon' => $this->diskon ?: null, // Simpan diskon atau null jika 0
                'keterangan' => $this->keterangan,
                'status' => $this->status,
                'thumbnail' => $fileData['thumbnail'],
                'template' => $fileData['template'],
            ]);

            // Reset input file supaya preview hilang
            $this->reset(['thumbnail', 'template']);

            // Update existing files supaya tetap sinkron
            $this->existingThumbnail = $fileData['thumbnail'];
            $this->existingTemplate = $fileData['template'];

            $this->resetErrorBag(); // Clear all errors

            // Dispatch events
            $this->dispatch('produksUpdated', $this->produkId);
            $this->dispatch('toast:success', 'Produk berhasil diperbarui');

            // Reset ke step pertama setelah berhasil update
            $this->currentStep = 1;
        } catch (\Exception $e) {
            $this->dispatch('toast:error', 'Gagal memperbarui produk: ' . $e->getMessage());
        }
    }

    /**
     * Method untuk reset form
     */
    public function resetForm()
    {
        // Reset semua field kecuali produkId
        $this->reset([
            'nama',
            'kategori_id',
            'harga',
            'diskon',
            'keterangan',
            'status',
            'thumbnail',
            'template',
            'existingThumbnail',
            'existingTemplate'
        ]);

        $this->currentStep = 1;
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.admin.produks.edit', [
            'kategoriList' => KategoriProduk::orderBy('nama_kategori')->get(),
            'uploadedFilesCount' => $this->getUploadedFilesCount(),
            'hasFiles' => $this->hasUploadedFiles(),
            'hasExistingFiles' => $this->hasExistingFiles(),
            'templateInfo' => $this->getTemplateInfo(),
            'thumbnailInfo' => $this->getThumbnailInfo(),
            'discountInfo' => $this->getDiscountInfo(),
            'hasDiscount' => $this->hasDiscount(),
        ])->layout('components.layouts.admin.admin');
    }
}
