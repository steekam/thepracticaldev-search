<div wire:init="loadArticles">
    <header class="bg-white shadow">
        <div class="px-2 mx-auto max-w-7xl sm:px-4 lg:px-8">
            <div class="flex h-16">
                <div class="flex px-2 lg:px-0">
                    <div class="flex items-center flex-shrink-0">
                        <a href="/">
                            <x-icon-dev-logo />
                        </a>
                    </div>
                </div>

                <div class="flex items-center justify-center flex-1 px-2">
                    <div class="w-full sm:max-w-sm">
                        <label for="navbar-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <x-heroicon-o-search class="w-5 h-6 text-gray-400"/>
                            </div>
                            <form wire:submit.prevent="searchArticles">
                                <input autocomplete="off" id="navbar-search" name="query"
                                    wire:model.defer="query"
                                    class="block w-full py-2 pl-10 pr-3 text-sm placeholder-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none focus:text-gray-900 focus:placeholder-gray-400 focus:ring-1 focus:ring-gray-900 focus:border-gray-900 sm:text-sm"
                                    placeholder="Search" type="search">
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </header>

    <main class="container px-4 mx-auto sm:px-6 lg:px-8">
        <div class="max-w-5xl pb-10 mx-auto mt-10">
            <div class="flex items-center justify-between">
                <h1 class="text-4xl font-bold text-gray-900">
                    {{ empty($query) ? '20 Most Popular' : 'Search Results'  }}
                </h1>

                <div class="flex items-center space-x-4 text-gray-800">
                    @if(!empty($query))
                        @foreach ($sorting_options as $option)
                        <button wire:click="$set('active_sort', '{{ $option}}')"
                            class="pb-2 capitalize focus:outline-none focus:ring {{ $active_sort == $option ? 'border-b-4 border-gray-900' : ''}}"
                            onclick="this.blur()">
                            {{ $option }}
                        </button>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- Search results container --}}
            <div class="flex flex-col w-full mt-8 sm:max-w-4xl">
                <div class="space-y-6" wire:loading.remove wire:target="loadArticles, searchArticles">
                    @if($articles->isEmpty() && $ready_to_show)
                        {{-- When no results are found --}}
                        <div class="flex items-center justify-center w-full px-4 py-5 bg-white border border-gray-200 rounded-md sm:px-6">
                            <div class="w-auto h-72">
                                <img class="object-contain w-full h-full" src="{{ asset('img/not-found.svg') }}" alt="No results found">
                            </div>
                        </div>
                    @else
                        @foreach ($articles as $article)
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
                                    class="text-2xl font-medium text-gray-900 hover:underline">
                                    {{$article->title}}
                                </a>

                                    {{-- Tags --}}
                                    <div class="flex mt-2 space-x-3 text-sm">
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
                                            <x-heroicon-o-heart class="w-5 h-5 text-gray-700"/>
                                            <span class="text-gray-600">{{$article->positive_reactions_count ?? '0'}} reactions</span>
                                        </div>
                                        <div class="inline-flex items-center space-x-2">
                                            <x-heroicon-o-chat class="w-5 h-5 text-gray-700"/>
                                            <span class="text-gray-600">{{$article->comments_count ?? '0' }} comments</span>

                                            @if($article->comments_count > 0)
                                            <div class="inline-flex space-x-1 text-gray-600">
                                                ( <span class="text-green-600">{{ $article->positive_comments_count }} +ve</span>
                                                <span>/</span>
                                                <span class="text-red-600">{{ $article->negative_comments_count }} -ve</span> )
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>

                <div wire:loading wire:target="loadArticles, searchArticles">
                    <x-loading-articles/>
                </div>
            </div>
        </div>
    </main>
</div>


