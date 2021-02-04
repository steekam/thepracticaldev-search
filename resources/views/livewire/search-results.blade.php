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
    <div class="flex flex-col w-full mt-8 space-y-8 sm:max-w-4xl">
        @foreach ($this->articles as $article)
            <div class="w-full px-3 py-3 space-y-2 bg-white border border-gray-200 rounded-md">
                <div class="flex">
                    <a href="https://dev.to/{{$article->user->username}}">
                        <img src="{{ $article->user->profile_image }}" alt="author profile image" class="rounded-full w-9 h-9">
                    </a>

                    <div class="flex flex-col ml-3">
                        <a href="https://dev.to/{{$article->user->username}}" class="text-sm leading-5 text-gray-800 hover:text-black">
                            {{ $article->user->name }}
                        </a>
                        <a href="{{ $article->url }}" class="text-xs text-gray-500 hover:text-gray-900">
                            {{ $article->published_timestamp->toFormattedDateString() }}
                        </a>
                    </div>
                </div>

                <div class="pl-12">
                    <a href="{{ $article->url }}" class="text-2xl font-medium text-gray-900 hover:text-indigo-500">{{$article->title}}</h2>

                    {{-- Tags --}}
                    <div class="flex mt-2 -ml-3 space-x-3 text-sm">
                        @foreach($article->tags_list as $tag)
                            <a href="https://dev.to/t/{{$tag}}" class="px-2 border border-gray-700 rounded-full hover:border-gray-900 p-y-px">
                                <span class="text-gray-400 text-opacity-90">#</span><span class="text-gray-600 hover:text-gray-900">{{ $tag }}</span>
                            </a>
                        @endforeach
                    </div>

                    {{-- Description --}}
                    <div></div>

                    {{-- Statistics: reaction_count, comments, positive, negative --}}
                </div>
            </div>
        @endforeach
    </div>
</div>
