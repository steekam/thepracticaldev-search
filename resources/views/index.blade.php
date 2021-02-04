<x-layouts.base>
    <main class="container px-4 mx-auto sm:px-6 lg:px-8">
        <div class="max-w-4xl mt-12 md:mt-24">
            <h1 class="text-3xl font-bold leading-tight text-gray-900 sm:text-5xl capitalise">
                Article search results rank based on comments' sentiment.
            </h1>

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
                <form action="/search" method="get" autocomplete="off">
                    <div>
                        <label for="query" class="sr-only">Search Query</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <x-heroicon-o-search class="w-6 h-6 text-gray-400 sm:w-10 sm:h-10" />
                            </div>

                            <input name="query" id="query"
                                class="block w-full py-3 pl-10 pr-20 text-gray-700 border-gray-300 rounded-full shadow focus:ring-gray-800 focus:ring focus:outline-none focus:border-gray-800 sm:pl-14 sm:pr-32 sm:py-5 sm:text-xl"
                                placeholder="Enter search keywords">

                            <div class="absolute inset-y-0 right-0 flex items-center">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 mr-2 text-sm font-medium text-white bg-gray-900 border-transparent rounded-full shadow-sm sm:px-6 sm:py-3 sm:text-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Search</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </main>
</x-layouts.base>
