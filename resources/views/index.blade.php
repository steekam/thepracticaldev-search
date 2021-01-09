<x-layouts.base>
    <main class="container px-4 mx-auto sm:px-6 lg:px-8">
        <div class="max-w-4xl mt-12 md:mt-24">
            <h1 class="text-3xl font-bold leading-tight text-gray-900 sm:text-5xl capitalise">
                Article search results rank based on comments' sentiment.
                <h1>

                    <div class="mt-4 space-y-4 text-lg text-gray-700 md:mt-8 sm:text-2xl">
                        <p>
                            Classifying the sentiment of readers' comments into positive or negative. The aggregate
                            sentiment score of the articles helps ranking search results based on readers feedback.
                            <strong>Helps you identify articles that are likely to be useful based what people are
                                saying.</strong>
                        </p>

                        <p>
                            Think of StackOverflow for articles but the up vote is a positive comment and the down vote
                            is a negative comment.
                        </p>
                    </div>

                    <div class="mt-8 sm:mt-12">
                        <form action="#" method="get" autocomplete="off">
                            <div class="flex items-center px-4 bg-white rounded-full shadow sm:px-6 sm:py-3">
                                <div>
                                    <x-heroicon-o-search class="w-6 h-6 text-gray-400 sm:w-10 sm:h-10" />
                                </div>
                                <div class="flex-1">
                                    <label for="query" class="sr-only">Search Query</label>
                                    <input class="block w-full py-3 border-none sm:text-lg focus:ring-0" type="text"
                                        name="query" placeholder="Enter search keywords" id="query">
                                </div>

                                <div>
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-900 border-transparent rounded-full shadow-sm sm:px-6 sm:py-3 sm:text-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>

        </div>
    </main>
</x-layouts.base>
