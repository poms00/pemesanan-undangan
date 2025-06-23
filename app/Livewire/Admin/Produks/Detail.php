<?php

namespace App\Livewire\Admin\Produks;

use Livewire\Component;
use App\Models\Produk;
use App\Models\KategoriProduk;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Storage;

class Detail extends Component
{
    use WithFileUploads;

    public $produkId;
    public $produk; // Produk model instance

    // Form fields
    public $nama, $kategori_id, $harga, $diskon, $keterangan, $status, $created_at, $updated_at;
    public $thumbnail;
    public $template;
    public $existingThumbnail;
    public $existingTemplate;



    // Original data backup for cancel functionality
    public $originalData = [];

    // Mode properties
    public $editMode = false;
    public $editModeInformasi = false;
    public $editModeTemplate = false;

    // Total price after discount
    public $totalHarga = 0;

    /**
     * Component initialization
     */
    public function mount($produkId = null, $produk = null)
    {
        $this->produkId = $produkId;

        if ($produk) {
            $this->produk = $produk;
            $this->loadDataFromProduk($produk);
        } elseif ($produkId) {
            $this->loadProdukData();
        }

        $this->calculateTotalHarga();
    }

    /**
     * Load produk data from database
     */
    public function loadProdukData()
    {
        if ($this->produkId) {
            $this->produk = Produk::with('kategori')->find($this->produkId);
            if ($this->produk) {
                $this->loadDataFromProduk($this->produk);
            }
        }
    }

    /**
     * Load data from Produk model instance
     */
    private function loadDataFromProduk($produk)
    {
        $this->nama = $produk->nama;
        $this->kategori_id = $produk->kategori_id;
        $this->harga = $produk->harga;
        $this->diskon = $produk->diskon ?: 0; // Set diskon at 0 if null
        $this->keterangan = $produk->keterangan;
        $this->status = $produk->status;
        $this->created_at = $produk->created_at;
        $this->updated_at = $produk->updated_at;

        // Load existing files
        $this->existingThumbnail = $produk->thumbnail;
        $this->existingTemplate = $produk->template;

        // Backup original data for cancel functionality
        $this->backupOriginalData();

        // Calculate total price after loading data
        $this->calculateTotalHarga();
    }

    /**
     * Calculate total price after discount
     */

    public function calculateTotalHarga()
    {
        $harga = is_numeric($this->harga) ? floatval($this->harga) : 0;
        $diskon = is_numeric($this->diskon) ? floatval($this->diskon) : 0;

        if ($harga < 0) $harga = 0;
        if ($diskon < 0) $diskon = 0;
        if ($diskon > 100) $diskon = 100;

        $this->totalHarga = $harga - ($harga * $diskon / 100);
    }

    /**
     * Update totalHarga ketika harga berubah.
     */
    public function updatedHarga()
    {
        $this->calculateTotalHarga();
    }

    /**
     * Update totalHarga ketika diskon berubah.
     * Auto set to 0 if empty.
     */
    public function updatedDiskon()
    {
        // Jika diskon kosong, null, atau string kosong, set ke 0
        if ($this->diskon === '' || $this->diskon === null || trim($this->diskon) === '') {
            $this->diskon = 0;
        }

        // Pastikan diskon adalah angka dan dalam range yang valid
        if (is_numeric($this->diskon)) {
            $this->diskon = max(0, min(100, intval($this->diskon)));
        } else {
            $this->diskon = 0;
        }

        // Reset error untuk field diskon setelah auto-correct
        $this->resetErrorBag('diskon');

        $this->calculateTotalHarga();
    }



    /**
     * Backup original data before editing
     */
    private function backupOriginalData()
    {
        $this->originalData = [
            'nama' => $this->nama,
            'kategori_id' => $this->kategori_id,
            'harga' => $this->harga,
            'diskon' => $this->diskon,
            'keterangan' => $this->keterangan,
            'status' => $this->status,
            'existingThumbnail' => $this->existingThumbnail,
            'existingTemplate' => $this->existingTemplate,
        ];
    }

