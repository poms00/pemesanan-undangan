<div class="container min-vh-100 d-flex align-items-center justify-content-center bg-light">
    <div class="w-100" style="max-width: 480px;">
        <div class="card shadow">
            <div class="card-body p-4">
                <h1 class="h4 text-center mb-4 text-primary">Register</h1>

                <form wire:submit.prevent="register">
                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input wire:model.live="name" type="text" class="form-control" id="name" required autofocus>
                        @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input wire:model.live="email" type="email" class="form-control" id="email" required>
                        @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input wire:model.live="password" type="password" class="form-control" id="password" required>
                        @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <!-- Submit -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ route('login') }}" class="small text-decoration-none" wire:navigate>
                            Already registered?
                        </a>
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
