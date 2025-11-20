@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{!! __('Pagination Navigation') !!}" class="flex justify-between">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="bg-transparent text-gray-400 border-2 border-gray-400  rounded-2xl items-center py-1 px-4 scale-95">
                {!! __('pagination.previous') !!}
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="bg-transparent text-black border-2 border-black  rounded-2xl items-center py-1 px-4 hover:text-gray-500 hover:border-gray-400 active:scale-95 transition-transform duration-75">
                {!! __('pagination.previous') !!}
            </a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="bg-transparent text-black border-2 border-black  rounded-2xl items-center py-1 px-4 hover:text-gray-500 hover:border-gray-400 active:scale-95 transition-transform duration-75">
                {!! __('pagination.next') !!}
            </a>
        @else
            <span class="bg-transparent text-gray-400 border-2 border-gray-400  rounded-2xl items-center py-1 px-4 scale-95">
                {!! __('pagination.next') !!}
            </span>
        @endif
    </nav>
@endif
