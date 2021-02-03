<x-layouts.base>
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
                        <label for="search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <x-heroicon-o-search class="w-5 h-6 text-gray-400"/>
                            </div>
                            <input autocomplete="off" id="search" name="search"
                                class="block w-full py-2 pl-10 pr-3 text-sm placeholder-gray-500 bg-white border border-gray-300 rounded-md focus:outline-none focus:text-gray-900 focus:placeholder-gray-400 focus:ring-1 focus:ring-gray-900 focus:border-gray-900 sm:text-sm"
                                placeholder="Search" type="search">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="container px-4 mx-auto sm:px-6 lg:px-8">
        {{ $slot }}
    </main>
</x-layouts.base>
