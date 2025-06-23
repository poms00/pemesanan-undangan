<div class="tw-container tw-w-full tw-p-6 tw-space-y-6 tw-mt-10 tw-mx-auto">


    <!-- Header Section -->
    <div
        style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%); border-radius: 12px; padding: 32px; color: white; box-shadow: 0 4px 25px rgba(30, 41, 59, 0.15); margin-bottom: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
            <div>
                <h1 style="font-size: 1.875rem; font-weight: 700; margin: 0 0 8px 0; letter-spacing: -0.025em;">Template
                    Detail</h1>
                <p style="opacity: 0.8; margin: 0; font-size: 1rem; color: #cbd5e1;">Comprehensive template information
                    and preview</p>
            </div>
            <div style="display: flex; gap: 12px;">
                <a href="{{ route('admin.produks.produks-table') }}" wire:navigate
                    style="background: white; border: 1px solid #d1d5db; color: #374151; padding: 10px 18px; border-radius: 8px; font-weight: 500; transition: all 0.2s ease; cursor: pointer; display: flex; align-items: center; gap: 8px;"
                    onmouseover="this.style.background='#f9fafb'; this.style.borderColor='#9ca3af'"
                    onmouseout="this.style.background='white'; this.style.borderColor='#d1d5db'">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15,18 9,12 15,6"></polyline>
                    </svg>
                    Back to List
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 20px;">
        <!-- Left Column - Preview -->
        <div
            style="background: white; border-radius: 12px; padding: 28px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
            <form wire:submit.prevent="updateThumbnail" enctype="multipart/form-data">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
                    <!-- Left Section: Icon + Title -->
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#3b82f6"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                        <h3 style="font-size: 1.125rem; font-weight: 600; margin: 0; color: #1e293b;">Thumbnail</h3>
                    </div>

                    <!-- Tombol Edit/Simpan dengan kondisi -->
                    @if ($editMode ?? false)
                        <!-- Mode Simpan -->
                        <div style="display: flex; gap: 12px;">
                            <button type="submit" class="btn btn-success" wire:loading.attr="disabled"
                                wire:target="updateThumbnail"
                                style="display: flex; align-items: center; gap: 8px; padding: 10px 16px; background: #10b981; color: white; border: 1px solid #10b981; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.15s ease; min-width: 130px; height: 40px; justify-content: center;"
                                onmouseover="this.style.background='#059669'; this.style.borderColor='#059669'"
                                onmouseout="this.style.background='#10b981'; this.style.borderColor='#10b981'">
                                <span wire:loading.remove wire:target="updateThumbnail"
                                    style="display: flex; align-items: center; gap: 8px;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                        <polyline points="17,21 17,13 7,13 7,21" />
                                        <polyline points="7,3 7,8 15,8" />
                                    </svg>
                                    Simpan
                                </span>
                                <span wire:loading wire:target="updateThumbnail" style=" gap: 8px;">
                                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                    Menyimpan...
                                </span>
                            </button>

                            <!-- Tombol Batal -->
                            <button type="button" wire:click="cancelEdit" wire:loading.attr="disabled"
                                style="display: flex; align-items: center; gap: 8px; padding: 10px 16px; background: transparent; color: #6b7280; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.15s ease; min-width: 80px; height: 40px; justify-content: center;"
                                onmouseover="this.style.borderColor='#9ca3af'; this.style.color='#4b5563'"
                                onmouseout="this.style.borderColor='#d1d5db'; this.style.color='#6b7280'">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M18 6L6 18M6 6l12 12" />
                                </svg>
                                Batal
                            </button>
                        </div>
                    @else
                        <!-- Tombol Edit -->
                        <button type="button" wire:click="enableEditMode"
                            style="display: flex; align-items: center; gap: 8px; padding: 10px 16px; background: #3b82f6; color: white; border: 1px solid #3b82f6; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.15s ease; min-width: 70px; height: 40px; justify-content: center;"
                            onmouseover="this.style.background='#1d4ed8'; this.style.borderColor='#1d4ed8'"
                            onmouseout="this.style.background='#3b82f6'; this.style.borderColor='#3b82f6'"
                            title="Edit Thumbnail">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                            Edit
                        </button>
                    @endif
                </div>

                <div class="col-span-full">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span
                            style="background: #6b7280; color: #f9fafb; padding: 4px 8px; border-radius: 6px; font-size: 0.8rem; font-weight: 500;">
                            @php
                                // Cek apakah ada thumbnail baru atau existing
                                $uploadedCount = !empty($thumbnail) || !empty($existingThumbnail) ? 1 : 0;
                            @endphp
                            {{ $uploadedCount }}/1 Thumbnail
                        </span>

                        <div style="font-size: 0.7rem; color: #6b7280; line-height: 1.3;">
                            <strong>Format:</strong> JPG, PNG, WEBP • <strong>Max:</strong> 2MB
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-12">
                            <div class="upload-container position-relative"
                                @if ($editMode ?? false) onclick="document.getElementById('thumbnail').click()" @endif
                                style="aspect-ratio: 2/1;
                               {{ $thumbnail || $existingThumbnail
                                   ? 'background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border: 1px solid #cbd5e1;'
                                   : ($editMode ?? false
                                       ? 'background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border: 2px dashed #94a3b8;'
                                       : 'background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border: 1px solid #cbd5e1;') }}
                               border-radius: 12px;
                               display: flex;
                               align-items: center;
                               justify-content: center;
                               {{ $editMode ?? false ? 'cursor: pointer;' : 'cursor: default;' }}
                               overflow: hidden;
                               transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                               box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08), 0 1px 2px rgba(0, 0, 0, 0.06);"
                                @if ($editMode ?? false) onmouseover="if (!this.querySelector('img')) {
                                 this.style.borderColor='#2563eb';
                                 this.style.background='linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%)';
                                 this.style.transform='translateY(-2px)';
                                 this.style.boxShadow='0 8px 25px rgba(37, 99, 235, 0.12), 0 4px 12px rgba(37, 99, 235, 0.08)';
                             }"
                            onmouseout="if (!this.querySelector('img')) {
                                 this.style.borderColor='#94a3b8';
                                 this.style.background='{{ $thumbnail || $existingThumbnail ? 'linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%)' : 'linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%)' }}';
                                 this.style.transform='translateY(0)';
                                 this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.08), 0 1px 2px rgba(0, 0, 0, 0.06)';
                             }" @endif>


                                <!-- Loading Overlay -->
                                <div wire:loading wire:target="thumbnail, removeThumbnailFile, removeExistingThumbnail"
                                    wire:loading.class.remove="d-none" wire:loading.class="d-flex"
                                    class=" d-none position-absolute w-100 h-100 d-flex align-items-center justify-content-center"
                                    style="z-index: 20; background: rgba(255, 255, 255, 0.95); border-radius: 12px;">
                                    <div class="text-center">
                                        <div class="spinner-border mb-2" role="status"
                                            style="width: 2rem; height: 2rem; color: #6b7280;">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <div style="font-size: 0.8rem; font-weight: 500; color: #4b5563;">
                                            <span wire:loading wire:target="thumbnail">Mengupload
                                                thumbnail...</span>
                                            <span wire:loading wire:target="removeThumbnailFile">Menghapus
                                                thumbnail...</span>
                                            <span wire:loading wire:target="removeExistingFile">Menghapus
                                                thumbnail...</span>
                                        </div>
                                    </div>
                                </div>

                                @error('thumbnail')
                                    <div class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center"
                                        style="background: rgba(254, 242, 242, 0.95); border: 2px solid #fca5a5; border-radius: 12px; z-index: 25;">
                                        <div class="text-center px-3">
                                            <!-- Error Icon -->
                                            <div class="mb-3 d-flex justify-content-center align-items-center">
                                                <div class="d-flex align-items-center justify-content-center"
                                                    style="background: #ef4444; border-radius: 50%; width: 40px; height: 40px;">
                                                    <svg width="24" height="24" viewBox="0 0 24 24"
                                                        fill="none" stroke="white" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path
                                                            d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                                                        <path d="M12 9v4" />
                                                        <path d="m12 17 .01 0" />
                                                    </svg>
                                                </div>
                                            </div>

                                            @error('thumbnail')
                                                <div class="mb-2"
                                                    style="font-size: 0.9rem; color: #dc2626; font-weight: 600; line-height: 1.3;">
                                                    {{ $message === 'The thumbnail failed to upload.'
                                                        ? 'Upload gambar gagal. Periksa ukuran atau format file.'
                                                        : $message }}
                                                </div>
                                            @enderror

                                            <!-- Try Again Text -->
                                            <div style="font-size: 0.75rem; color: #6b7280;">
                                                Klik untuk mencoba lagi
                                            </div>
                                        </div>
                                    </div>
                                @enderror

                                <div wire:loading.remove
                                    wire:target="thumbnail, removeThumbnailFile, removeExistingThumbnail">
                                    @if (!$thumbnail && !$existingThumbnail)

                                        <!-- Empty State - Hanya tampil saat edit mode -->
                                        @if ($editMode ?? false)
                                            <div class="upload-prompt text-center">
                                                <div
                                                    style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                                    <div class="mb-3"
                                                        style="display: flex; justify-content: center; align-items: center;">
                                                        <svg width="48" height="48" viewBox="0 0 24 24"
                                                            fill="none" stroke="#6b7280" stroke-width="1.5"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            style="opacity: 0.8;">
                                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                                            <polyline points="7,10 12,15 17,10" />
                                                            <line x1="12" y1="15" x2="12"
                                                                y2="3" />
                                                        </svg>
                                                    </div>
                                                    <div
                                                        style="font-size: 1rem; font-weight: 600; margin-bottom: 8px; color: #374151; text-align: center;">
                                                        Klik untuk upload thumbnail
                                                    </div>
                                                    <small
                                                        style="font-size: 0.8rem; color: #6b7280; text-align: center;">
                                                        JPG, PNG, WEBP - Maksimal 2MB
                                                    </small>
                                                </div>
                                            </div>
                                        @else
                                            <!-- Preview Mode - No thumbnail -->
                                            <div class="text-center">
                                                <div
                                                    style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                                    <div class="mb-3">
                                                        <svg width="48" height="48" viewBox="0 0 24 24"
                                                            fill="none" stroke="#9ca3af" stroke-width="1.5"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            style="opacity: 0.6;">
                                                            <path
                                                                d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                                        </svg>

                                                    </div>
                                                    <div
                                                        style="font-size: 1rem; font-weight: 500; color: #6b7280; text-align: center;">
                                                        Belum ada thumbnail
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        <!-- Image Preview -->
                                        @if ($thumbnail)
                                            <!-- Gambar baru yang diupload -->
                                            <img src="{{ $thumbnail->temporaryUrl() }}"
                                                style="width: 100%; height: 100%; object-fit: cover;"
                                                alt="Preview Gambar">
                                        @elseif ($existingThumbnail)
                                            <!-- Gambar existing -->
                                            <img src="{{ Storage::url($existingThumbnail) }}"
                                                style="width: 100%; height: 100%; object-fit: cover;"
                                                alt="Thumbnail Produk">
                                        @endif

                                        <!-- Hover Overlay - Hanya tampil saat edit mode -->
                                        @if ($editMode ?? false)
                                            <div class="image-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                                                style="background: linear-gradient(135deg, rgba(55, 65, 81, 0.9), rgba(75, 85, 99, 0.9)); opacity: 0; transition: opacity 0.3s ease; border-radius: 12px;"
                                                onmouseover="this.style.opacity='1';"
                                                onmouseout="this.style.opacity='0';">
                                                <div class="text-white text-center">
                                                    <i class="fas fa-edit mb-1" style="font-size: 1.2rem;"></i>
                                                    <div style="font-size: 0.8rem; font-weight: 500;">Klik untuk
                                                        mengubah gambar</div>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Status Badge - Kiri Atas -->
                                        <div
                                            style="z-index: 15; position: absolute; top: 8px; left: 8px; 
                                                background: {{ $editMode ?? false ? 'linear-gradient(135deg, #10b981, #059669)' : 'linear-gradient(135deg, #3b82f6, #2563eb)' }}; 
                                                color: white; border-radius: 6px; padding: 4px 8px; font-size: 0.7rem; font-weight: 500; display: flex; align-items: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">
                                            @if ($editMode ?? false)
                                                <i class="fas fa-edit me-1" style="font-size: 0.6rem;"></i>
                                                Edit Mode
                                            @else
                                                <i class="fas fa-eye me-1" style="font-size: 0.6rem;"></i>
                                                Preview
                                            @endif
                                        </div>

                                        <!-- Remove Button - Hanya tampil saat edit mode -->
                                        @if ($editMode ?? false)
                                            <button type="button" class="btn position-absolute"
                                                wire:click.stop="{{ $thumbnail ? 'removeThumbnailFile' : 'removeExistingThumbnail' }}"
                                                onclick="event.stopPropagation();"
                                                style="z-index: 15; top: 8px; right: 8px; background: linear-gradient(135deg, rgba(239,68,68,0.95), rgba(220,38,38,0.95)); color: white; border: none; border-radius: 8px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(0,0,0,0.25); transition: all 0.2s ease;"
                                                onmouseover="this.style.background='linear-gradient(135deg, rgba(220,38,38,1), rgba(185,28,28,1))'; this.style.transform='scale(1.1)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.35)';"
                                                onmouseout="this.style.background='linear-gradient(135deg, rgba(239,68,68,0.95), rgba(220,38,38,0.95))'; this.style.transform='scale(1)'; this.style.boxShadow='0 2px 6px rgba(0,0,0,0.25)';"
                                                title="Hapus Tumbnail" wire:loading.attr="disabled"
                                                wire:target="removeThumbnailFile, removeExistingThumbnail">
                                                <!-- Ikon Trash -->
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    style="width: 20px; height: 20px;">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        @endif

                                        <!-- File Info Badge -->
                                        <div class="position-absolute bottom-0 start-0 w-100 px-2 py-1"
                                            style="background: linear-gradient(transparent, rgba(55, 65, 81, 0.9)); color: white; border-radius: 0 0 12px 12px;">
                                            @if ($thumbnail)
                                                <div
                                                    style="font-size: 0.75rem; font-weight: 500; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                                    {{ Str::limit($thumbnail->getClientOriginalName(), 25) }}
                                                </div>
                                                <div style="font-size: 0.7rem; opacity: 0.9;">
                                                    {{ number_format($thumbnail->getSize() / 1024, 1) }} KB
                                                </div>
                                            @elseif ($existingThumbnail)
                                                <div
                                                    style="font-size: 0.75rem; font-weight: 500; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                                    {{ Str::limit(basename($existingThumbnail), 25) }}
                                                </div>
                                                <div style="font-size: 0.7rem; opacity: 0.9;">
                                                    Existing File
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <!-- Hidden File Input -->
                                <input type="file" id="thumbnail" wire:model="thumbnail"
                                    class="d-none @error('thumbnail') is-invalid @enderror"
                                    accept="image/jpeg,image/png,image/webp">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>


        <form wire:submit.prevent="updateInformasi" enctype="multipart/form-data">
            <!-- Right Column - Information -->
            <div
                style="background: white; border-radius: 12px; padding: 28px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#3b82f6"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                        </svg>
                        <h3 style="font-size: 1.125rem; font-weight: 600; margin: 0; color: #1e293b;">Informasi
                            Template</h3>
                    </div>

                    @if ($editModeInformasi ?? false)
                        <!-- Mode Simpan -->
                        <div style="display: flex; gap: 12px;">
                            <button type="submit" class="btn btn-success" wire:loading.attr="disabled"
                                wire:target="updateInformasi"
                                style="display: flex; align-items: center; gap: 8px; padding: 10px 16px; background: #10b981; color: white; border: 1px solid #10b981; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.15s ease; min-width: 130px; height: 40px; justify-content: center;"
                                onmouseover="this.style.background='#059669'; this.style.borderColor='#059669'"
                                onmouseout="this.style.background='#10b981'; this.style.borderColor='#10b981'">
                                <span wire:loading.remove wire:target="updateInformasi"
                                    style="display: flex; align-items: center; gap: 8px;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                        <polyline points="17,21 17,13 7,13 7,21" />
                                        <polyline points="7,3 7,8 15,8" />
                                    </svg>
                                    Simpan
                                </span>
                                <span wire:loading wire:target="updateInformasi" style=" gap: 8px;">
                                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                    Menyimpan...
                                </span>
                            </button>

                            <!-- Tombol Batal -->
                            <button type="button" wire:click="cancelEditInformasi" wire:loading.attr="disabled"
                                style="display: flex; align-items: center; gap: 8px; padding: 10px 16px; background: transparent; color: #6b7280; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.15s ease; min-width: 80px; height: 40px; justify-content: center;"
                                onmouseover="this.style.borderColor='#9ca3af'; this.style.color='#4b5563'"
                                onmouseout="this.style.borderColor='#d1d5db'; this.style.color='#6b7280'">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M18 6L6 18M6 6l12 12" />
                                </svg>
                                Batal
                            </button>
                        </div>
                    @else
                        <!-- Tombol Edit -->
                        <button type="button" wire:click="informasiEditMode"
                            style="display: flex; align-items: center; gap: 8px; padding: 10px 16px; background: #3b82f6; color: white; border: 1px solid #3b82f6; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.15s ease; min-width: 70px; height: 40px; justify-content: center;"
                            onmouseover="this.style.background='#1d4ed8'; this.style.borderColor='#1d4ed8'"
                            onmouseout="this.style.background='#3b82f6'; this.style.borderColor='#3b82f6'"
                            title="Edit Informasi">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                            Edit
                        </button>
                    @endif
                </div>

                @if ($editModeInformasi ?? false)
                    <!-- EDIT MODE - Form Input -->
                    <div class="max-w-2xl mx-auto mt-8">
                        <div class="space-y-6">
                            <!-- Nama Produk -->
                            <div class="grid grid-cols-[160px_24px_1fr] items-center border-b pb-3">
                                <div class="flex items-center gap-2 text-gray-500 font-medium">
                                    <span>Nama Model</span>
                                </div>
                                <div class="flex justify-center font-bold text-gray-400 text-lg">:</div>
                                <div class="relative">
                                    <input type="text" wire:model.live="nama" id="input-nama"
                                        class="form-control w-full text-gray-900 font-semibold text-base bg-transparent border-0 outline-none p-0 m-0
                                               focus:border-0 focus:ring-0 focus:outline-none focus:shadow-none focus:!shadow-none
                                               @error('nama') is-invalid focus:!border-transparent focus:!shadow-none @enderror"
                                        maxlength="255" placeholder="Masukkan nama produk..." autocomplete="off"
                                        style="line-height: inherit; height: auto; box-shadow: none !important;">
                                    @if ($errors->has('nama'))
                                        <div
                                            class="absolute top-full left-0 mt-1 text-xs text-red-600 bg-red-50 px-2 py-1 rounded border border-red-200 shadow-sm whitespace-nowrap z-10">
                                            <small class="text-danger fw-medium">{{ $errors->first('nama') }}</small>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Kategori -->
                            <div class="grid grid-cols-[160px_24px_1fr] items-center border-b pb-3">
                                <div class="flex items-center gap-2 text-gray-500 font-medium">
                                    <span>Kategori</span>
                                </div>
                                <div class="flex justify-center font-bold text-gray-400 text-lg">:</div>
                                <div class="relative">
                                    <select wire:model.live="kategori_id"
                                        class="form-select {{ $errors->has('kategori_id') ? 'is-invalid' : '' }} w-full text-gray-900 font-semibold text-base bg-transparent border-0 outline-none p-0 m-0
                                               focus:border-0 focus:ring-0 focus:outline-none focus:shadow-none focus:!shadow-none
                                               @error('kategori_id') text-red-600 focus:!border-transparent focus:!shadow-none @enderror"
                                        style="line-height: inherit; height: auto; box-shadow: none !important;">
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($kategoriList as $kategori)
                                            <option value="{{ $kategori->id }}">
                                                {{ $kategori->nama_kategori ?? $kategori->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('kategori_id'))
                                        <div
                                            class="absolute top-full left-0 mt-1 text-xs text-red-600 bg-red-50 px-2 py-1 rounded border border-red-200 shadow-sm whitespace-nowrap z-10">
                                            <small
                                                class="text-danger fw-medium">{{ $errors->first('kategori_id') }}</small>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="grid grid-cols-[160px_24px_1fr] items-center border-b pb-3">
                                <div class="flex items-center gap-2 text-gray-500 font-medium">
                                    <span>Status</span>
                                </div>
                                <div class="flex justify-center font-bold text-gray-400 text-lg">:</div>
                                <div class="relative">
                                    <select wire:model.live="status"
                                        class="form-select {{ $errors->has('status') ? 'is-invalid' : '' }} w-full text-gray-900 font-semibold text-base bg-transparent border-0 outline-none p-0 m-0
                                               focus:border-0 focus:ring-0 focus:outline-none focus:shadow-none focus:!shadow-none
                                               @error('status') text-red-600 focus:!border-transparent focus:!shadow-none @enderror"
                                        style="line-height: inherit; height: auto; box-shadow: none !important;">
                                        <option value="">Pilih Status</option>
                                        <option value="aktif">Aktif</option>
                                        <option value="tidak_aktif">Tidak Aktif</option>
                                    </select>
                                    @if ($errors->has('status'))
                                        <div
                                            class="absolute top-full left-0 mt-1 text-xs text-red-600 bg-red-50 px-2 py-1 rounded border border-red-200 shadow-sm whitespace-nowrap z-10">
                                            <small class="text-danger">{{ $errors->first('status') }}</small>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Harga dan Diskon - Side by Side -->
                            <div class="grid grid-cols-[160px_24px_1fr] items-start border-b pb-3">
                                <div class="flex items-center gap-2 text-gray-500 font-medium">
                                    <span>Harga & Diskon</span>
                                </div>
                                <div class="flex justify-center font-bold text-gray-400 text-lg pt-1">:</div>
                                <div class="grid grid-cols-2 gap-6">
                                    <!-- Harga -->
                                    <div class="relative">
                                        <label class="block text-sm text-gray-400 mb-2">Harga</label>
                                        <div class="text-gray-900 font-semibold text-base flex items-center">
                                            <span class="mr-2">Rp</span>
                                            <input type="text" wire:model.live="harga"
                                                class="form-control {{ $errors->has('harga') ? 'is-invalid' : '' }} bg-transparent border-0 outline-none p-0 m-0 flex-1
                                                       focus:border-0 focus:ring-0 focus:outline-none focus:shadow-none focus:!shadow-none
                                                       @error('harga') text-red-600 focus:!border-transparent focus:!shadow-none @enderror"
                                                placeholder="0" autocomplete="off"
                                                style="line-height: inherit; height: auto; box-shadow: none !important;">
                                        </div>
                                        @if ($errors->has('harga'))
                                            <div
                                                class="absolute top-full left-0 mt-1 text-xs text-red-600 bg-red-50 px-2 py-1 rounded border border-red-200 shadow-sm whitespace-nowrap z-10">
                                                <small
                                                    class="text-danger fw-medium">{{ $errors->first('harga') }}</small>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Diskon -->
                                    <div class="relative">
                                        <label class="block text-sm text-gray-400 mb-2">Diskon</label>
                                        <div class="relative text-gray-900 font-semibold text-base">
                                            <input type="text" wire:model.live="diskon"
                                                class="form-control {{ $errors->has('diskon') ? 'is-invalid' : '' }} bg-transparent border-0 outline-none p-0 pr-6 m-0 w-20
                                                       focus:border-0 focus:ring-0 focus:outline-none focus:shadow-none focus:!shadow-none
                                                       @error('diskon') text-red-600 focus:!border-transparent focus:!shadow-none @enderror"
                                                placeholder="0" autocomplete="off"
                                                style="line-height: inherit; height: auto; box-shadow: none !important;">
                                            <span
                                                class="absolute ml-5 top-0 text-gray-900 pointer-events-none">%</span>
                                        </div>
                                        @if ($errors->has('diskon'))
                                            <div
                                                class="absolute top-full left-0 mt-1 text-xs text-red-600 bg-red-50 px-2 py-1 rounded border border-red-200 shadow-sm whitespace-nowrap z-10">
                                                <small
                                                    class="text-danger fw-medium">{{ $errors->first('diskon') }}</small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!--Total Harga-->
                            <div class="grid grid-cols-[160px_24px_1fr] items-center pb-3">
                                <div class="flex items-center gap-2 text-gray-500 font-medium">
                                    <span>Total Harga</span>
                                </div>
                                <div class="flex justify-center font-bold text-gray-400 text-lg">:</div>
                                <div class="relative">
                                    <div class="text-gray-900 font-semibold text-base flex items-center">
                                        Rp {{ number_format($totalHarga, 0, ',', '.') }}
                                        @if (!empty($diskon) && $diskon > 0)
                                            <span
                                                class="ml-3 inline-block bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-semibold">
                                                Diskon {{ $diskon }}%
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                @else
                    <!-- PREVIEW MODE  -->
                    <div class="max-w-2xl mx-auto mt-8">
                        <div class="space-y-6">
                            <!-- Nama Produk -->
                            <div class="grid grid-cols-[160px_24px_1fr] items-center border-b pb-3">
                                <div class="flex items-center gap-2 text-gray-500 font-medium">
                                    <span>Nama Model</span>
                                </div>
                                <div class="flex justify-center font-bold text-gray-400 text-lg">:</div>
                                <div class="text-gray-900 font-semibold text-base">{{ $produk->nama }}</div>
                            </div>

                            <!-- Kategori -->
                            <div class="grid grid-cols-[160px_24px_1fr] items-center border-b pb-3">
                                <div class="flex items-center gap-2 text-gray-500 font-medium">
                                    <span>Kategori</span>
                                </div>
                                <div class="flex justify-center font-bold text-gray-400 text-lg">:</div>
                                <div class="text-gray-900 font-semibold text-base">
                                    {{ $produk->kategori->nama_kategori ?? '-' }}
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="grid grid-cols-[160px_24px_1fr] items-center border-b pb-3">
                                <div class="flex items-center gap-2 text-gray-500 font-medium">
                                    <span>Status</span>
                                </div>
                                <div class="flex justify-center font-bold text-gray-400 text-lg">:</div>
                                <div>
                                    @if ($produk->status === 'aktif')
                                        <span
                                            class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">Aktif</span>
                                    @else
                                        <span
                                            class="inline-block bg-gray-200 text-gray-600 px-3 py-1 rounded-full text-sm font-semibold">Tidak
                                            Aktif</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Harga dan Diskon - Side by Side -->
                            <div class="grid grid-cols-[160px_24px_1fr] items-start border-b pb-3">
                                <div class="flex items-center gap-2 text-gray-500 font-medium">
                                    <span>Harga & Diskon</span>
                                </div>
                                <div class="flex justify-center font-bold text-gray-400 text-lg pt-1">:</div>
                                <div class="grid grid-cols-2 gap-6">
                                    <!-- Harga -->
                                    <div>
                                        <label class="block text-sm text-gray-400 mb-2">Harga</label>
                                        <div class="text-gray-900 font-semibold text-base flex items-center">
                                            <span class="mr-2">Rp</span>
                                            <span>{{ number_format((int) $produk->harga, 0, ',', '.') }}</span>
                                        </div>
                                    </div>

                                    <!-- Diskon -->
                                    <div>
                                        <label class="block text-sm text-gray-400 mb-2">Diskon</label>
                                        <div class="text-gray-900 font-semibold text-base">
                                            {{ $produk->diskon ?? 0 }}
                                            %
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--Total Harga-->
                            <div class="grid grid-cols-[160px_24px_1fr] items-center border-b pb-3">
                                <div class="flex items-center gap-2 text-gray-500 font-medium">
                                    <span>Total Harga</span>
                                </div>
                                <div class="flex justify-center font-bold text-gray-400 text-lg">:</div>
                                <div class="relative">
                                    <div class="text-gray-900 font-semibold text-base flex items-center">
                                        Rp {{ number_format($totalHarga, 0, ',', '.') }}
                                        @if (!empty($diskon) && $diskon > 0)
                                            <span
                                                class="ml-3 inline-block bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-semibold">
                                                Diskon {{ $diskon }}%
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>
                @endif
            </div>
        </form>
    </div>


    <!-- Template File Section -->
    <form wire:submit.prevent="updateTemplate" enctype="multipart/form-data">
        <div class="template-package-container"
            style="background: white;  border-radius: 12px;  padding: 24px;  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);  border: 1px solid #e2e8f0;">

            <!-- Header Section -->
            <div class="template-header d-flex align-items-center justify-content-between"
                style="margin-bottom: 32px;">

                <!-- Left Section: Icon + Title -->
                <div style="display: flex; align-items: center; gap: 12px;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#3b82f6"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">

                        <path
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    <h3 style="font-size: 1.125rem; font-weight: 600; margin: 0; color: #1e293b;">Template Packge</h3>
                </div>



                <!-- Right Section: Action Buttons -->
                <div class="action-buttons">
                    @if ($editModeTemplate ?? false)
                        <!-- Mode Simpan -->
                        <div style="display: flex; gap: 12px;">
                            <button type="submit" class="btn btn-success" wire:loading.attr="disabled"
                                wire:target="updateTemplate"
                                style="display: flex; align-items: center; gap: 8px; padding: 10px 16px; background: #10b981; color: white; border: 1px solid #10b981; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.15s ease; min-width: 130px; height: 40px; justify-content: center;"
                                onmouseover="this.style.background='#059669'; this.style.borderColor='#059669'"
                                onmouseout="this.style.background='#10b981'; this.style.borderColor='#10b981'">
                                <span wire:loading.remove wire:target="updateTemplate"
                                    style="display: flex; align-items: center; gap: 8px;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                        <polyline points="17,21 17,13 7,13 7,21" />
                                        <polyline points="7,3 7,8 15,8" />
                                    </svg>
                                    Simpan
                                </span>
                                <span wire:loading wire:target="updateTemplate" style=" gap: 8px;">
                                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                    Menyimpan...
                                </span>
                            </button>

                            <!-- Tombol Batal -->
                            <button type="button" wire:click="cancelEditTemplate" wire:loading.attr="disabled"
                                style="display: flex; align-items: center; gap: 8px; padding: 10px 16px; background: transparent; color: #6b7280; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.15s ease; min-width: 80px; height: 40px; justify-content: center;"
                                onmouseover="this.style.borderColor='#9ca3af'; this.style.color='#4b5563'"
                                onmouseout="this.style.borderColor='#d1d5db'; this.style.color='#6b7280'">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M18 6L6 18M6 6l12 12" />
                                </svg>
                                Batal
                            </button>
                        </div>
                    @else
                        <!-- Tombol Edit -->
                        <button type="button" wire:click="TemplateEditMode"
                            style="display: flex; align-items: center; gap: 8px; padding: 10px 16px; background: #3b82f6; color: white; border: 1px solid #3b82f6; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.15s ease; min-width: 70px; height: 40px; justify-content: center;"
                            onmouseover="this.style.background='#1d4ed8'; this.style.borderColor='#1d4ed8'"
                            onmouseout="this.style.background='#3b82f6'; this.style.borderColor='#3b82f6'"
                            title="Edit Template">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                            Edit
                        </button>
                    @endif
                </div>
            </div>

            <!-- Upload Container -->
            <div class="upload-container"
                @if ($editModeTemplate ?? false) onclick="document.getElementById('template').click()"
                        style="height: 140px;
                            {{ $template || $existingTemplate
                                ? 'background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border: 2px solid #cbd5e1;'
                                : 'background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border: 2px dashed #94a3b8;' }}
                            border-radius: 12px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            cursor: pointer;
                            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                            box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.06), 0 1px 2px -1px rgba(0, 0, 0, 0.06);"
                        onmouseover="this.style.borderColor='#2563eb'; 
                                    this.style.background='linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%)';
                                    this.style.transform='translateY(-2px)';
                                    this.style.boxShadow='0 10px 25px -3px rgba(37, 99, 235, 0.1), 0 4px 6px -2px rgba(37, 99, 235, 0.05)';"
                        onmouseout="this.style.borderColor='{{ $template || $existingTemplate ? '#cbd5e1' : '#94a3b8' }}';
                                    this.style.background='linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%)';
                                    this.style.transform='translateY(0)';
                                    this.style.boxShadow='0 2px 4px -1px rgba(0, 0, 0, 0.06), 0 1px 2px -1px rgba(0, 0, 0, 0.06)';"
                    @else
                        style="height: 140px;
                            {{ $template || $existingTemplate
                                ? 'background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border: 1px solid #cbd5e1;'
                                : 'background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border: 1px solid #cbd5e1;' }}
                            border-radius: 12px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                            box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.06), 0 1px 2px -1px rgba(0, 0, 0, 0.06);" @endif>

                <!-- Loading State -->
                <div wire:loading wire:target="template, removeTemplateFile, removeExistingTemplate"
                    wire:loading.class.remove="d-none" wire:loading.class="d-flex"
                    class="loading-overlay d-none position-absolute w-100 h-100 d-flex align-items-center justify-content-center"
                    style="z-index: 30; 
                                background: rgba(255, 255, 255, 0.95); 
                                border-radius: 12px; 
                                backdrop-filter: blur(2px);">
                    <div class="text-center">
                        <div class="spinner-border mb-2" role="status"
                            style="width: 2rem; height: 2rem; color: #6b7280;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="loading-text"
                            style="font-size: 0.875rem; 
                                        font-weight: 500; 
                                        color: #4b5563;">
                            <span wire:loading wire:target="template">Mengupload template...</span>
                            <span wire:loading wire:target="removeTemplateFile">Menghapus template...</span>
                            <span wire:loading wire:target="removeExistingTemplate">Menghapus template...</span>
                        </div>
                    </div>
                </div>

                <!-- Error State -->
                @error('template')
                    <div class="error-overlay position-absolute w-100 h-100 d-flex align-items-center justify-content-center"
                        style="background: #fef2f2; 
                                    border: 2px solid #fca5a5; 
                                    border-radius: 12px; 
                                    z-index: 25;">
                        <div class="d-flex align-items-center gap-4 px-4">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ef4444"
                                stroke-width="2" class="flex-shrink-0">
                                <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                                <path d="M12 9v4" />
                                <path d="m12 17 .01 0" />
                            </svg>
                            <div class="d-flex flex-column">
                                <div class="error-message"
                                    style="font-size: 0.875rem; 
                                                color: #dc2626; 
                                                font-weight: 500; 
                                                margin-bottom: 2px;">
                                    {{ $message }}
                                </div>
                                <div class="error-hint"
                                    style="font-size: 0.75rem; 
                                                color: #6b7280;">
                                    Klik untuk mencoba lagi
                                </div>
                            </div>
                        </div>
                    </div>
                @enderror

                <!-- Content -->
                <div wire:loading.remove wire:target="template">
                    @if (!$template && !$existingTemplate)
                        @if ($editModeTemplate ?? false)
                            <!-- Upload State -->
                            <div class="upload-prompt d-flex align-items-center gap-6 px-6">
                                <div class="upload-icon flex-shrink-0 d-flex align-items-center justify-content-center"
                                    style="width: 64px; 
                                                height: 64px; 
                                                background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); 
                                                border-radius: 16px; 
                                                box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                        stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                        <polyline points="7,10 12,15 17,10" />
                                        <line x1="12" y1="15" x2="12" y2="3" />
                                    </svg>
                                </div>
                                <div class="upload-content flex-1 text-start">
                                    <div class="upload-title"
                                        style="font-size: 1.25rem; 
                                                    font-weight: 600; 
                                                    color: #1f2937; 
                                                    margin-bottom: 8px; 
                                                    line-height: 1.3;">
                                        Klik untuk upload template
                                    </div>
                                    <div class="upload-description"
                                        style="font-size: 0.9rem; 
                                                    color: #6b7280; 
                                                    line-height: 1.4; 
                                                    margin-bottom: 6px;">
                                        Drag & drop atau klik untuk memilih file template
                                    </div>
                                    <div class="upload-specs"
                                        style="font-size: 0.8rem; 
                                                    color: #9ca3af;">
                                        Format: ZIP, RAR • Maksimal 10MB
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Empty State -->
                            <div class="empty-state d-flex align-items-center gap-6 px-6">
                                <div class="empty-icon flex-shrink-0 d-flex align-items-center justify-content-center"
                                    style="width: 64px; 
                                                height: 64px; 
                                                background: #f1f5f9; 
                                                border-radius: 16px; 
                                                border: 2px solid #e2e8f0;">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                        stroke="#64748b" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                        <polyline points="14,2 14,8 20,8" />
                                        <line x1="16" y1="13" x2="8" y2="13" />
                                        <line x1="16" y1="17" x2="8" y2="17" />
                                        <polyline points="10,9 9,9 8,9" />
                                    </svg>
                                </div>
                                <div class="empty-content flex-1 text-start">
                                    <div class="empty-title"
                                        style="font-size: 1.25rem; 
                                                    font-weight: 600; 
                                                    color: #1f2937; 
                                                    margin-bottom: 8px; 
                                                    line-height: 1.3;">
                                        Belum ada template
                                    </div>
                                    <div class="empty-description"
                                        style="font-size: 0.9rem; 
                                                    color: #6b7280; 
                                                    line-height: 1.4; 
                                                    margin-bottom: 6px;">
                                        Template yang Anda upload akan ditampilkan di sini
                                    </div>
                                    <div class="empty-hint"
                                        style="font-size: 0.8rem; 
                                                    color: #9ca3af;">
                                        Klik tombol "Edit" untuk mengelola template
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <!-- File Preview -->
                        <div class="file-preview"
                            style="display: flex !important;
                            align-items: center !important;
                            justify-content: space-between !important;
                            width: 100% !important;
                            padding: 20px 24px !important;
                            height: 140px !important;
                            box-sizing: border-box !important;
                            column-gap: 32px !important;">

                            <!-- Left Section: File Icon & Info -->
                            <div class="file-section"
                                style="display: flex !important;
                                align-items: center !important;
                                flex: 1 1 auto !important;
                                min-width: 0 !important;
                                overflow: hidden !important;
                                gap: 20px !important;">
                                @php
                                    $extension = '';
                                    if ($templateInfo) {
                                        $extension = strtolower($templateInfo['extension'] ?? '');
                                    }
                                @endphp

                                <!-- File Icon -->
                                <div class="file-icon"
                                    style="display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    background: linear-gradient(135deg, #f59e0b, #d97706); 
                                    border-radius: 16px; 
                                    width: 64px; 
                                    height: 64px; 
                                    min-width: 64px;
                                    flex-shrink: 0;
                                    box-shadow: 0 6px 16px rgba(245, 158, 11, 0.3);">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                        stroke="white" stroke-width="1.5">
                                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>

                                <!-- File Info -->
                                @if ($templateInfo)
                                    <div class="file-info"
                                        style="flex: 1 !important;
                                        min-width: 0 !important;
                                        overflow: hidden !important;">
                                        <div class="file-name"
                                            style="font-size: 1.125rem; 
                                            font-weight: 600; 
                                            color: #374151; 
                                            margin-bottom: 8px;
                                            line-height: 1.4;
                                            overflow: hidden !important;
                                            text-overflow: ellipsis !important;
                                            white-space: nowrap !important;">
                                            {{ Str::limit($templateInfo['name'], 35) }}
                                        </div>
                                        <div class="file-meta"
                                            style="font-size: 0.875rem; 
                                            color: #6b7280;
                                            line-height: 1.3;
                                            display: flex;
                                            align-items: center;
                                            gap: 8px;
                                            flex-wrap: wrap;">
                                            <span>{{ $templateInfo['size'] }}</span>
                                            <span style="color: #d1d5db;">•</span>
                                            <span>{{ strtoupper($templateInfo['extension']) }}</span>

                                            @if ($templateInfo['type'] == 'existing')
                                                <span style="color: #d1d5db;">•</span>
                                                <span style="color: #10b981; font-weight: 500;">Tersimpan</span>
                                            @elseif ($templateInfo['type'] == 'new' || $template)
                                                <span style="color: #d1d5db;">•</span>
                                                <span style="color: #f59e0b; font-weight: 500;">Baru diupload</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Right Section: Action Buttons -->
                            <div class="action-section"
                                style="display: flex !important;
                                align-items: center !important;
                                gap: 12px !important;
                                flex-shrink: 0 !important;
                                min-width: fit-content !important;">

                                <!-- Hover Overlay (Edit Mode) -->
                                @if ($editModeTemplate ?? false)
                                    <div class="image-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                                        style="background: linear-gradient(135deg, rgba(55, 65, 81, 0.9), rgba(75, 85, 99, 0.9)); 
                                        opacity: 0; 
                                        transition: opacity 0.3s ease; 
                                        border-radius: 10px;"
                                        onmouseover="this.style.opacity='1';" onmouseout="this.style.opacity='0';">
                                        <div class="text-white text-center">
                                            <div style="font-size: 0.875rem; font-weight: 500;">
                                                Klik untuk mengubah file
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Preview Button -->
                                @if (!($editModeTemplate ?? false))
                                    <button type="button"
                                        style="background: #10b981; 
                                        color: white; 
                                        border: none; 
                                        padding: 10px 18px; 
                                        border-radius: 8px; 
                                        font-weight: 500; 
                                        transition: all 0.2s ease; 
                                        cursor: pointer; 
                                        display: flex; 
                                        align-items: center; 
                                        gap: 8px;
                                        white-space: nowrap;"
                                        onmouseover="this.style.background='#059669'"
                                        onmouseout="this.style.background='#10b981'">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                        Preview
                                    </button>
                                @endif

                                <!-- Remove Button -->
                                @if ($editModeTemplate ?? false)
                                    <button type="button"
                                        wire:click.stop="{{ $template ? 'removeTemplateFile' : 'removeExistingTemplate' }}"
                                        onclick="event.stopPropagation();" wire:loading.attr="disabled"
                                        wire:target="removeTemplateFile, removeExistingTemplate" class="remove-btn"
                                        style="background: #fef2f2; 
                                        color: #dc2626; 
                                        border: 1px solid #fecaca;
                                        border-radius: 8px; 
                                        padding: 10px 18px; 
                                        z-index: 5;
                                        transition: all 0.2s ease; 
                                        cursor: pointer;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;"
                                        title="Hapus template" onmouseover="this.style.background='#fee2e2';"
                                        onmouseout="this.style.background='#fef2f2';">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <polyline points="3,6 5,6 21,6" />
                                            <path
                                                d="m19,6v14a2,2 0 0,1 -2,2H7a2,2 0 0,1 -2,-2V6m3,0V4a2,2 0 0,1 2,-2h4a2,2 0 0,1 2,2v2" />
                                            <line x1="10" y1="11" x2="10" y2="17" />
                                            <line x1="14" y1="11" x2="14" y2="17" />
                                        </svg>
                                        Hapus
                                    </button>
                                @endif
                            </div>
                        </div>

                    @endif
                </div>

                <!-- Hidden File Input -->
                <input type="file" id="template" wire:model="template" class="d-none"
                    accept=".pdf,.doc,.docx,.zip,.rar,.txt">
            </div>

        </div>
    </form>
</div>
