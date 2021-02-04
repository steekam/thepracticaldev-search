<div class="max-w-5xl pb-10 mx-auto mt-10">
    <div class="flex items-center justify-between">
        <h1 class="text-4xl font-bold text-gray-900">Search Results</h1>

        <div class="flex items-center space-x-4 text-gray-800">
            @foreach ($sorting_options as $option)
            <button wire:click="$set('active_sort', '{{ $option}}')"
                class="pb-2 capitalize focus:outline-none focus:ring {{ $active_sort == $option ? 'border-b-4 border-gray-900' : ''}}"
                onclick="this.blur()">
                {{ $option }}
            </button>
            @endforeach
        </div>
    </div>

    {{-- Search results container --}}
    <div class="flex flex-col w-full mt-8 space-y-6 sm:max-w-4xl">
        @foreach ($this->articles as $article)
        <div class="w-full px-4 py-5 space-y-2 bg-white border border-gray-200 rounded-md sm:px-6">
            <div class="flex space-x-3">
                <a href="https://dev.to/{{$article->user->username}}">
                    <img src="{{ $article->user->profile_image }}" alt="author profile image"
                        class="w-10 h-10 rounded-full">
                </a>

                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900">
                        <a href="https://dev.to/{{$article->user->username}}" class="hover:underline">
                            {{ $article->user->name }}
                        </a>
                    </p>
                    <p class="text-sm text-gray-500">
                        <a href="{{ $article->url }}" class="hover:underline">
                            {{ $article->published_timestamp->toFormattedDateString() }}
                        </a>
                    </p>
                </div>
            </div>

            <div class="pl-12">
                <a href="{{ $article->url }}"
                    class="text-2xl font-medium text-gray-900 hover:underline">{{$article->title}}</h2>

                    {{-- Tags --}}
                    <div class="flex mt-2 -ml-3 space-x-3 text-sm">
                        @foreach($article->tags_list as $tag)
                        <a href="https://dev.to/t/{{$tag}}"
                            class="px-2 border border-gray-700 rounded-full hover:border-gray-900 p-y-px">
                            <span class="text-gray-400 text-opacity-90">#</span><span
                                class="text-gray-600 hover:text-gray-900">{{ $tag }}</span>
                        </a>
                        @endforeach
                    </div>

                    {{-- Description --}}
                    <p class="mt-4 text-lg text-gray-900"> {{ $article->description }} </p>

                    {{-- Statistics: reaction_count, comments, positive, negative --}}
                    <div class="flex items-center mt-4 space-x-6">
                        <div class="inline-flex space-x-2">
                            <x-heroicon-o-heart class="w-5 h-5 text-gray-700"/><span class="text-gray-600">{{$article->positive_reactions_count ?? '0'}} reactions</span>
                        </div>
                        <div class="inline-flex items-center space-x-2">
                            <x-heroicon-o-chat class="w-5 h-5 text-gray-700"/><span class="text-gray-600">{{$article->comments_count ?? '0' }} comments</span>
                        </div>
                    </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
