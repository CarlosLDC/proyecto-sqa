@extends('layouts.app')

@section('content')
    <div class="mb-10 text-center md:text-left">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-4 tracking-tight" data-testid="page-title">
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-violet-600">
                {{ __('Latest Posts') }}
            </span>
        </h1>
    </div>

    @if($posts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10" data-testid="post-list">
            @foreach ($posts as $post)
                <article
                    class="group bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 flex flex-col h-full"
                    data-testid="post-item-{{ $post->id }}">

                    <!-- Image Header -->
                    <div class="relative aspect-[16/10] overflow-hidden">
                        <img src="{{ $post->featured_image ?? 'https://picsum.photos/seed/' . $post->id . '/800/600' }}"
                            alt="{{ $post->title }}"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>

                        <div class="absolute top-4 left-4">
                            <span
                                class="px-3 py-1.5 rounded-xl bg-white/90 backdrop-blur-md text-indigo-700 text-[10px] font-extrabold uppercase tracking-widest shadow-lg">
                                {{ $post->category->name }}
                            </span>
                        </div>
                    </div>

                    <div class="p-8 flex-grow flex flex-col">
                        <div class="flex items-center text-[11px] font-medium text-gray-400 mb-4 tracking-wide uppercase">
                            <svg class="h-3 w-3 mr-1.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 0 00-2-2H5a2 0 00-2 2v12a2 0 002 2z"></path>
                            </svg>
                            {{ $post->published_at->locale('es')->isoFormat('D [de] MMMM, YYYY') }}
                        </div>

                        <h2
                            class="text-2xl font-extrabold text-gray-900 mb-4 leading-tight group-hover:text-indigo-600 transition-colors line-clamp-2">
                            {{ $post->title }}
                        </h2>

                        <p class="text-gray-500 mb-8 line-clamp-3 text-sm leading-relaxed flex-grow">
                            {{ $post->excerpt }}
                        </p>

                        <div class="flex items-center justify-between mt-auto pt-6 border-t border-gray-50">
                            <div class="flex items-center">
                                <div
                                    class="h-9 w-9 rounded-full bg-gradient-to-br from-indigo-500 to-violet-500 flex items-center justify-center text-white font-bold text-xs uppercase shadow-md ring-2 ring-white">
                                    {{ substr($post->user->name, 0, 2) }}
                                </div>
                                <div class="ml-3 text-xs font-bold text-gray-900 tracking-tight">
                                    {{ $post->user->name }}
                                </div>
                            </div>

                            <a href="{{ route('posts.show', $post) }}"
                                class="inline-flex items-center text-indigo-600 text-xs font-black uppercase tracking-widest hover:text-indigo-800 transition-colors"
                                data-testid="read-more-{{ $post->id }}">
                                {{ __('Read More') }}
                                <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-12" data-testid="pagination">
            {{ $posts->links() }}
        </div>
    @else
        <div class="bg-white/70 backdrop-blur-sm p-12 rounded-xl border border-gray-100 text-center text-gray-500 shadow-sm">
            <p class="text-lg">{{ __('No posts found') }}</p>
        </div>
    @endif
@endsection