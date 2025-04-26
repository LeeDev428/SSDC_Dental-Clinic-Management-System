<x-guest-layout>
    @section('title', 'Register')
    @vite('resources/css/alreadyregistered.css')

    <!-- Font Awesome CDN for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <div class="bg-white rounded-lg shadow-lg flex flex-col md:flex-row w-full max-w-4xl mx-auto mt-6 overflow-hidden">

        <!-- Register Form (Now Appears First on Mobile) -->
        <div class="w-full md:w-3/5 p-6 md:p-10 order-1 md:order-2">
            <h2 class="text-2xl font-bold text-gray-900 text-center">Create an Account</h2>
            <p class="text-center text-gray-600 mt-2">Sign up to get started</p>

           

            <form method="POST" action="{{ route('register') }}" class="mt-3">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <x-input-label for="name" :value="__('Name')" class="text-md" />
                    <x-text-input id="name" class="block mt-1 w-full p-2.5 text-md border border-gray-300 rounded-md" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-500" />
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" class="text-md" />
                    <x-text-input id="email" class="block mt-1 w-full p-2.5 text-md border border-gray-300 rounded-md" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Password')" class="text-md" />
                    <x-text-input id="password" class="block mt-1 w-full p-2.5 text-md border border-gray-300 rounded-md" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-500" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-md" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full p-2.5 text-md border border-gray-300 rounded-md" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-500" />
                </div>

                <!-- Register Button -->
                <div>
                    <x-primary-button class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-md">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
<br>
<br>
        <!-- Welcome Section (Now Below the Form on Mobile) -->
        <div class="flex flex-col items-center justify-center text-center p-6 md:w-2/5 bg-gradient-to-r from-blue-600 to-green-400 text-white md:rounded-l-lg order-2 md:order-1">
            <h3 class="text-xl font-bold">Welcome Back!</h3>
            <p class="mt-3 text-md">Already have an account? Log in and keep your smile on track!</p>
            <a href="{{ route('login') }}" class="mt-4 bg-white text-blue-600 hover:bg-gray-100 px-5 py-2 rounded-md text-md font-bold">
                Log In
            </a>
        </div>

    </div>
    <br>
    <br>
    
</x-guest-layout>
