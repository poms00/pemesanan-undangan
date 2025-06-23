<?php

namespace App\Livewire\Admin\Produks;

use App\Models\Produk;
use App\Models\KategoriProduk;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    // Form fields
    public $nama, $kategori_id, $harga, $diskon, $status;
    public $thumbnail;
    public $template; // Field for file/zip uploads (matches DB schema)


    // Wizard state
    public $currentStep = 1;
    public $totalSteps = 3; // Updated to 3 steps

    public function mount()
    {
        // Set default values
        $this->status = 'aktif';
        $this->diskon = 0;
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
            'harga.required' => 'wajib diisi',
            'harga.numeric' => 'harus berupa angka',
            'harga.min' => 'min 0',
            'diskon.numeric' => 'harus berupa angka',
            'diskon.min' => 'min 0',
            'diskon.max' => 'maks 100%',
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
     * Method untuk menghapus gambar atau dokumen
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

            // Dispatch success toast
        } catch (\Exception $e) {
            // Handle error
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

            $this->resetErrorBag(['thumbnail', 'template']);

            $this->dispatch('toast:success', 'Semua file berhasil dihapus');
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
        if ($this->thumbnail) $count++;
        if ($this->template) $count++;

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
     * Method untuk mendapatkan informasi file template
     */
    public function getTemplateInfo()
    {
        if (!$this->template) {
            return null;
        }

        return [
            'name' => $this->template->getClientOriginalName(),
            'size' => $this->formatFileSize($this->template->getSize()),
            'extension' => $this->template->getClientOriginalExtension(),
        ];
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

    public function submit()
    {
        try {
            // Validate all steps
            $this->validate([
                'nama' => 'required|string|max:255',
                'kategori_id' => 'required|exists:kategori_produks,id',
                'harga' => 'required|numeric|min:0',
                'diskon' => 'nullable|integer|min:0|max:100',
                'status' => 'required|in:aktif,tidak_aktif',
                'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'template' => 'nullable|file|mimes:zip,rar|max:10240',
            ]);


            // Process file uploads
            $fileData = [];

            // Handle thumbnail upload
            if ($this->thumbnail) {
                $fileData['thumbnail'] = $this->thumbnail->store('produks/images', 'public');
            } else {
                $fileData['thumbnail'] = null;
            }

            // Handle template upload
            if ($this->template) {
                $fileData['template'] = $this->template->store('produks/templates', 'public');
            } else {
                $fileData['template'] = null;
            }

            // Create product
            $produk = Produk::create([
                'nama' => $this->nama,
                'kategori_id' => $this->kategori_id,
                'harga' => $this->harga, // Simpan harga sebagai angka
                'diskon' => $this->diskon ?: null, // Simpan diskon atau null jika 0
                'status' => $this->status,
                'thumbnail' => $fileData['thumbnail'],
                'template' => $fileData['template'],
            ]);

            // Reset form
            $this->reset([
                'nama',
                'kategori_id',
                'harga',
                'diskon',
                'status',
                'thumbnail',
                'template'
            ]);

            $this->currentStep = 1; // Reset to first step
            $this->resetErrorBag(); // Clear all errors


            // Dispatch events
            $this->dispatch('produksCreated', $produk->id);
            $this->dispatch('toast:success', 'Produk berhasil ditambahkan');

            // Redirect atau refresh jika diperlukan
            return redirect()->route('admin.produks.index');
        } catch (\Exception $e) {
            $this->dispatch('toast:error', 'Gagal menyimpan produk: ' . $e->getMessage());
        }
    }

    /**
     * Method untuk reset form
     */
    public function resetForm()
    {
        $this->reset([
            'nama',
            'kategori_id',
            'harga',
            'diskon',
            'status',
            'thumbnail',
            'template'
        ]);

        $this->currentStep = 1;
        $this->resetErrorBag();
    }

    public function render()
    {

        return view('livewire.admin.produks.create', [
            'kategoriList' => KategoriProduk::orderBy('nama_kategori')->get(),
            'uploadedFilesCount' => $this->getUploadedFilesCount(),
            'hasFiles' => $this->hasUploadedFiles(),
            'templateInfo' => $this->getTemplateInfo(),
            'discountInfo' => $this->getDiscountInfo(),
            'hasDiscount' => $this->hasDiscount(),
        ])->layout('components.layouts.admin.admin');
    }
}
