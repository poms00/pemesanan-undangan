<div class="min-vh-100 d-flex align-items-center justify-content-center bg-light">
    <div class="w-100" style="max-width: 400px;">
        <div class="card shadow">
            <div class="card-body p-4">
                <h1 class="h3 text-center text-primary mb-4">Login</h1>

                {{-- Session Status --}}
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <form wire:submit.prevent="login">
                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input wire:model.live="form.email" type="email" class="form-control" id="email" required autofocus>
                        @error('form.email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input wire:model.live="form.password" type="password" class="form-control" id="password" required>
                        @error('form.password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Remember Me --}}
                    <div class="mb-3 form-check d-flex justify-content-between align-items-center">
                        <div>
                            <input wire:model.live="form.remember" type="checkbox" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>
                        <a href="{{ route('register') }}" class="small text-decoration-none">Register</a>

                    </div>

                    {{-- Submit --}}
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            Log in
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
