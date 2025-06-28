<?php

namespace App\Livewire\Admin\Produks;

use App\Models\Produk;
use App\Models\KategoriProduk;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use ZipArchive;

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
    public $existingTemplateExtracted;
    public $existingNamaTemplate;

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
        $this->existingTemplateExtracted = $produk->template_extracted;
        $this->existingNamaTemplate = $produk->nama_template;

        // Reset ke step pertama
        $this->currentStep = 1;
        $this->dispatch('EditprodukModal');
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
     * Method untuk mengekstrak ZIP file (tanpa menghapus ZIP asli)
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
     * Method untuk menangani upload dan ekstraksi template (tetap menyimpan ZIP asli)
     */
    private function handleTemplateUpload($produkId)
    {
        if (!$this->template) {
            return [
                'success' => true,
                'template_zip_path' => $this->existingTemplate,
                'template_extracted_path' => $this->existingTemplateExtracted,
                'nama_template' => $this->existingNamaTemplate
            ];
        }

        try {
            // Generate nama unik untuk folder dan file
            $uniqueId = $produkId . '_' . Str::random(8);
            $zipFileName = 'template_' . $uniqueId . '.zip';
            $extractFolderName = 'template_' . $uniqueId;

            // Path untuk menyimpan ZIP asli dan folder ekstraksi
            $zipPath = 'produks/templates/zips/' . $zipFileName;
            $extractPath = 'produks/templates/extracted/' . $extractFolderName;

            // Simpan file ZIP asli
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
 * Method untuk menghapus folder template dan ZIP dengan logging
 */
private function deleteTemplateFiles($zipPath, $extractedPath)
{
    try {
        $deleted = [];
        
        // Hapus ZIP file
        if ($zipPath && Storage::disk('public')->exists($zipPath)) {
            Storage::disk('public')->delete($zipPath);
            $deleted[] = 'ZIP file: ' . $zipPath;
        }
        
        // Hapus folder ekstraksi
        if ($extractedPath && Storage::disk('public')->exists($extractedPath)) {
            Storage::disk('public')->deleteDirectory($extractedPath);
            $deleted[] = 'extracted folder: ' . $extractedPath;
        }
        
        // Log untuk debugging
        if (count($deleted) > 0) {
          
        }
        
        return count($deleted) > 0;
    } catch (\Exception $e) {
       
        return false;
    }
}


    /**
     * Method untuk menghapus hanya folder ekstraksi template
     */
    private function deleteExtractedTemplateFolder($extractedPath)
    {
        try {
            if ($extractedPath && Storage::disk('public')->exists($extractedPath)) {
                Storage::disk('public')->deleteDirectory($extractedPath);
                return true;
            }
            return false;
        } catch (\Exception $e) {
            return false;
        }
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

            if ($field === 'template') {
                // Hapus template files (ZIP dan extracted folder)
                $this->deleteTemplateFiles($produk->template, $produk->template_extracted);

                // Update database - set template fields menjadi null
                $produk->update([
                    'template' => null,
                    'template_extracted' => null,
                    'nama_template' => null
                ]);

                // Reset properties
                $this->existingTemplate = null;
                $this->existingTemplateExtracted = null;
                $this->existingNamaTemplate = null;

              
            } else {
                // Handle thumbnail
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

                $fieldName = $field === 'thumbnail' ? 'gambar' : 'template';
                $this->dispatch('toast:success', ucfirst($fieldName) . ' berhasil dihapus');
            }

            // Reset error untuk field tersebut
            $this->resetErrorBag($field);
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

            // Hapus template existing (ZIP dan extracted folder)
            if ($this->existingTemplate || $this->existingTemplateExtracted) {
                $this->deleteTemplateFiles($this->existingTemplate, $this->existingTemplateExtracted);
                $deletedFiles[] = 'template';
            }

            // Update database
            $produk->update([
                'thumbnail' => null,
                'template' => null,
                'template_extracted' => null,
                'nama_template' => null
            ]);

            // Reset properties
            $this->existingThumbnail = null;
            $this->existingTemplate = null;
            $this->existingTemplateExtracted = null;
            $this->existingNamaTemplate = null;

            // Reset error bags
            $this->resetErrorBag(['thumbnail', 'template']);

            if (count($deletedFiles) > 0) {
                $fileList = implode(' dan ', $deletedFiles);
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
        if (($this->existingTemplate || $this->existingTemplateExtracted) && !$this->template) $count++;

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
        return $this->existingThumbnail || $this->existingTemplate || $this->existingTemplateExtracted;
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
            $fileName = $this->existingNamaTemplate ?: basename($this->existingTemplate);
            $extension = pathinfo($this->existingTemplate, PATHINFO_EXTENSION);

            return [
                'name' => $fileName,
                'size' => $this->formatFileSize($fileSize),
                'extension' => $extension,
                'type' => 'existing',
                'extracted_path' => $this->existingTemplateExtracted
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


    /**
     * Method untuk menghapus template lama dengan validasi yang lebih ketat
     */
    private function cleanupOldTemplate($oldZipPath, $oldExtractedPath)
    {
        $cleanupResult = ['success' => false, 'message' => '', 'deleted_items' => []];

        try {
            // Hapus ZIP file lama
            if ($oldZipPath && Storage::disk('public')->exists($oldZipPath)) {
                if (Storage::disk('public')->delete($oldZipPath)) {
                    $cleanupResult['deleted_items'][] = 'ZIP: ' . basename($oldZipPath);
                }
            }

            // Hapus folder ekstraksi lama
            if ($oldExtractedPath && Storage::disk('public')->exists($oldExtractedPath)) {
                if (Storage::disk('public')->deleteDirectory($oldExtractedPath)) {
                    $cleanupResult['deleted_items'][] = 'Folder: ' . basename($oldExtractedPath);
                }
            }

            $cleanupResult['success'] = count($cleanupResult['deleted_items']) > 0;
            $cleanupResult['message'] = $cleanupResult['success']
                ? 'Template lama berhasil dihapus: ' . implode(', ', $cleanupResult['deleted_items'])
                : 'Tidak ada template lama yang perlu dihapus';

            return $cleanupResult;
        } catch (\Exception $e) {
            $cleanupResult['message'] = 'Error cleanup: ' . $e->getMessage();
            return $cleanupResult;
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

            DB::beginTransaction();

            $produk = Produk::findOrFail($this->produkId);

            // PERBAIKAN 1: Simpan path template lama SEBELUM ada perubahan
            $oldTemplateZip = $produk->template;
            $oldTemplateExtracted = $produk->template_extracted;
            $oldTemplateName = $produk->nama_template;

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

            // Handle template upload dan ekstraksi
            if ($this->template) {
                // PERBAIKAN 2: Hapus template lama SEBELUM upload yang baru
                if ($oldTemplateZip || $oldTemplateExtracted) {
                    $cleanupResult = $this->cleanupOldTemplate($oldTemplateZip, $oldTemplateExtracted);
                  
                }

                // Process template upload dan ekstraksi
                $templateResult = $this->handleTemplateUpload($produk->id);

                if (!$templateResult['success']) {
                    DB::rollback();
                    $this->dispatch('toast:error', $templateResult['message']);
                    return;
                }

                $fileData['template'] = $templateResult['template_zip_path'];
                $fileData['template_extracted'] = $templateResult['template_extracted_path'];
                $fileData['nama_template'] = $templateResult['nama_template'];

                // PERBAIKAN 3: Update existing properties segera setelah upload berhasil
                $this->existingTemplate = $templateResult['template_zip_path'];
                $this->existingTemplateExtracted = $templateResult['template_extracted_path'];
                $this->existingNamaTemplate = $templateResult['nama_template'];
            } else {
                // Tidak ada template baru, gunakan existing yang sudah ada
                $fileData['template'] = $oldTemplateZip;
                $fileData['template_extracted'] = $oldTemplateExtracted;
                $fileData['nama_template'] = $oldTemplateName;
            }

            // PERBAIKAN 4: Update product dengan data yang sudah diproses
            $updateData = [
                'nama' => $this->nama,
                'kategori_id' => $this->kategori_id,
                'harga' => $this->harga,
                'diskon' => $this->diskon ?: null,
                'keterangan' => $this->keterangan,
                'status' => $this->status,
                'thumbnail' => $fileData['thumbnail'],
                'template' => $fileData['template'],
                'template_extracted' => $fileData['template_extracted'],
                'nama_template' => $fileData['nama_template'],
            ];

            $produk->update($updateData);

            DB::commit();

            // Reset input file supaya preview hilang
            $this->reset(['thumbnail', 'template']);

            // PERBAIKAN 5: Sinkronisasi properties dengan data yang baru disimpan
            $this->existingThumbnail = $fileData['thumbnail'];
            $this->existingTemplate = $fileData['template'];
            $this->existingTemplateExtracted = $fileData['template_extracted'];
            $this->existingNamaTemplate = $fileData['nama_template'];

            $this->resetErrorBag(); // Clear all errors

            // Dispatch events
            $this->dispatch('produksUpdated', $this->produkId);

            // Success message
            if ($this->template || isset($templateResult)) {
                $fileCount = isset($templateResult) ? ($templateResult['file_count'] ?? 0) : 0;
                $this->dispatch(   'toast:success', 'Produk berhasil diperbarui' );
            } else {
                $this->dispatch('toast:success', 'Produk berhasil diperbarui');
            }

            // Reset ke step pertama setelah berhasil update
            $this->currentStep = 1;
        } catch (\Exception $e) {
            DB::rollback();
           
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
            'existingTemplate',
            'existingTemplateExtracted',
            'existingNamaTemplate'
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
