<div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header bg-light py-3">
            <h5 class="modal-title fw-bold" id="createModalLabel">
                <i class="bi bi-plus-circle me-2"></i>Edit Kategori
            </h5>
            <button wire:click="resetForm" type="button" class="btn-close" data-bs-dismiss="modal"
                aria-label="Tutup"></button>
        </div>

        <div class="modal-body">

            <form wire:submit.prevent="update">

                {{-- Input Nama Kategori --}}
                <div class="mb-4">
                    <label for="nama_kategori" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                    <input type="text" id="nama_kategori" wire:model.live="nama_kategori"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Contoh: Elektronik">
                    @error('nama_kategori')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Tombol Simpan --}}
                <div class="modal-footer">
                    <button wire:click="resetForm" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="submit">
                        <span wire:loading.remove wire:target="submit">Simpan</span>
                        <span wire:loading wire:target="submit">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
