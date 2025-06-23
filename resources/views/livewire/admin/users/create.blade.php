<form wire:submit.prevent="submit">
    <div class="mb-3">
        <label for="name" class="form-label">Name:</label>
        <input type="text" wire:model.defer="name" id="name" class="form-control">
        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="email" wire:model.defer="email" id="email" class="form-control">
        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label for="role" class="form-label">Role:</label>
        <select wire:model.defer="role" id="role" class="form-select">
            <option value="">Select Role</option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select>
        @error('role') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input type="password" wire:model.defer="password" id="password" class="form-control">
        @error('password') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="submit">
            <span wire:loading.remove wire:target="submit">Save changes</span>
            <span wire:loading wire:target="submit">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Loading...
            </span>
        </button>
    </div>
</form>

