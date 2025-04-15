@auth
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 text-xl font-bold">
                    管理パネル
                </div>
                <div class="flex items-center space-x-4">
                    <span class="font-medium text-gray-800">{{ Auth::user()->name }} さん</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                            ログアウト
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
@endauth
