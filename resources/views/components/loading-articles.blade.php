<div class="space-y-6">
    @foreach(range(0, 3) as $index)
    <div class="w-full px-4 py-5 bg-white border border-gray-200 rounded-md sm:px-6">
        <div class="space-y-3 animate-pulse">
            <div class="flex space-x-3">
                <div class="w-10 h-10 bg-gray-300 rounded-full"></div>
                <div class="flex-1 h-10 min-w-0 bg-gray-300 rounded-md"></div>
            </div>

            <div class="h-32 pl-12 bg-gray-300 rounded-md"></div>
        </div>
    </div>
    @endforeach
</div>
