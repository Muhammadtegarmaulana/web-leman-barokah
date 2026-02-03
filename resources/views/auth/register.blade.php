<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label class="block font-bold text-sm text-gray-700" for="name">Nama Lengkap</label>
            <input id="name" class="block mt-1 w-full rounded-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama Anda" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label class="block font-bold text-sm text-gray-700" for="email">Email</label>
            <input id="email" class="block mt-1 w-full rounded-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="email@contoh.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label class="block font-bold text-sm text-gray-700" for="password">Password</label>
            <input id="password" class="block mt-1 w-full rounded-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2"
                            type="password"
                            name="password"
                            required autocomplete="new-password" 
                            placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label class="block font-bold text-sm text-gray-700" for="password_confirmation">Konfirmasi Password</label>
            <input id="password_confirmation" class="block mt-1 w-full rounded-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2"
                            type="password"
                            name="password_confirmation"
                            required autocomplete="new-password"
                            placeholder="Ulangi password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <button class="w-full justify-center bg-gray-800 hover:bg-black text-white font-bold py-3 px-4 rounded-full shadow-lg transition transform hover:-translate-y-1">
                {{ __('Daftar Akun Baru') }}
            </button>
        </div>

        <div class="mt-6 text-center border-t pt-4">
            <span class="text-sm text-gray-500">Sudah punya akun?</span>
            <a href="{{ route('login') }}" class="text-indigo-600 font-bold hover:underline text-sm">
                Masuk Disini
            </a>
        </div>
    </form>
</x-guest-layout>