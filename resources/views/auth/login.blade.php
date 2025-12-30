@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto" data-testid="login-container">
        <div class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 overflow-hidden">
            <div class="px-10 py-12">
                <div class="text-center mb-10">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 rounded-3xl bg-indigo-50 text-indigo-600 mb-6 shadow-inner">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>
                    <h2 class="text-4xl font-black text-gray-900 tracking-tight" data-testid="login-header">
                        {{ __('Welcome Back') }}
                    </h2>
                    <p class="mt-3 text-gray-500 font-medium">{{ __('Sign in to manage your posts') }}</p>
                </div>

                @if ($errors->any())
                    <div class="mb-8 bg-red-50 rounded-2xl p-4 border border-red-100" data-testid="login-errors">
                        <ul class="text-sm text-red-600 font-bold space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store') }}" data-testid="login-form" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email"
                            class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">{{ __('Email Address') }}</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                            class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:bg-white focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 transition-all outline-none font-medium placeholder-gray-400"
                            placeholder="nombre@ejemplo.com" data-testid="email-input">
                    </div>

                    <div>
                        <label for="password"
                            class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">{{ __('Password') }}</label>
                        <input type="password" name="password" id="password" required
                            class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:bg-white focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 transition-all outline-none font-medium placeholder-••••••••"
                            data-testid="password-input">
                    </div>

                    <div class="flex items-center justify-between ml-1 pt-2">
                        <label class="flex items-center cursor-pointer group">
                            <input id="remember_me" name="remember" type="checkbox"
                                class="w-5 h-5 rounded-lg border-gray-200 text-indigo-600 focus:ring-indigo-600/20 transition-all cursor-pointer"
                                data-testid="remember-me">
                            <span
                                class="ml-3 text-sm font-bold text-gray-600 group-hover:text-gray-900 transition-colors">{{ __('Remember Me') }}</span>
                        </label>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full flex justify-center py-4 px-6 rounded-2xl shadow-xl text-sm font-black text-white bg-indigo-600 hover:bg-indigo-700 transition-all transform hover:scale-[1.02] active:scale-[0.98]"
                            data-testid="login-submit">
                            {{ __('Sign in') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection