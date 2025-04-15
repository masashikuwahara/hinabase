{{-- resources/views/auth/login.blade.php --}}
<x-guest-layout>
    @push('head')
        <title>管理画面ログイン</title>
    @endpush
    
    <div class="w-full max-w-sm bg-white dark:bg-gray-800 shadow-md rounded-lg p-8">
        <h2 class="text-xl font-semibold text-center text-gray-800 dark:text-white mb-6">管理画面ログイン</h2>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('メールアドレス')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('パスワード')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between mb-6">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">ログイン状態を保持</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-indigo-600 hover:underline dark:text-indigo-400" href="{{ route('password.request') }}">
                        パスワードを忘れた場合
                    </a>
                @endif
            </div>

            <x-primary-button class="w-full justify-center">
                ログイン
            </x-primary-button>
        </form>
    </div>
</x-guest-layout>
