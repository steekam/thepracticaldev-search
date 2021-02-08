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

            </div>
        </div>
    </header>

    <main class="container px-4 mx-auto sm:px-6 lg:px-8">
        {{ $slot }}
    </main>
</x-layouts.base>
