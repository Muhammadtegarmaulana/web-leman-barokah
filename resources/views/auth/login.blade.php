<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label class="block font-bold text-sm text-gray-700" for="email">Email</label>
            <input id="email" class="block mt-1 w-full rounded-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Masukkan email anda..." />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label class="block font-bold text-sm text-gray-700" for="password">Password</label>
            <input id="password" class="block mt-1 w-full rounded-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2"
                            type="password"
                            name="password"
                            required autocomplete="current-password" 
                            placeholder="********" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4 flex justify-between items-center">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
            </label>
            
            @if (Route::has('password.request'))
                <a class="underline text-sm text-indigo-600 hover:text-indigo-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Lupa Password?') }}
                </a>
            @endif
        </div>

        <div class="flex items-center justify-end mt-6">
            <button class="w-full justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-full shadow-lg transition transform hover:-translate-y-1">
                {{ __('Masuk Sekarang') }}
            </button>
        </div>

        <div class="mt-6 text-center border-t pt-4">
            <span class="text-sm text-gray-500">Belum punya akun?</span>
            <a href="{{ route('register') }}" class="text-indigo-600 font-bold hover:underline text-sm">
                Daftar Disini
            </a>
        </div>
    </form>
</x-guest-layout>