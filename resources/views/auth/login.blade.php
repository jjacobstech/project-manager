<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" wire:navigate>
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block w-full mt-1 text-black" type="email" name="email"
                :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block w-full mt-1 text-black" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center text-white">
                <input id="remember_me" type="checkbox"
                    class="text-teal-600 border-gray-300 rounded shadow-sm dark:bg-gray-900 dark:border-gray-700 focus:ring-teal-500 dark:focus:ring-teal-600 dark:focus:ring-offset-tel-800 checked:bg-teal"
                    name="remember">
                <span class="text-sm text-white ms-2 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="text-sm text-white underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 hover:text-gray-400"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>

        </div>

    </form>
    <div
        class="flex items-center justify-end mt-4 text-sm text-white rounded-md dark:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 ">

        {{ __("Don't have an account?") }}
        <a href="{{ url('/register') }}" wire:navigate>
            <x-primary-button class="ms-3">
                {{ __('Register') }}
            </x-primary-button>

        </a>


    </div>
</x-guest-layout>
