<?php

namespace App\Livewire\Admin\Produks;

use App\Models\Produk;
use App\Models\KategoriProduk;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

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
     * Method untuk menghapus folder template dan ZIP
     */
    private function deleteTemplateFiles($zipPath, $extractedPath)
    {
        try {
            $deleted = [];

            // Hapus ZIP file
            if ($zipPath && Storage::disk('public')->exists($zipPath)) {
                Storage::disk('public')->delete($zipPath);
                $deleted[] = 'ZIP file';
            }

            // Hapus folder ekstraksi
            if ($extractedPath && Storage::disk('public')->exists($extractedPath)) {
                Storage::disk('public')->deleteDirectory($extractedPath);
                $deleted[] = 'extracted folder';
            }

            return count($deleted) > 0;
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

            // Create product first to get ID
            $produk = Produk::create([
                'nama' => $this->nama,
                'kategori_id' => $this->kategori_id,
                'harga' => $this->harga,
                'diskon' => $this->diskon ?: null,
                'status' => $this->status,
                'thumbnail' => null, // Will be updated below
                'template' => null, // Will be updated below (ZIP path)
                'template_extracted' => null, // Will be updated below (extracted path)
                'nama_template' => null, // Will be updated below
            ]);

            // Process thumbnail upload
            $thumbnailPath = null;
            if ($this->thumbnail) {
                $thumbnailPath = $this->thumbnail->store('produks/images', 'public');
            }

            // Process template upload and extraction
            $templateResult = $this->handleTemplateUpload($produk->id);

            if (!$templateResult['success']) {
                // Delete created product if template processing fails
                $produk->delete();

                $this->dispatch('toast:error', $templateResult['message']);
                return;
            }

            // Update product with file paths
            $produk->update([
                'thumbnail' => $thumbnailPath,
                'template' => $templateResult['template_zip_path'], // Path to original ZIP
                'template_extracted' => $templateResult['template_extracted_path'], // Path to extracted folder  
                'nama_template' => $templateResult['nama_template'],
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

            if ($templateResult['template_zip_path']) {
                $this->dispatch('toast:success', 'Produk berhasil ditambahkan');
            } else {
                $this->dispatch('toast:success', 'Produk berhasil ditambahkan');
            }

            // Redirect
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
