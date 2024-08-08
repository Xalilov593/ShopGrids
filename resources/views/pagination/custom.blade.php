<div class="flex flex-col items-center mt-8 md:flex-row">
    <div class="mb-4 grow md:mb-0">
        <p class="text-slate-500 dark:text-zink-200">
            Showing <b>{{ $paginator->count() }}</b> of <b>{{ $paginator->total() }}</b> Results
        </p>
    </div>
    <ul class="flex flex-wrap items-center gap-2">
        <!-- Previous button -->
        <li>
            <a href="{{ $paginator->previousPageUrl() }}"
               class="inline-flex items-center justify-center bg-white dark:bg-zink-700 size-8 transition-all duration-150 ease-linear border border-slate-200 dark:border-zink-500 rounded text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&amp;.active]:text-custom-50 dark:[&amp;.active]:text-custom-50 [&amp;.active]:bg-custom-500 dark:[&amp;.active]:bg-custom-500 [&amp;.active]:border-custom-500 dark:[&amp;.active]:border-custom-500 [&amp;.disabled]:text-slate-400 dark:[&amp;.disabled]:text-zink-300 [&amp;.disabled]:cursor-auto"
               aria-label="Previous Page"
                {{ $paginator->onFirstPage() ? 'disabled' : '' }}>
                <span class="text-xl">&laquo;</span> <!-- << -->
            </a>
        </li>
        <!-- Pagination numbers -->
        @foreach ($paginator->links()->elements[0] as $page => $url)
            <li>
                <a href="{{ $url }}" class="inline-flex items-center justify-center bg-white dark:bg-zink-700 size-8 transition-all duration-150 ease-linear border border-slate-200 dark:border-zink-500 rounded text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 {{ $paginator->currentPage() == $page ? 'bg-custom-500 text-custom-50' : '' }}">
                    {{ $page }}
                </a>
            </li>
        @endforeach
        <!-- Next button -->
        <li>
            <a href="{{ $paginator->nextPageUrl() }}"
               class="inline-flex items-center justify-center bg-white dark:bg-zink-700 size-8 transition-all duration-150 ease-linear border border-slate-200 dark:border-zink-500 rounded text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&amp;.active]:text-custom-50 dark:[&amp;.active]:text-custom-50 [&amp;.active]:bg-custom-500 dark:[&amp;.active]:bg-custom-500 [&amp;.active]:border-custom-500 dark:[&amp;.active]:border-custom-500 [&amp;.disabled]:text-slate-400 dark:[&amp;.disabled]:text-zink-300 [&amp;.disabled]:cursor-auto"
               aria-label="Next Page"
                {{ !$paginator->hasMorePages() ? 'disabled' : '' }}>
                <span class="text-xl">&raquo;</span> <!-- >> -->
            </a>
        </li>
    </ul>
</div>
