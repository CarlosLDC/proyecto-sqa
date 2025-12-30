@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-8 bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-violet-600"
            data-testid="page-title">{{ __('Create New Post') }}</h1>

        <div class="bg-white/70 backdrop-blur-sm shadow-lg overflow-hidden sm:rounded-xl border border-white/20">
            <div class="px-6 py-8 sm:p-10">
                <form action="{{ route('posts.store') }}" method="POST" data-testid="create-post-form">
                    @include('posts.form')
                </form>
            </div>
        </div>
    </div>
@endsection