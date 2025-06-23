<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header bg-light py-3">
            <h5 class="modal-title fw-bold" id="createModalLabel">
                <i class="bi bi-plus-circle me-2"></i>Tambah Produk Baru
            </h5>
            <button wire:click="resetForm" type="button" class="btn-close" data-bs-dismiss="modal"
                aria-label="Tutup"></button>
        </div>

        <div class="modal-body">

            <!-- Wizard Information -->
            <div
                style="position: relative; padding: 20px 10px; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-radius: 16px;  border: 1px solid #e2e8f0;">

                <!-- Step Indicators -->
                <div
                    style="display: flex; justify-content: space-between; align-items: flex-start; position: relative; max-width: 600px; margin: 0 auto;">
                    @for ($i = 1; $i <= $totalSteps; $i++)
                        <div
                            style="display: flex; flex-direction: column; align-items: center; flex: 1; position: relative;">

                            <!-- Step Circle - UKURAN TETAP -->
                            <div
                                style="width: 50px;  height: 50px;  border-radius: 50%;  display: flex;  align-items: center;  justify-content: center; 
                                font-weight: 700;  font-size: 1rem;  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);  position: relative;  z-index: 10; margin-bottom: 12px;
                                {{ $i < $currentStep
                                    ? 'background: linear-gradient(135deg, #10b981 0%, #059669 100%);  color: white;  box-shadow: 0 8px 25px rgba(16, 185, 129, 0.35), 0 0 0 4px rgba(16, 185, 129, 0.1);'
                                    : ($i == $currentStep
                                        ? 'background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);  color: white;  box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3), 0 0 0 4px rgba(59, 130, 246, 0.1);'
                                        : 'background: white; color: #94a3b8; border: 3px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);') }} ">

                                <!-- Step Icon/Number -->
                                @if ($i < $currentStep)
                                    <!-- Heroicon Check SVG -->
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.5 12.75L10.5 18.75L19.5 5.25" stroke="currentColor"
                                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                @elseif($i == $currentStep)
                                    <div style="position: relative;">
                                        {{ $i }}
                                        <!-- Animated Ring - POSISI TETAP -->
                                        <div
                                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 60px; height: 60px; border: 2px solid rgba(59, 130, 246, 0.3); border-radius: 50%; animation: pulse-ring 2.5s infinite;">
                                        </div>
                                    </div>
                                @else
                                    {{ $i }}
                                @endif
                            </div>

                            <!-- Step Title -->
                            <div
                                style="text-align: center; font-size: 0.875rem; font-weight: {{ $i <= $currentStep ? '600' : '500' }}; color: {{ $i <= $currentStep ? '#1e293b' : '#94a3b8' }};
                                margin-bottom: 6px;transition: all 0.3s ease;line-height: 1.2;min-height: 32px;display: flex;align-items: center;justify-content: center;">
                                @if ($i == 1)
                                    Informasi Produk
                                @elseif($i == 2)
                                    Upload Thumbnail
                                @elseif($i == 3)
                                    Upload Template
                                @endif
                            </div>

                            <!-- Connector Line - POSISI TETAP -->
                            @if ($i < $totalSteps)
                                <div
                                    style="position: absolute;top: 25px;left: calc(50% + 25px);right: calc(-50% + 25px);height: 3px;border-radius: 2px;z-index: 1;
                                    {{ $i < $currentStep ? 'background: linear-gradient(90deg, #10b981 0%, #059669 100%);' : 'background: #e2e8f0;' }}
                                    transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);">
                                    @if ($i < $currentStep)
                                        <div
                                            style="position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent); animation: line-flow 2s infinite;">
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endfor
                </div>


                <form wire:submit.prevent="submit" enctype="multipart/form-data">

                    <!-- STEP 1: Informasi Produk -->
                    @if ($currentStep == 1)
                    <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <label class="form-label fw-semibold text-dark mb-0">
                                        <i class="fas fa-tag me-1 text-primary"></i>Nama Produk
                                    </label>
                                    @if ($errors->has('nama'))
                                        <small class="text-danger fw-medium">{{ $errors->first('nama') }}</small>
                                    @endif
                                </div>
                                <input type="text" wire:model.live="nama"
                                    class="form-control form-control-lg @error('nama') is-invalid @enderror"
                                    maxlength="255" placeholder="Masukkan nama produk..."
                                    style="padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 15px;"
                                    onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 4px rgba(59, 130, 246, 0.1)'"
                                    onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                                <div class="form-text">
                                    <small class="text-muted">Maksimal 255 karakter</small>
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <label class="form-label fw-semibold text-dark mb-0">
                                        <i class="fas fa-layer-group me-1 text-primary"></i>Kategori
                                    </label>
                                    @if ($errors->has('kategori_id'))
                                        <small class="text-danger fw-medium">{{ $errors->first('kategori_id') }}</small>
                                    @endif
                                </div>
                                <select wire:model.live="kategori_id"
                                    class="form-select form-select-lg {{ $errors->has('kategori_id') ? 'is-invalid' : '' }}"
                                    style="padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 15px;"
                                    onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 4px rgba(59, 130, 246, 0.1)'"
                                    onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($kategoriList as $kategori)
                                        <option value="{{ $kategori->id }}">
                                            {{ $kategori->nama_kategori ?? $kategori->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">
                                    <small class="text-muted">Pilih kategori yang sesuai</small>
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <label class="form-label fw-semibold text-dark mb-0">
                                        <i class="fas fa-money-bill-wave me-1 text-primary"></i>Harga
                                    </label>
                                    @if ($errors->has('harga'))
                                        <small class="text-danger fw-medium">{{ $errors->first('harga') }}</small>
                                    @endif
                                </div>
                                <div class="input-group input-group-lg"
                                     style="border: 2px solid #e2e8f0; border-radius: 8px; overflow: hidden;"
                                     onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 4px rgba(59, 130, 246, 0.1)'"
                                     onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                                    <label class="input-group-text fw-semibold"
                                           style="background: #f8fafc; color: #475569; border: none; padding: 12px 16px; font-size: 15px;">
                                        Rp
                                    </label>
                                    <input type="text" wire:model.live="harga"
                                           class="form-control {{ $errors->has('harga') ? 'is-invalid' : '' }}"
                                           placeholder="0"
                                           style="border: none; padding: 12px 16px; font-size: 15px; outline: none;">
                                </div>
                                <div class="form-text">
                                    <small class="text-muted">Masukkan harga dalam Rupiah</small>
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <label class="form-label fw-semibold text-dark mb-0">
                                        <i class="fas fa-tags me-1 text-primary"></i>Diskon
                                    </label>
                                    @if ($errors->has('diskon'))
                                        <small class="text-danger fw-medium">{{ $errors->first('diskon') }}</small>
                                    @endif
                                </div>
                                <div class="input-group input-group-lg"
                                     style="border: 2px solid #e2e8f0; border-radius: 8px; overflow: hidden;"
                                     onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 4px rgba(59, 130, 246, 0.1)'"
                                     onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                                    <input type="text" wire:model.live="diskon"
                                           class="form-control {{ $errors->has('diskon') ? 'is-invalid' : '' }}"
                                           placeholder="0"
                                           min="0" max="100"
                                           style="border: none; padding: 12px 16px; font-size: 15px; outline: none;">
                                    <label class="input-group-text fw-semibold"
                                           style="background: #f8fafc; color: #475569; border: none; padding: 12px 16px; font-size: 15px;">
                                        %
                                    </label>
                                </div>
                                <div class="form-text">
                                    <small class="text-muted">Masukkan angka diskon (Opsional) </small>
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <label class="form-label fw-semibold text-dark mb-0">
                                        <i class="fas fa-toggle-on me-1 text-primary"></i>Status
                                    </label>
                                    @if ($errors->has('status'))
                                        <small class="text-danger fw-medium">{{ $errors->first('status') }}</small>
                                    @endif
                                </div>
                                <select wire:model.live="status"
                                    class="form-select form-select-lg {{ $errors->has('status') ? 'is-invalid' : '' }}"
                                    style="padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 15px;"
                                    onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 4px rgba(59, 130, 246, 0.1)'"
                                    onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="aktif">Aktif</option>
                                    <option value="tidak_aktif">Tidak Aktif</option>
                                </select>
                                <div class="form-text">
                                    <small class="text-muted">Status ketersediaan produk</small>
                                </div>
                            </div>
                        </div>
                    
                        
                    </div>
                    @endif

                    <!-- STEP 2: Gambar Produk -->
                    @if ($currentStep == 2)
                        <div class="row mt-3 justify-content-center">
                            <div class="col-12">
                                <div class="col-span-full">
                                    <div class="d-flex justify-content-between align-items-center m-2">
                                        <span
                                            style="background: #6b7280; color: #f9fafb; padding: 4px 8px; border-radius: 6px; font-size: 0.8rem; font-weight: 500;">
                                            @php
                                                $uploadedCount = !empty($thumbnail) ? 1 : 0;
                                            @endphp
                                            {{ $uploadedCount }}/1 Thumbnail
                                        </span>

                                        <div style="font-size: 0.7rem; color: #6b7280; line-height: 1.3;">
                                            <strong>Format:</strong> JPG, PNG, WEBP • <strong>Max:</strong> 2MB
                                        </div>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-12">

                                            <div class="upload-container position-relative"
                                                onclick="document.getElementById('thumbnail').click()"
                                                style="aspect-ratio: 30/9; {{ $thumbnail ? 'background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%); border: 2px solid #9ca3af;' : 'background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%); border: 2px dashed #9ca3af;' }} border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; overflow: hidden; transition: all 0.3s ease; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);"
                                                onmouseover="if (!this.querySelector('img')) { this.style.borderColor='#374151'; this.style.background='linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.15)'; }"
                                                onmouseout="if (!this.querySelector('img')) { this.style.borderColor='#9ca3af'; this.style.background='{{ $thumbnail ? 'linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%)' : 'linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%)' }}'; this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.1)'; }">

                                                <!-- Loading Overlay - Pindahkan ke luar kondisi -->
                                                <div wire:loading wire:target="thumbnail, removeFile"
                                                    wire:loading.class.remove="d-none" wire:loading.class="d-flex"
                                                    class=" d-none position-absolute w-100 h-100 d-flex align-items-center justify-content-center"
                                                    style="z-index: 20; background: rgba(255, 255, 255, 0.95); border-radius: 12px;">
                                                    <div class="text-center">
                                                        <div class="spinner-border mb-2" role="status"
                                                            style="width: 2rem; height: 2rem; color: #6b7280;">
                                                            <span class="visually-hidden">Loading...</span>
                                                        </div>
                                                        <div
                                                            style="font-size: 0.8rem; font-weight: 500; color: #4b5563;">
                                                            <span wire:loading wire:target="thumbnail">Mengupload
                                                                thumbnail...</span>
                                                            <span wire:loading wire:target="removeFile">Menghapus
                                                                thumbnail...</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                @error('thumbnail')
                                                    <div class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center"
                                                        style="background: rgba(254, 242, 242, 0.95); border: 2px solid #fca5a5; border-radius: 12px; z-index: 10;">
                                                        <div class="text-center px-3">
                                                            <!-- Error Icon -->
                                                            <div class="mb-2"
                                                                style="display: flex; justify-content: center; align-items: center;">
                                                                <div
                                                                    style="background: #ef4444; border-radius: 50%; padding: 8px;">
                                                                    <svg width="24" height="24"
                                                                        viewBox="0 0 24 24" fill="none" stroke="white"
                                                                        stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                        <path
                                                                            d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                                                                        <path d="M12 9v4" />
                                                                        <path d="m12 17 .01 0" />
                                                                    </svg>
                                                                </div>
                                                            </div>

                                                            @error('thumbnail')
                                                                <div
                                                                    style="font-size: 0.9rem; color: #dc2626; font-weight: 600; margin-bottom: 8px; line-height: 1.3;">
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

                                                <div wire:loading.remove wire:target="thumbnail, removeFile">
                                                    @if (!$thumbnail)
                                                        <!-- Empty State -->
                                                        <div class="upload-prompt text-center">
                                                            <div
                                                                style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                                                <div class="mb-3"
                                                                    style="display: flex; justify-content: center; align-items: center;">
                                                                    <svg width="48" height="48"
                                                                        viewBox="0 0 24 24" fill="none"
                                                                        stroke="#6b7280" stroke-width="1.5"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        style="opacity: 0.8;">
                                                                        <rect x="3" y="3" width="18"
                                                                            height="18" rx="2"
                                                                            ry="2" />
                                                                        <circle cx="9" cy="9" r="2" />
                                                                        <path
                                                                            d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21" />
                                                                    </svg>
                                                                </div>
                                                                <div
                                                                    style="font-size: 1rem; font-weight: 600; margin-bottom: 8px; color: #374151; text-align: center;">
                                                                    Klik untuk upload gambar
                                                                </div>
                                                                <small
                                                                    style="font-size: 0.8rem; color: #6b7280; text-align: center;">
                                                                    JPG, PNG, WEBP - Maksimal 2MB
                                                                </small>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <!-- Image Preview -->
                                                        <img src="{{ $thumbnail->temporaryUrl() }}"
                                                            style="width: 100%; height: 100%; object-fit: cover;"
                                                            alt="Preview Gambar">

                                                        <!-- Hover Overlay -->
                                                        <div class="image-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                                                            style="background: linear-gradient(135deg, rgba(55, 65, 81, 0.9), rgba(75, 85, 99, 0.9)); opacity: 0; transition: opacity 0.3s ease; border-radius: 12px;"
                                                            onmouseover="this.style.opacity='1';"
                                                            onmouseout="this.style.opacity='0';">
                                                            <div class="text-white text-center">
                                                                <i class="fas fa-edit mb-1"
                                                                    style="font-size: 1.2rem;"></i>
                                                                <div style="font-size: 0.8rem; font-weight: 500;">Klik
                                                                    untuk
                                                                    mengubah
                                                                    gambar</div>
                                                            </div>
                                                        </div>

                                                        <!-- Success Badge - Kiri Atas -->
                                                        <div
                                                            style="z-index: 15; position: absolute; top: 8px; left: 8px; background: linear-gradient(135deg, #10b981, #059669); color: white; border-radius: 6px; padding: 4px 8px; font-size: 0.7rem; font-weight: 500; display: flex; align-items: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">
                                                            <i class="fas fa-check me-1"
                                                                style="font-size: 0.6rem;"></i>
                                                            Uploaded
                                                        </div>

                                                        <!-- Remove Button - Kanan Atas -->
                                                        <button type="button" class="btn position-absolute"
                                                            wire:click.stop="removeFile('thumbnail')"
                                                            onclick="event.stopPropagation();"
                                                            style="z-index: 15; top: 8px; right: 8px; background: linear-gradient(135deg, rgba(239,68,68,0.95), rgba(220,38,38,0.95)); color: white; border: none; border-radius: 8px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(0,0,0,0.25); transition: all 0.2s ease;"
                                                            onmouseover="this.style.background='linear-gradient(135deg, rgba(220,38,38,1), rgba(185,28,28,1))'; this.style.transform='scale(1.1)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.35)';"
                                                            onmouseout="this.style.background='linear-gradient(135deg, rgba(239,68,68,0.95), rgba(220,38,38,0.95))'; this.style.transform='scale(1)'; this.style.boxShadow='0 2px 6px rgba(0,0,0,0.25)';"
                                                            title="Hapus gambar" wire:loading.attr="disabled"
                                                            wire:target="removeFile">
                                                            <!-- Ikon Trash -->
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="2"
                                                                stroke="currentColor"
                                                                style="width: 20px; height: 20px;">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                            </svg>
                                                        </button>

                                                        <!-- File Info Badge -->
                                                        <div class="position-absolute bottom-0 start-0 w-100 px-2 py-1"
                                                            style="background: linear-gradient(transparent, rgba(55, 65, 81, 0.9)); color: white; border-radius: 0 0 12px 12px;">
                                                            <div
                                                                style="font-size: 0.75rem; font-weight: 500; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                                                {{ Str::limit($thumbnail->getClientOriginalName(), 25) }}
                                                            </div>
                                                            <div style="font-size: 0.7rem; opacity: 0.9;">
                                                                {{ number_format($thumbnail->getSize() / 1024, 1) }} KB
                                                            </div>
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
                            </div>
                        </div>
                    @endif

                    @if ($currentStep == 3)
                        <div class="row mt-3 justify-content-center">
                            <div class="col-12">
                                <div class="col-span-full">
                                    <div class="d-flex justify-content-between align-items-center m-2">
                                        <span
                                            style="background: #6b7280; color: #f9fafb; padding: 4px 8px; border-radius: 6px; font-size: 0.8rem; font-weight: 500;">
                                            @php
                                                $uploadedCount = !empty($template) ? 1 : 0;
                                            @endphp
                                            {{ $uploadedCount }}/1 Template
                                        </span>

                                        <div style="font-size: 0.7rem; color: #6b7280; line-height: 1.3;">
                                            <strong>Format:</strong> ZIP, RAR • <strong>Max:</strong> 10MB
                                        </div>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-12">
                                            <div class="upload-container position-relative"
                                                onclick="document.getElementById('template').click()"
                                                style="aspect-ratio: 30/9; {{ $template ? 'background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%); border: 2px solid #9ca3af;' : 'background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%); border: 2px dashed #9ca3af;' }} border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; overflow: hidden; transition: all 0.3s ease; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);"
                                                onmouseover="if (!this.querySelector('.file-preview')) { this.style.borderColor='#374151'; this.style.background='linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.15)'; }"
                                                onmouseout="if (!this.querySelector('.file-preview')) { this.style.borderColor='#9ca3af'; this.style.background='{{ $template ? 'linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%)' : 'linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%)' }}'; this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.1)'; }">

                                                <!-- Loading Overlay -->
                                                <div wire:loading wire:target="template, removeFile"
                                                    wire:loading.class.remove="d-none" wire:loading.class="d-flex"
                                                    class="d-none position-absolute w-100 h-100 d-flex align-items-center justify-content-center"
                                                    style="z-index: 20; background: rgba(255, 255, 255, 0.95); border-radius: 12px;">
                                                    <div class="text-center">
                                                        <div class="spinner-border mb-2" role="status"
                                                            style="width: 2rem; height: 2rem; color: #6b7280;">
                                                            <span class="visually-hidden">Loading...</span>
                                                        </div>
                                                        <div
                                                            style="font-size: 0.8rem; font-weight: 500; color: #4b5563;">
                                                            <span wire:loading wire:target="template">Mengupload
                                                                template...</span>
                                                            <span wire:loading wire:target="removeFile">Menghapus
                                                                template...</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Error Message Overlay -->
                                                @error('template')
                                                    <div class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center"
                                                        style="background: rgba(254, 242, 242, 0.95); border: 2px solid #fca5a5; border-radius: 12px; z-index: 10;">
                                                        <div class="text-center px-3">
                                                            <!-- Error Icon -->
                                                            <div class="mb-2"
                                                                style="display: flex; justify-content: center; align-items: center;">
                                                                <div
                                                                    style="background: #ef4444; border-radius: 50%; padding: 8px;">
                                                                    <svg width="24" height="24"
                                                                        viewBox="0 0 24 24" fill="none" stroke="white"
                                                                        stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                        <path
                                                                            d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                                                                        <path d="M12 9v4" />
                                                                        <path d="m12 17 .01 0" />
                                                                    </svg>
                                                                </div>
                                                            </div>

                                                            <!-- Error Message -->
                                                            <div
                                                                style="font-size: 0.9rem; color: #dc2626; font-weight: 600; margin-bottom: 8px; line-height: 1.3;">
                                                                @if (!empty($message))
                                                                    {{ $message }}
                                                                @endif
                                                            </div>

                                                            <!-- Try Again Text -->
                                                            <div style="font-size: 0.75rem; color: #6b7280;">
                                                                Klik untuk mencoba lagi
                                                            </div>
                                                        </div>
                                                    </div>
                                                @enderror

                                                <div wire:loading.remove wire:target="template, removeFile">
                                                    @if (!$template)
                                                        <!-- Empty State -->
                                                        <div class="upload-prompt text-center">
                                                            <div
                                                                style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                                                <div class="mb-3"
                                                                    style="display: flex; justify-content: center; align-items: center;">
                                                                    <svg width="48" height="48"
                                                                        viewBox="0 0 24 24" fill="none"
                                                                        stroke="#6b7280" stroke-width="1.5"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        style="opacity: 0.8;">
                                                                        <path
                                                                            d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                                                        <polyline points="7,10 12,15 17,10" />
                                                                        <line x1="12" y1="15"
                                                                            x2="12" y2="3" />
                                                                    </svg>
                                                                </div>
                                                                <div
                                                                    style="font-size: 1rem; font-weight: 600; margin-bottom: 8px; color: #374151; text-align: center;">
                                                                    Klik untuk upload template
                                                                </div>
                                                                <small
                                                                    style="font-size: 0.8rem; color: #6b7280; text-align: center;">
                                                                    ZIP, RAR - Maksimal 10MB
                                                                </small>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <!-- File Preview -->
                                                        <div class="file-preview position-absolute w-100 h-100 d-flex align-items-center justify-content-center"
                                                            style="top: 0; left: 0;">

                                                            <!-- File Icon and Info Container -->
                                                            <div class="text-center">
                                                                <!-- File Icon -->
                                                                <div class="mb-3"
                                                                    style="display: flex; justify-content: center; align-items: center;">
                                                                    @php
                                                                        $extension = strtolower(
                                                                            pathinfo(
                                                                                $templateInfo['name'] ?? '',
                                                                                PATHINFO_EXTENSION,
                                                                            ),
                                                                        );
                                                                    @endphp

                                                                    @if (in_array($extension, ['zip', 'rar']))
                                                                        <div
                                                                            style="background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 12px; padding: 12px; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);">
                                                                            <svg width="48" height="48"
                                                                                viewBox="0 0 24 24" fill="none"
                                                                                stroke="white" stroke-width="1.5"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round">
                                                                                <path
                                                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                                            </svg>
                                                                        </div>
                                                                    @endif
                                                                </div>

                                                                <!-- File Info -->
                                                                @if ($templateInfo)
                                                                    <div style="font-size: 0.9rem; font-weight: 600; margin-bottom: 4px; color: #374151; max-width: 250px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;"
                                                                        title="{{ $templateInfo['name'] }}">
                                                                        {{ Str::limit($templateInfo['name'], 30) }}
                                                                    </div>
                                                                    <div style="font-size: 0.75rem; color: #6b7280;">
                                                                        {{ $templateInfo['size'] }} •
                                                                        {{ strtoupper($templateInfo['extension']) }}
                                                                    </div>
                                                                @endif
                                                            </div>

                                                            <!-- Hover Overlay -->
                                                            <div class="image-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                                                                style="background: linear-gradient(135deg, rgba(55, 65, 81, 0.9), rgba(75, 85, 99, 0.9)); opacity: 0; transition: opacity 0.3s ease; border-radius: 12px;"
                                                                onmouseover="this.style.opacity='1';"
                                                                onmouseout="this.style.opacity='0';">
                                                                <div class="text-white text-center">
                                                                    <i class="fas fa-edit mb-1"
                                                                        style="font-size: 1.2rem;"></i>
                                                                    <div style="font-size: 0.8rem; font-weight: 500;">
                                                                        Klik untuk
                                                                        mengubah
                                                                        template</div>
                                                                </div>
                                                            </div>

                                                            <!-- Success Badge - Kiri Atas -->
                                                            <div
                                                                style="position: absolute; top: 8px; left: 8px; background: linear-gradient(135deg, #10b981, #059669); color: white; border-radius: 6px; padding: 4px 8px; font-size: 0.7rem; font-weight: 500; display: flex; align-items: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); z-index: 15;">
                                                                <i class="fas fa-check me-1"
                                                                    style="font-size: 0.6rem;"></i>
                                                                Uploaded
                                                            </div>

                                                            <!-- Remove Button - Kanan Atas -->
                                                            <button type="button" class="btn position-absolute"
                                                                wire:click.stop="removeFile('template')"
                                                                onclick="event.stopPropagation();"
                                                                style="top: 8px; right: 8px; background: linear-gradient(135deg, rgba(239,68,68,0.95), rgba(220,38,38,0.95)); color: white; border: none; border-radius: 8px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(0,0,0,0.25); transition: all 0.2s ease; z-index: 15;"
                                                                onmouseover="this.style.background='linear-gradient(135deg, rgba(220,38,38,1), rgba(185,28,28,1))'; this.style.transform='scale(1.1)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.35)';"
                                                                onmouseout="this.style.background='linear-gradient(135deg, rgba(239,68,68,0.95), rgba(220,38,38,0.95))'; this.style.transform='scale(1)'; this.style.boxShadow='0 2px 6px rgba(0,0,0,0.25)';"
                                                                title="Hapus template" wire:loading.attr="disabled"
                                                                wire:target="removeFile">
                                                                <!-- Ikon Trash -->
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="2"
                                                                    stroke="currentColor"
                                                                    style="width: 20px; height: 20px;">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                                </svg>
                                                            </button>

                                                            <!-- File Info Badge - Bawah -->
                                                            <div class="position-absolute bottom-0 start-0 w-100 px-2 py-1"
                                                                style="background: linear-gradient(transparent, rgba(55, 65, 81, 0.9)); color: white; border-radius: 0 0 12px 12px;">
                                                                @if ($templateInfo)
                                                                    <div
                                                                        style="font-size: 0.75rem; font-weight: 500; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                                                        {{ Str::limit($templateInfo['name'], 25) }}
                                                                    </div>
                                                                    <div style="font-size: 0.7rem; opacity: 0.9;">
                                                                        {{ $templateInfo['size'] }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Hidden File Input -->
                                                <input type="file" id="template" wire:model="template"
                                                    class="d-none @error('template') is-invalid @enderror"
                                                    accept=".pdf,.doc,.docx,.zip,.rar,.txt">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
            </div>



            <!-- Navigation Buttons -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <!-- Kolom Tombol Sebelumnya -->
                <div style="width: 150px;">
                    @if ($currentStep > 1)
                        <button type="button" class="btn btn-outline-secondary" wire:click="previousStep">
                            <i class="fas fa-arrow-left me-2"></i> Sebelumnya
                        </button>
                    @endif
                </div>

                <!-- Informasi Status Langkah -->
                <div class="text-center flex-grow-1">
                    <p style="color: #6b7280; font-size: 0.875rem; margin: 0;">
                        @if ($currentStep == 1)
                            Step 1 dari 3 - Informasi Produk
                        @elseif($currentStep == 2)
                            Step 2 dari 3 - Upload Thumbnail
                        @elseif($currentStep == 3)
                            Step 3 dari 3 - Upload Template/File
                        @else
                            Semua langkah telah selesai
                        @endif
                    </p>
                </div>

                <!-- Kolom Tombol Selanjutnya / Simpan -->
                <div style="width: 150px; text-align: right;">
                    @if ($currentStep < $totalSteps)
                        <button type="button" class="btn btn-primary" wire:click="nextStep">
                            Selanjutnya <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    @else
                        <button type="submit" class="btn btn-success" wire:loading.attr="disabled"
                            wire:target="submit">
                            <span wire:loading.remove wire:target="submit">
                                <i class="fas fa-save me-2"></i> Simpan Produk
                            </span>
                            <span wire:loading wire:target="submit">
                                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                Menyimpan...
                            </span>
                        </button>
                    @endif
                </div>
            </div>

            </form>
        </div>
    </div>
</div>
