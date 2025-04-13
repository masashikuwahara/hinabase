@auth
    <div class="relative">
        <button class="font-bold">{{ Auth::user()->name }}</button>
        <div class="absolute right-0 mt-2 bg-white border rounded shadow-lg">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-100">ログアウト</button>
            </form>
        </div>
    </div>
@endauth