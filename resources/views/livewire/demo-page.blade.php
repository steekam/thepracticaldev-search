<div>
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
        {{-- Search results container --}}
        <div class="flex flex-col w-full pt-8 pb-10 sm:max-w-4xl">
            <h2 class="text-2xl font-medium text-gray-800">Sample of positive comments</h2>
            <div class="mt-4 space-y-4">
                @foreach ($highly_positive_comments as $comment)
                    <div class="w-full px-6 py-3 space-y-2 bg-white border border-gray-200 rounded-md">
                        <p>{!! $comment->body_html !!}</p>
                    </div>
                @endforeach
            </div>

            <h2 class="mt-10 text-2xl font-medium text-gray-800">Sample of negative comments</h2>
            <div class="mt-4 space-y-4">
                @foreach ($highly_negative_comments as $comment)
                    <div class="w-full px-6 py-3 space-y-2 bg-white border border-gray-200 rounded-md">
                        <p>{!! $comment->body_html !!}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
</div>
