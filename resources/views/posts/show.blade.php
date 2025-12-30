@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">
        <a href="{{ route('home') }}"
            class="inline-flex items-center text-sm font-bold text-indigo-600 hover:text-indigo-800 transition-colors mb-8 group"
            data-testid="back-link">
            <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            {{ __('Back to all posts') }}
        </a>

        <article class="bg-white rounded-[2rem] shadow-2xl border border-gray-100 overflow-hidden"
            data-testid="post-detail">

            <div class="relative h-[400px] w-full">
                <img src="{{ $post->featured_image ?? 'https://picsum.photos/seed/' . $post->id . '/1200/800' }}"
                    alt="{{ $post->title }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-white via-transparent to-transparent"></div>
            </div>

            <div class="p-8 md:p-16 -mt-20 relative z-10">
                <header class="mb-12">
                    <div class="flex items-center space-x-3 text-sm mb-6">
                        <span
                            class="px-3 py-1.5 rounded-xl bg-indigo-50 text-indigo-700 font-extrabold uppercase tracking-widest text-[10px]">
                            {{ $post->category->name }}
                        </span>
                        <span class="text-gray-300">&bull;</span>
                        <time datetime="{{ $post->published_at->toIso8601String() }}" class="text-gray-500 font-medium">
                            {{ $post->published_at->locale('es')->isoFormat('D [de] MMMM, YYYY') }}
                        </time>
                    </div>

                    <h1 class="text-4xl md:text-6xl font-black text-gray-900 mb-8 leading-tight tracking-tight"
                        data-testid="post-title">
                        {{ $post->title }}
                    </h1>

                    <div class="flex items-center p-4 bg-gray-50 rounded-2xl w-fit">
                        <div
                            class="h-12 w-12 rounded-full bg-gradient-to-br from-indigo-500 to-violet-500 flex items-center justify-center text-white font-black text-sm uppercase shadow-lg ring-4 ring-white">
                            {{ substr($post->user->name, 0, 2) }}
                        </div>
                        <div class="ml-4">
                            <div class="text-[10px] uppercase tracking-widest font-black text-gray-400 mb-0.5">
                                {{ __('Written By') }}
                            </div>
                            <div class="text-sm font-bold text-gray-900">{{ $post->user->name }}</div>
                        </div>
                    </div>
                </header>

                <div class="prose prose-xl prose-indigo max-w-none text-gray-700 leading-relaxed font-medium"
                    data-testid="post-content">
                    {!! nl2br(e($post->content)) !!}
                </div>
            </div>
        </article>
    </div>
@endsection