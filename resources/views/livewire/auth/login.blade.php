<div class="tw-min-h-screen tw-flex tw-items-center tw-justify-center tw-bg-gray-100">
    <div class="tw-w-full tw-max-w-md tw-px-6 tw-py-8 tw-bg-white tw-rounded-lg tw-shadow-md">

        <h1 class="tw-text-3xl tw-font-bold tw-text-center tw-mb-6 text-indigo-600">Login</h1>

        <!-- Session Status -->
        <x-auth-session-status class="tw-mb-4" :status="session('status')" />

        <form wire:submit.prevent="login">
            <!-- Email -->
            <div class="tw-mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input wire:model.live="form.email" id="email" type="email" name="email"
                    class="tw-block tw-w-full tw-mt-1" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('form.email')" class="tw-mt-2" />
            </div>

            <!-- Password -->
            <div class="tw-mb-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input wire:model.live="form.password" id="password" type="password" name="password"
                    class="tw-block tw-w-full tw-mt-1" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('form.password')" class="tw-mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="tw-flex tw-items-center tw-justify-between tw-mb-4">
                <label for="remember" class="tw-inline-flex tw-items-center">
                    <input wire:model.live="form.remember" id="remember" type="checkbox"
                        class="tw-rounded tw-border-gray-300 tw-text-indigo-600 tw-shadow-sm focus:tw-ring-indigo-500" />
                    <span class="tw-ml-2 tw-text-sm tw-text-gray-600">{{ __('Remember me') }}</span>
                </label>

                <a href="{{ route('password.request') }}" class="tw-text-sm tw-text-indigo-500 hover:tw-underline">
                    Forgot Password?
                </a>
            </div>

            <!-- Submit Button -->
            <div class="tw-mt-6">
                <x-primary-button class="tw-w-full">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>