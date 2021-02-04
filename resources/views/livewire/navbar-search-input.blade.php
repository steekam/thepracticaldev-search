<div class="flex items-center justify-center flex-1 px-2">
    <div class="w-full sm:max-w-sm">
        <label for="navbar-search" class="sr-only">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <x-heroicon-o-search class="w-5 h-6 text-gray-400"/>
            </div>
            <input autocomplete="off" id="navbar-search" name="query"
                wire:model.defer="query"
                wire:keydown.enter="$set('query', $event.target.value)"
                class="block w-full py-2 pl-10 pr-3 text-sm placeholder-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none focus:text-gray-900 focus:placeholder-gray-400 focus:ring-1 focus:ring-gray-900 focus:border-gray-900 sm:text-sm"
                placeholder="Search" type="search">
        </div>
    </div>
</div>
