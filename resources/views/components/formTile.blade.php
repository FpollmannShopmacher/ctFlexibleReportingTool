<div class="flex items-start gap-4  p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="pt-3 sm:pt-5 w-full">
        @if(isset($title))
            <h2 class="text-xl font-semibold  dark:text-white">
                {{$title}}
            </h2>
        @endif

        @if(isset($text))
            <p class="my-4 dark:text-white">
                {{$text}}
            </p>
        @endif
            {{ $childs ?? '' }}
    </div>
</div>
