@if ($paginator->hasPages())
    <div class="tw-flex tw-flex-col tw-space-y-4 ">
        <!-- Mobile View -->
        <div class="tw-flex tw-justify-between tw-w-full sm:tw-hidden">
            @if ($paginator->onFirstPage())
                <span
                    class="tw-px-3 tw-py-1.5 tw-text-sm tw-text-gray-400 tw-bg-gray-100 tw-rounded-md tw-cursor-not-allowed dark:tw-bg-gray-800 dark:tw-text-gray-600">
                    ← Previous
                </span>
            @else
                <button wire:click="previousPage"
                    class="tw-px-3 tw-py-1.5 tw-text-sm tw-text-white tw-bg-purple-600 tw-rounded-md hover:tw-bg-purple-700 tw-transition-colors">
                    ← Previous
                </button>
            @endif

            @if ($paginator->hasMorePages())
                <button wire:click="nextPage"
                    class="tw-px-3 tw-py-1.5 tw-text-sm tw-text-white tw-bg-purple-600 tw-rounded-md hover:tw-bg-purple-700 tw-transition-colors">
                    Next →
                </button>
            @else
                <span
                    class="tw-px-3 tw-py-1.5 tw-text-sm tw-text-gray-400 tw-bg-gray-100 tw-rounded-md tw-cursor-not-allowed dark:tw-bg-gray-800 dark:tw-text-gray-600">
                    Next →
                </span>
            @endif
        </div>

        <!-- Desktop View -->
        <div class="tw-hidden sm:tw-flex sm:tw-items-center sm:tw-justify-between sm:tw-w-full">
            <!-- Left Section: Per Page Selector -->
            <div class="tw-flex tw-items-center tw-space-x-2 tw-relative tw-z-10">
                <span class="tw-text-sm tw-text-gray-600 dark:tw-text-gray-400">Show</span>
                <div class="tw-relative">
                    <select wire:model.live="perPage" id="perPage"
                        class="tw-px-3 tw-py-1.5 tw-text-sm tw-border tw-border-gray-300 tw-rounded-md tw-bg-white focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-purple-500 focus:tw-border-purple-500 dark:tw-bg-gray-800 dark:tw-border-gray-600 dark:tw-text-gray-300 dark:focus:tw-ring-purple-400 tw-relative tw-z-20 tw-appearance-none tw-pr-8">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <div class="tw-absolute tw-inset-y-0 tw-right-0 tw-flex tw-items-center tw-pr-2 tw-pointer-events-none">
                        <svg class="tw-w-4 tw-h-4 tw-text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
                <span class="tw-text-sm tw-text-gray-600 dark:tw-text-gray-400">entries per page</span>
            </div>

            <!-- Center Section: Pagination Links -->
            <div class="tw-flex tw-items-center tw-space-x-1 tw-relative tw-z-0">
                @if ($paginator->onFirstPage())
                    <span
                        class="tw-p-1.5 tw-text-gray-400 tw-bg-gray-100 tw-rounded-md tw-cursor-not-allowed dark:tw-bg-gray-800">
                        <svg class="tw-w-4 tw-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </span>
                @else
                    <button wire:click="previousPage"
                        class="tw-p-1.5 tw-text-gray-600 tw-bg-white tw-border tw-rounded-md hover:tw-bg-purple-50 hover:tw-text-purple-600 hover:tw-border-purple-300 tw-transition-colors dark:tw-bg-gray-800 dark:tw-text-gray-400 dark:tw-border-gray-700 dark:hover:tw-bg-gray-700">
                        <svg class="tw-w-4 tw-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="tw-px-2 tw-py-1 tw-text-sm tw-text-gray-500">...</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="tw-px-3 tw-py-1.5 tw-text-sm tw-text-white tw-bg-purple-600 tw-rounded-md tw-font-medium">
                                    {{ $page }}
                                </span>
                            @else
                                <button wire:click="gotoPage({{ $page }})"
                                    class="tw-px-3 tw-py-1.5 tw-text-sm tw-text-gray-600 tw-bg-white tw-border tw-rounded-md hover:tw-bg-purple-50 hover:tw-text-purple-600 hover:tw-border-purple-300 tw-transition-colors dark:tw-bg-gray-800 dark:tw-text-gray-400 dark:tw-border-gray-700 dark:hover:tw-bg-gray-700">
                                    {{ $page }}
                                </button>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <button wire:click="nextPage"
                        class="tw-p-1.5 tw-text-gray-600 tw-bg-white tw-border tw-rounded-md hover:tw-bg-purple-50 hover:tw-text-purple-600 hover:tw-border-purple-300 tw-transition-colors dark:tw-bg-gray-800 dark:tw-text-gray-400 dark:tw-border-gray-700 dark:hover:tw-bg-gray-700">
                        <svg class="tw-w-4 tw-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                @else
                    <span
                        class="tw-p-1.5 tw-text-gray-400 tw-bg-gray-100 tw-rounded-md tw-cursor-not-allowed dark:tw-bg-gray-800">
                        <svg class="tw-w-4 tw-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </span>
                @endif
            </div>

            <!-- Right Section: Info Text -->
            <div class="tw-text-sm tw-text-gray-600 dark:tw-text-gray-400">
                Showing <span class="tw-font-semibold tw-text-purple-600">{{ $paginator->firstItem() ?? 0 }}</span>
                to <span class="tw-font-semibold tw-text-purple-600">{{ $paginator->lastItem() ?? 0 }}</span>
                of <span class="tw-font-semibold">{{ $paginator->total() }}</span> results
            </div>
        </div>
    </div>
@endif