    /**
     * Restore original data from backup
     */
    private function restoreOriginalData()
    {
        if (!empty($this->originalData)) {
            $this->nama = $this->originalData['nama'];
            $this->kategori_id = $this->originalData['kategori_id'];
            $this->harga = $this->originalData['harga'];
            $this->diskon = $this->originalData['diskon'];
            $this->keterangan = $this->originalData['keterangan'];
            $this->status = $this->originalData['status'];
            $this->existingThumbnail = $this->originalData['existingThumbnail'];
            $this->existingTemplate = $this->originalData['existingTemplate'];
        }
    }

    /**
     * Refresh produk data after update
     */
    private function refreshProdukData()
    {
        if ($this->produkId) {
            $this->produk = Produk::with('kategori')->findOrFail($this->produkId);
            $this->loadDataFromProduk($this->produk);
        }
    }

    /**
     * Validation rules
     */
    public function rules()
    {
        return [
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_produks,id',
            'harga' => 'required|numeric|min:0',
            'diskon' => 'nullable|integer|min:0|max:100',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:aktif,tidak_aktif,habis',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'template' => 'nullable|file|mimes:zip,rar|max:10240',
        ];
    }

    /**
     * Validation messages
     */
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
            'diskon.integer' => 'Diskon harus berupa angka bulat',
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

    /**
     * Real-time validation
     */
    public function updated($propertyName)
    {
        // Skip validasi real-time untuk diskon jika kosong, biarkan updatedDiskon() menanganinya
        if ($propertyName === 'diskon' && ($this->diskon === '' || $this->diskon === null)) {
            return;
        }

        $this->validateOnly($propertyName);
    }

    /**
     * Edit mode methods
     */
    public function enableEditMode()
    {
        $this->backupOriginalData(); // Backup before entering edit mode
        $this->editMode = true;
    }

    public function cancelEdit()
    {
        // Restore original thumbnail state
        $this->existingThumbnail = $this->originalData['existingThumbnail'] ?? $this->existingThumbnail;

        // Reset uploaded files and errors
        $this->thumbnail = null;
        $this->resetErrorBag(['thumbnail']);

        // Exit edit mode
        $this->editMode = false;

        $this->dispatch('toast:info', 'Perubahan dibatalkan');
    }

    public function TemplateEditMode()
    {
        $this->backupOriginalData(); // Backup before entering edit mode
        $this->editModeTemplate = true;
    }

    public function cancelEditTemplate()
    {
        // Restore original template state
        $this->existingTemplate = $this->originalData['existingTemplate'] ?? $this->existingTemplate;

        // Reset uploaded files and errors
        $this->template = null;
        $this->resetErrorBag(['template']);

        // Exit edit mode
        $this->editModeTemplate = false;

        $this->dispatch('toast:info', 'Perubahan dibatalkan');
    }

    public function informasiEditMode()
    {
        $this->backupOriginalData(); // Backup before entering edit mode
        $this->editModeInformasi = true;

        $this->js('
            setTimeout(() => {
                const input = document.getElementById("input-nama");
                if (input) {
                    input.focus();
                }
            }, 100);
        ');
    }

    public function cancelEditInformasi()
    {
        // Restore all original data
        $this->restoreOriginalData();

        // Reset errors
        $this->resetErrorBag();

        // Exit edit mode
        $this->editModeInformasi = false;

        $this->dispatch('toast:info', 'Perubahan dibatalkan');
    }

    /**
     * Update product information
     */
    public function updateInformasi()
    {
        try {
            // Pastikan diskon adalah 0 jika kosong sebelum validasi
            if ($this->diskon === '' || $this->diskon === null) {
                $this->diskon = 0;
            }

            $this->validate([
                'nama' => 'required|string|max:255',
                'kategori_id' => 'required|exists:kategori_produks,id',
                'harga' => 'required|numeric|min:0',
                'diskon' => 'nullable|integer|min:0|max:100',
                'keterangan' => 'nullable|string',
                'status' => 'required|in:aktif,tidak_aktif,habis',
            ]);

            $produk = Produk::findOrFail($this->produkId);

            $produk->update([
                'nama' => $this->nama,
                'kategori_id' => $this->kategori_id,
                'harga' => $this->harga,
                'diskon' => $this->diskon,
                'keterangan' => $this->keterangan,
                'status' => $this->status,
            ]);

            $this->refreshProdukData();
            $this->resetErrorBag();
            $this->editModeInformasi = false;

            $this->dispatch('produksUpdated', $this->produkId);
            $this->dispatch('toast:success', 'Informasi berhasil diperbarui');
        } catch (\Exception $e) {
            $this->dispatch('toast:error', 'Gagal memperbarui informasi: ' . $e->getMessage());
        }
    }

    /**
     * Update thumbnail
     */
    public function updateThumbnail()
    {
        try {
            $this->validate([
                'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            $produk = Produk::findOrFail($this->produkId);
            $originalThumbnail = $produk->thumbnail;

            if ($this->thumbnail) {
                // Delete old thumbnail if exists
                if ($originalThumbnail && Storage::disk('public')->exists($originalThumbnail)) {
                    Storage::disk('public')->delete($originalThumbnail);
                }

                // Store new thumbnail
                $thumbnailPath = $this->thumbnail->store('produks/images', 'public');
                $produk->update(['thumbnail' => $thumbnailPath]);
                $this->existingThumbnail = $thumbnailPath;
                $this->reset(['thumbnail']);

                $this->dispatch('toast:success', 'Thumbnail berhasil diperbarui');
            } elseif ($this->existingThumbnail === null && $originalThumbnail !== null) {
                // Remove thumbnail
                if (Storage::disk('public')->exists($originalThumbnail)) {
                    Storage::disk('public')->delete($originalThumbnail);
                }
                $produk->update(['thumbnail' => null]);
                $this->existingThumbnail = null;

                $this->dispatch('toast:success', 'Thumbnail berhasil dihapus');
            }

            $this->resetErrorBag(['thumbnail']);
            $this->editMode = false;
            $this->dispatch('produksUpdated', $this->produkId);

            // Update backup data after successful save
            $this->backupOriginalData();
        } catch (\Exception $e) {
            $this->dispatch('toast:error', 'Gagal memperbarui thumbnail: ' . $e->getMessage());
        }
    }

    /**
     * Update template
     */
    public function updateTemplate()
    {
        try {
            $this->validate([
                'template' => 'nullable|file|mimes:zip,rar|max:10240',
            ]);

            $produk = Produk::findOrFail($this->produkId);
            $originalTemplate = $produk->template;

            if ($this->template) {
                // Delete old template if exists
                if ($originalTemplate && Storage::disk('public')->exists($originalTemplate)) {
                    Storage::disk('public')->delete($originalTemplate);
                }

                // Store new template
                $templatePath = $this->template->store('produks/templates', 'public');
                $produk->update(['template' => $templatePath]);
                $this->existingTemplate = $templatePath;
                $this->reset(['template']);

                $this->dispatch('toast:success', 'Template berhasil diperbarui');
            } elseif ($this->existingTemplate === null && $originalTemplate !== null) {
                // Remove template
                if (Storage::disk('public')->exists($originalTemplate)) {
                    Storage::disk('public')->delete($originalTemplate);
                }
                $produk->update(['template' => null]);
                $this->existingTemplate = null;

                $this->dispatch('toast:success', 'Template berhasil dihapus');
            }

            $this->resetErrorBag(['template']);
            $this->editModeTemplate = false;
            $this->dispatch('produksUpdated', $this->produkId);

            // Update backup data after successful save
            $this->backupOriginalData();
        } catch (\Exception $e) {
            $this->dispatch('toast:error', 'Gagal memperbarui template: ' . $e->getMessage());
        }
    }

    /**
     * File removal methods
     */
    public function removeThumbnailFile()
    {
        $this->thumbnail = null;
        $this->dispatch('toast:success', 'Thumbnail berhasil dihapus');
    }

    public function removeExistingThumbnail()
    {
        $this->existingThumbnail = null;
        $this->dispatch('toast:success', 'Thumbnail berhasil dihapus');
    }

    public function removeTemplateFile()
    {
        $this->template = null;
        $this->dispatch('toast:success', 'Template berhasil dihapus');
    }

    public function removeExistingTemplate()
    {
        $this->existingTemplate = null;
        $this->dispatch('toast:success', 'Template berhasil dihapus');
    }

    /**
     * File information methods
     */
    public function getThumbnailUrl()
    {
        if ($this->thumbnail) {
            return $this->thumbnail->temporaryUrl();
        }

        if ($this->existingThumbnail && Storage::disk('public')->exists($this->existingThumbnail)) {
            return Storage::disk('public')->url($this->existingThumbnail);
        }

        return null;
    }

    public function hasThumbnail()
    {
        return $this->thumbnail || $this->existingThumbnail;
    }

    public function getThumbnailInfo()
    {
        if ($this->thumbnail) {
            return [
                'name' => $this->thumbnail->getClientOriginalName(),
                'size' => $this->formatFileSize($this->thumbnail->getSize()),
                'type' => 'new',
                'url' => $this->thumbnail->temporaryUrl()
            ];
        }

        if ($this->existingThumbnail && Storage::disk('public')->exists($this->existingThumbnail)) {
            $fileSize = Storage::disk('public')->size($this->existingThumbnail);
            $fileName = basename($this->existingThumbnail);

            return [
                'name' => $fileName,
                'size' => $this->formatFileSize($fileSize),
                'type' => 'existing',
                'url' => Storage::disk('public')->url($this->existingThumbnail)
            ];
        }

        return null;
    }

    public function getTemplateInfo()
    {
        if ($this->template) {
            return [
                'name' => $this->template->getClientOriginalName(),
                'size' => $this->formatFileSize($this->template->getSize()),
                'extension' => $this->template->getClientOriginalExtension(),
                'type' => 'new'
            ];
        }

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

    public function getUploadedFilesCount()
    {
        $count = 0;

        if ($this->thumbnail) $count++;
        if ($this->template) $count++;
        if ($this->existingThumbnail && !$this->thumbnail) $count++;
        if ($this->existingTemplate && !$this->template) $count++;

        return $count;
    }

    public function hasUploadedFiles()
    {
        return $this->getUploadedFilesCount() > 0;
    }

    /**
     * Helper methods
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

    public function resetForm()
    {
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
        $this->resetErrorBag();
        $this->originalData = []; // Clear backup data
        $this->dispatch('toast:info', 'Form telah direset');
    }

    /**
     * Event listeners
     */
    #[On('edit')]
    public function edit($id)
    {
        $this->produkId = $id;
        $this->loadProdukData();
    }

    public function updatedProdukId()
    {
        if ($this->produkId) {
            $this->loadProdukData();
        }
    }

    /**
     * Public methods for external usage
     */
    public function setProdukId($produkId)
    {
        $this->produkId = $produkId;
        $this->loadProdukData();
    }

    public function openEditForm($produkId)
    {
        $this->produkId = $produkId;
        $this->loadProdukData();
        $this->dispatch('openModal');
    }

    public function initializeProdukData($produkId)
    {
        $this->produkId = $produkId;
        $this->loadProdukData();
    }

    /**
     * Computed property for produk
     */
    public function getProdukProperty()
    {
        if ($this->produkId && !$this->produk) {
            return Produk::with('kategori')->find($this->produkId);
        }
        return $this->produk;
    }

    /**
     * Render component
     */
    public function render()
    {
        return view('livewire.admin.produks.detail', [
            'kategoriList' => KategoriProduk::orderBy('nama_kategori')->get(),
            'uploadedFilesCount' => $this->getUploadedFilesCount(),
            'hasFiles' => $this->hasUploadedFiles(),
            'templateInfo' => $this->getTemplateInfo(),
            'thumbnailUrl' => $this->getThumbnailUrl(),
            'hasThumbnail' => $this->hasThumbnail(),
            'thumbnailInfo' => $this->getThumbnailInfo(),
        ])->layout('components.layouts.admin.admin');
    }
}
