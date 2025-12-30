<nav class="sticky top-0 z-50 bg-white/70 backdrop-blur-xl border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <a href="{{ route('home') }}"
                    class="text-2xl font-black tracking-tighter bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-violet-600 hover:opacity-80 transition-opacity"
                    data-testid="nav-home">
                    LARA<span class="text-gray-900">FY</span>
                </a>
            </div>
            <div class="flex items-center space-x-2">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="text-gray-600 hover:text-indigo-600 px-4 py-2 rounded-xl text-sm font-bold transition-all hover:bg-gray-50"
                        data-testid="nav-dashboard">
                        {{ __('Dashboard') }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="text-gray-600 hover:text-red-600 px-4 py-2 rounded-xl text-sm font-bold transition-all hover:bg-red-50"
                            data-testid="nav-logout">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="bg-gray-900 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-gray-800 transition-all shadow-lg shadow-gray-200"
                        data-testid="nav-login">
                        {{ __('Log In') }}
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>