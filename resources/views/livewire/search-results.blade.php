<div class="max-w-5xl mx-auto mt-10">
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
    <div>
        @foreach ($this->articles as $article)
            <div>
                <div></div>

                <div>
                    <h2>{{$article->title}}</h2>
                </div>
            </div>
        @endforeach
    </div>
</div>
