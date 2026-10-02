@if ($paginator->hasPages())
    <nav class="flex flex-col items-center justify-between gap-4 sm:flex-row" role="navigation" aria-label="Pagination Navigation">
        <p class="text-sm text-stone-400">
            Menampilkan <span class="font-semibold text-stone-200">{{ number_format($paginator->firstItem(), 0, ',', '.') }}</span>
            – <span class="font-semibold text-stone-200">{{ number_format($paginator->lastItem(), 0, ',', '.') }}</span>
            dari <span class="font-semibold text-stone-200">{{ number_format($paginator->total(), 0, ',', '.') }}</span> data
        </p>

        <div class="flex items-center gap-2">
            @if ($paginator->onFirstPage())
                <span class="cursor-default rounded-lg border border-ink-800 bg-ink-900 px-4 py-2 text-sm font-medium text-stone-500">Sebelumnya</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="btn-outline !px-4 !py-2">Sebelumnya</a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="btn-outline !px-4 !py-2">Berikutnya</a>
            @else
                <span class="cursor-default rounded-lg border border-ink-800 bg-ink-900 px-4 py-2 text-sm font-medium text-stone-500">Berikutnya</span>
            @endif
        </div>
    </nav>
@endif
