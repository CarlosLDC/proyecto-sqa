@csrf

<div class="space-y-6">
    <div>
        <label for="featured_image"
            class="block text-sm font-bold text-gray-700 mb-2">{{ __('Featured Image URL') }}</label>
        <div class="mt-1">
            <input type="url" name="featured_image" id="featured_image"
                value="{{ old('featured_image', $post->featured_image ?? '') }}"
                placeholder="https://example.com/image.jpg"
                class="shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg px-4 py-3 transition-all bg-white/50 backdrop-blur-sm"
                data-testid="featured-image-input">
        </div>
        @error('featured_image')
            <p class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded-md border border-red-100">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="title" class="block text-sm font-bold text-gray-700 mb-2">{{ __('Title') }}</label>
        <div class="mt-1">
            <input type="text" name="title" id="title" value="{{ old('title', $post->title ?? '') }}" required
                class="shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg px-4 py-3 transition-all bg-white/50 backdrop-blur-sm"
                data-testid="title-input">
        </div>
        @error('title')
            <p class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded-md border border-red-100">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="category_id" class="block text-sm font-bold text-gray-700 mb-2">{{ __('Category') }}</label>
        <div class="mt-1">
            <select id="category_id" name="category_id" required
                class="shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg px-4 py-3 transition-all bg-white/50 backdrop-blur-sm"
                data-testid="category-select">
                <option value="">{{ __('Select a Category') }}</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $post->category_id ?? '') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        @error('category_id')
            <p class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded-md border border-red-100">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="excerpt" class="block text-sm font-bold text-gray-700 mb-2">{{ __('Excerpt') }}</label>
        <div class="mt-1">
            <textarea id="excerpt" name="excerpt" rows="3"
                class="shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg px-4 py-3 transition-all bg-white/50 backdrop-blur-sm"
                data-testid="excerpt-input">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
        </div>
        @error('excerpt')
            <p class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded-md border border-red-100">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="content" class="block text-sm font-bold text-gray-700 mb-2">{{ __('Content') }}</label>
        <div class="mt-1">
            <textarea id="content" name="content" rows="10" required
                class="shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg px-4 py-3 transition-all bg-white/50 backdrop-blur-sm font-mono text-sm leading-relaxed"
                data-testid="content-input">{{ old('content', $post->content ?? '') }}</textarea>
        </div>
        @error('content')
            <p class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded-md border border-red-100">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="status" class="block text-sm font-bold text-gray-700 mb-2">{{ __('Status') }}</label>
            <div class="mt-1">
                <select id="status" name="status" required
                    class="shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg px-4 py-3 transition-all bg-white/50 backdrop-blur-sm"
                    data-testid="status-select">
                    <option value="draft" {{ old('status', $post->status ?? '') == 'draft' ? 'selected' : '' }}>
                        {{ __('Draft') }}
                    </option>
                    <option value="published" {{ old('status', $post->status ?? '') == 'published' ? 'selected' : '' }}>
                        {{ __('Published') }}
                    </option>
                </select>
            </div>
            @error('status')
                <p class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded-md border border-red-100">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="published_at"
                class="block text-sm font-bold text-gray-700 mb-2">{{ __('Published At') }}</label>
            <div class="mt-1">
                <input type="datetime-local" name="published_at" id="published_at"
                    value="{{ old('published_at', isset($post->published_at) ? $post->published_at->format('Y-m-d\TH:i') : '') }}"
                    class="shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg px-4 py-3 transition-all bg-white/50 backdrop-blur-sm"
                    data-testid="published-at-input">
            </div>
            @error('published_at')
                <p class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded-md border border-red-100">{{ $message }}</p>
            @enderror
        </div>
    </div>

    @if(isset($users) && count($users) > 0)
        <div>
            <label for="user_id" class="block text-sm font-bold text-gray-700 mb-2">{{ __('Author') }}</label>
            <div class="mt-1">
                <select id="user_id" name="user_id" required
                    class="shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg px-4 py-3 transition-all bg-white/50 backdrop-blur-sm"
                    data-testid="author-select">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $post->user_id ?? auth()->id()) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>
            @error('user_id')
                <p class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded-md border border-red-100">{{ $message }}</p>
            @enderror
        </div>
    @endif

    <div class="flex justify-end pt-4 border-t border-gray-200">
        <a href="{{ route('dashboard') }}"
            class="bg-white py-2.5 px-6 border border-gray-300 rounded-lg shadow-sm text-sm font-bold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-4 transition-colors">
            {{ __('Cancel') }}
        </a>
        <button type="submit"
            class="inline-flex justify-center py-2.5 px-6 border border-transparent shadow-sm text-sm font-bold rounded-lg text-white bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:scale-105"
            data-testid="submit-post">
            {{ isset($post) ? __('Update Post') : __('Create Post') }}
        </button>
    </div>
</div>