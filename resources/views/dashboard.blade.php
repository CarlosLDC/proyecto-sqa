@extends('layouts.app')

@section('content')
    <div class="space-y-12">
        <header class="flex flex-col md:flex-row md:items-end justify-between gap-6 pb-8 border-b border-gray-100">
            <div>
                <h1 class="text-4xl font-black text-gray-900 tracking-tight" data-testid="dashboard-title">{{ __('Dashboard') }}
                </h1>
                <div class="mt-2 flex items-center space-x-3">
                    <p class="text-gray-500 font-medium">{{ __('Welcome back, :name', ['name' => auth()->user()->name]) }}</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-indigo-100 text-indigo-700">
                        {{ __(ucfirst(auth()->user()->role)) }}
                    </span>
                </div>
            </div>
            <a href="{{ route('posts.create') }}"
                class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-black rounded-2xl shadow-xl text-white bg-indigo-600 hover:bg-indigo-700 transition-all transform hover:scale-105 active:scale-95"
                data-testid="create-post-btn">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                {{ __('Create New Post') }}
            </a>
        </header>

        <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden" data-testid="dashboard-table">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                {{ __('Title') }}</th>
                            <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                {{ __('Category') }}</th>
                            <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                {{ __('Status') }}</th>
                            <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                {{ __('Author') }}</th>
                            <th class="px-8 py-5 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 bg-white">
                        @foreach ($posts as $post)
                            <tr class="hover:bg-gray-50/80 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="text-sm font-bold text-gray-900 mb-1 group-hover:text-indigo-600 transition-colors">
                                        {{ $post->title }}</div>
                                    <div class="text-[10px] font-medium text-gray-400 uppercase tracking-wide">
                                        {{ $post->published_at ? $post->published_at->locale('es')->isoFormat('D MMM, YYYY') : __('Draft') }}
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-gray-100 text-gray-600">
                                        {{ $post->category->name }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    @if ($post->status === 'published')
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-green-100 text-green-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-2"></span>
                                            {{ __('Published') }}
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-amber-100 text-amber-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-2"></span>
                                            {{ __('Draft') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center">
                                        <div
                                            class="h-8 w-8 rounded-full bg-gradient-to-br from-indigo-100 to-violet-100 flex items-center justify-center text-indigo-700 font-bold text-[10px] uppercase shadow-sm border border-white">
                                            {{ substr($post->user->name, 0, 2) }}
                                        </div>
                                        <span class="ml-3 text-sm font-bold text-gray-700">{{ $post->user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right space-x-2 text-nowrap">
                                    <a href="{{ route('posts.edit', $post) }}"
                                        class="inline-flex items-center p-2 rounded-xl text-indigo-600 hover:bg-indigo-50 transition-colors"
                                        title="{{ __('Edit') }}"
                                        data-testid="edit-post-{{ $post->id }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                            </path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline"
                                        onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center p-2 rounded-xl text-red-600 hover:bg-red-50 transition-colors"
                                            title="{{ __('Delete') }}"
                                            data-testid="delete-post-{{ $post->id }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($posts->hasPages())
                <div class="px-8 py-6 bg-gray-50 border-t border-gray-100">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection