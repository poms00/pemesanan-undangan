<?php

namespace App\Livewire\Admin\Produks;

use Livewire\Component;
use App\Models\Produk;
use App\Models\KategoriProduk;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

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
            $this->dispatch('toast:success', 'berhasil diperbarui');
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



    private function handleTemplateUpload($produkId, $existingProduk = null)
    {
        if (!$this->template) {
            return [
                'success' => true,
                'template_zip_path' => null,
                'template_extracted_path' => null,
                'nama_template' => null
            ];
        }

        try {
            // Generate nama unik untuk folder dan file
            $uniqueId = $produkId . '_' . Str::random(8);
            $zipFileName = 'template_' . $uniqueId . '.zip';
            $extractFolderName = 'template_' . $uniqueId;

            // Path untuk menyimpan ZIP baru dan folder ekstraksi
            $zipPath = 'produks/templates/zips/' . $zipFileName;
            $extractPath = 'produks/templates/extracted/' . $extractFolderName;

            // Simpan file ZIP baru
            $savedZipPath = $this->template->storeAs('produks/templates/zips', $zipFileName, 'public');
            $fullZipPath = storage_path('app/public/' . $savedZipPath);

            // Validasi konten ZIP
            $validation = $this->validateZipContent($fullZipPath);
            if (!$validation['valid']) {
                // Hapus file ZIP jika tidak valid
                Storage::disk('public')->delete($savedZipPath);

                return [
                    'success' => false,
                    'message' => $validation['message']
                ];
            }

            // Ekstrak ZIP ke folder terpisah
            $extractResult = $this->extractZipFile($fullZipPath, $extractPath);

            if ($extractResult['success']) {
                // Hapus file template lama SETELAH ekstraksi berhasil
                if ($existingProduk) {
                    $deleteResult = $this->deleteOldTemplateFiles($existingProduk);
                    // Log hasil penghapusan file lama (optional)
                }

                // Dapatkan daftar file yang diekstrak
                $extractedFiles = $this->getExtractedFiles($extractPath);

                return [
                    'success' => true,
                    'template_zip_path' => $savedZipPath,
                    'template_extracted_path' => $extractPath,
                    'nama_template' => $this->template->getClientOriginalName(),
                    'extracted_files' => $extractedFiles,
                    'file_count' => count($extractedFiles),
                    'message' => 'Template berhasil diupload dan diekstrak (' . count($extractedFiles) . ' files)'
                ];
            } else {
                // Hapus file ZIP jika ekstraksi gagal
                Storage::disk('public')->delete($savedZipPath);

                return [
                    'success' => false,
                    'message' => $extractResult['message']
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error upload template: ' . $e->getMessage()
            ];
        }
    }







    /**
     * Method untuk menghapus file template lama (ZIP dan folder ekstraksi)
     */
    private function deleteOldTemplateFiles($produk)
    {
        try {
            $deleted = [];

            // Hapus ZIP file lama
            if ($produk->template && Storage::disk('public')->exists($produk->template)) {
                Storage::disk('public')->delete($produk->template);
                $deleted[] = 'ZIP file lama';
            }

            // Hapus folder ekstraksi lama
            if ($produk->template_extracted && Storage::disk('public')->exists($produk->template_extracted)) {
                Storage::disk('public')->deleteDirectory($produk->template_extracted);
                $deleted[] = 'folder ekstraksi lama';
            }

            return [
                'success' => true,
                'deleted' => $deleted,
                'message' => 'File template lama berhasil dihapus: ' . implode(', ', $deleted)
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error menghapus file lama: ' . $e->getMessage()
            ];
        }
    }


    /**
     * Method untuk memvalidasi konten ZIP
     */
    private function validateZipContent($zipPath)
    {
        try {
            $zip = new ZipArchive;

            if ($zip->open($zipPath) === TRUE) {
                $fileCount = $zip->numFiles;
                $files = [];
                $hasValidFiles = false;

                // Daftar ekstensi file yang diizinkan untuk template
                $allowedExtensions = ['html', 'css', 'js', 'jpg', 'jpeg', 'png', 'gif', 'svg', 'txt', 'md'];

                for ($i = 0; $i < $fileCount; $i++) {
                    $filename = $zip->getNameIndex($i);
                    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

                    $files[] = [
                        'name' => $filename,
                        'extension' => $extension
                    ];

                    if (in_array($extension, $allowedExtensions)) {
                        $hasValidFiles = true;
                    }
                }

                $zip->close();

                return [
                    'valid' => $hasValidFiles,
                    'file_count' => $fileCount,
                    'files' => $files,
                    'message' => $hasValidFiles ? 'ZIP file valid' : 'ZIP tidak mengandung file template yang valid'
                ];
            } else {
                return [
                    'valid' => false,
                    'message' => 'Gagal membaca file ZIP'
                ];
            }
        } catch (\Exception $e) {
            return [
                'valid' => false,
                'message' => 'Error validasi ZIP: ' . $e->getMessage()
            ];
        }
    }



    /**
     * Method untuk mendapatkan daftar file hasil ekstraksi
     */
    private function getExtractedFiles($extractPath)
    {
        try {
            $files = [];
            $fullPath = storage_path('app/public/' . $extractPath);

            if (is_dir($fullPath)) {
                $iterator = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($fullPath, \RecursiveDirectoryIterator::SKIP_DOTS),
                    \RecursiveIteratorIterator::SELF_FIRST
                );

                foreach ($iterator as $file) {
                    if ($file->isFile()) {
                        $relativePath = str_replace($fullPath . DIRECTORY_SEPARATOR, '', $file->getPathname());
                        $files[] = [
                            'name' => $file->getFilename(),
                            'path' => $relativePath,
                            'size' => $file->getSize(),
                            'extension' => $file->getExtension()
                        ];
                    }
                }
            }

            return $files;
        } catch (\Exception $e) {
            return [];
        }
    }



    /**
     * Method untuk mengekstrak ZIP file (sama seperti di Create.php)
     */
    private function extractZipFile($zipPath, $extractToPath)
    {
        try {
            $zip = new ZipArchive;

            // Buka file ZIP
            if ($zip->open($zipPath) === TRUE) {
                // Buat direktori tujuan jika belum ada
                if (!Storage::disk('public')->exists($extractToPath)) {
                    Storage::disk('public')->makeDirectory($extractToPath);
                }

                $fullExtractPath = storage_path('app/public/' . $extractToPath);

                // Ekstrak semua file
                $zip->extractTo($fullExtractPath);
                $zip->close();

                return [
                    'success' => true,
                    'message' => 'File ZIP berhasil diekstrak',
                    'extracted_path' => $extractToPath
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Gagal membuka file ZIP'
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error saat ekstraksi: ' . $e->getMessage()
            ];
        }
    }


    /**
     * Method untuk menghapus template secara permanen (untuk tombol hapus)
     */
    public function deleteTemplate()
    {
        try {
            $produk = Produk::findOrFail($this->produkId);

            // Hapus file template lama
            $deleteResult = $this->deleteOldTemplateFiles($produk);

            // Update database
            $produk->update([
                'template' => null,
                'template_extracted' => null,
                'nama_template' => null,
            ]);

            // Reset properties
            $this->existingTemplate = null;
            $this->template = null;

            // Refresh data
            $this->refreshProdukData();
            $this->backupOriginalData();

            $this->dispatch('produksUpdated', $this->produkId);
        } catch (\Exception $e) {
            $this->dispatch('toast:error', 'Gagal menghapus template: ' . $e->getMessage());
        }
    }


    /**
     * Method untuk mendapatkan informasi template yang lebih detail
     */
    public function getDetailedTemplateInfo()
    {
        $produk = Produk::find($this->produkId);

        if (!$produk) {
            return null;
        }

        $info = [];

        // Info template ZIP
        if ($produk->template && Storage::disk('public')->exists($produk->template)) {
            $info['zip'] = [
                'path' => $produk->template,
                'name' => $produk->nama_template ?: basename($produk->template),
                'size' => $this->formatFileSize(Storage::disk('public')->size($produk->template)),
                'url' => Storage::disk('public')->url($produk->template),
                'exists' => true
            ];
        } else {
            $info['zip'] = ['exists' => false];
        }

        // Info template extracted
        if ($produk->template_extracted && Storage::disk('public')->exists($produk->template_extracted)) {
            $extractedFiles = $this->getExtractedFiles($produk->template_extracted);

            $info['extracted'] = [
                'path' => $produk->template_extracted,
                'file_count' => count($extractedFiles),
                'files' => $extractedFiles,
                'exists' => true
            ];
        } else {
            $info['extracted'] = ['exists' => false];
        }

        return $info;
    }




    /**
     * Update template (PERBAIKAN)
     */
    public function updateTemplate()
    {
        try {
            $this->validate([
                'template' => 'nullable|file|mimes:zip,rar|max:10240',
            ]);

            $produk = Produk::findOrFail($this->produkId);

            if ($this->template) {
                // Proses upload dan ekstraksi template baru
                $templateResult = $this->handleTemplateUpload($produk->id, $produk);

                if (!$templateResult['success']) {
                    $this->dispatch('toast:error', $templateResult['message']);
                    return;
                }

                // Update produk dengan path template baru
                $produk->update([
                    'template' => $templateResult['template_zip_path'],
                    'template_extracted' => $templateResult['template_extracted_path'],
                    'nama_template' => $templateResult['nama_template'],
                ]);

                $this->existingTemplate = $templateResult['template_zip_path'];
                $this->reset(['template']);

                $this->dispatch(
                    'toast:success',
                    'Template berhasil diperbarui dan diekstrak (' .
                        ($templateResult['file_count'] ?? 0) . ' files)'
                );
            } elseif ($this->existingTemplate === null && $produk->template !== null) {
                // Hapus template yang ada
                $deleteResult = $this->deleteOldTemplateFiles($produk);

                $produk->update([
                    'template' => null,
                    'template_extracted' => null,
                    'nama_template' => null,
                ]);

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
      
    }

    public function removeExistingThumbnail()
    {
        $this->existingThumbnail = null;
 
    }

    public function removeTemplateFile()
    {
        $this->template = null;
    
    }

    public function removeExistingTemplate()
    {
        $this->existingTemplate = null;
       
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
        ])->layout('livewire.layouts.admin.admin');
    }
}
