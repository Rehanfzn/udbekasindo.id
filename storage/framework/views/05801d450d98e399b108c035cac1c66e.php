<?php if($paginator->hasPages()): ?>
    <nav role="navigation" aria-label="<?php echo e(__('Pagination Navigation')); ?>">
        <div class="flex gap-2 items-center justify-between sm:hidden">
            <?php if($paginator->onFirstPage()): ?>
                <span class="inline-flex items-center rounded-md border border-stone-700 bg-ink-800 px-4 py-2 text-sm font-medium text-stone-500 cursor-not-allowed">
                    <?php echo __('pagination.previous'); ?>

                </span>
            <?php else: ?>
                <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev"
                   class="inline-flex items-center rounded-md border border-stone-700 bg-ink-900 px-4 py-2 text-sm font-medium text-stone-300 transition hover:bg-ink-800 hover:text-white focus:outline-none focus:ring-2 focus:ring-brand-500">
                    <?php echo __('pagination.previous'); ?>

                </a>
            <?php endif; ?>

            <?php if($paginator->hasMorePages()): ?>
                <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next"
                   class="inline-flex items-center rounded-md border border-stone-700 bg-ink-900 px-4 py-2 text-sm font-medium text-stone-300 transition hover:bg-ink-800 hover:text-white focus:outline-none focus:ring-2 focus:ring-brand-500">
                    <?php echo __('pagination.next'); ?>

                </a>
            <?php else: ?>
                <span class="inline-flex items-center rounded-md border border-stone-700 bg-ink-800 px-4 py-2 text-sm font-medium text-stone-500 cursor-not-allowed">
                    <?php echo __('pagination.next'); ?>

                </span>
            <?php endif; ?>
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between sm:gap-2">
            <div>
                <p class="text-sm text-stone-400">
                    <?php echo __('Showing'); ?>

                    <?php if($paginator->firstItem()): ?>
                        <span class="font-medium text-stone-200"><?php echo e($paginator->firstItem()); ?></span>
                        <?php echo __('to'); ?>

                        <span class="font-medium text-stone-200"><?php echo e($paginator->lastItem()); ?></span>
                    <?php else: ?>
                        <?php echo e($paginator->count()); ?>

                    <?php endif; ?>
                    <?php echo __('of'); ?>

                    <span class="font-medium text-stone-200"><?php echo e($paginator->total()); ?></span>
                    <?php echo __('results'); ?>

                </p>
            </div>

            <div>
                <span class="inline-flex rtl:flex-row-reverse rounded-md shadow-sm">
                    <?php if($paginator->onFirstPage()): ?>
                        <span aria-disabled="true" aria-label="<?php echo e(__('pagination.previous')); ?>">
                            <span class="-ml-px inline-flex items-center rounded-l-md border border-stone-700 bg-ink-800 px-2 py-2 text-sm font-medium text-stone-500 cursor-not-allowed" aria-hidden="true">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    <?php else: ?>
                        <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" aria-label="<?php echo e(__('pagination.previous')); ?>"
                           class="-ml-px inline-flex items-center rounded-l-md border border-stone-700 bg-ink-900 px-2 py-2 text-sm font-medium text-stone-300 transition hover:bg-ink-800 hover:text-white focus:outline-none focus:ring-2 focus:ring-brand-500">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    <?php endif; ?>

                    <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(is_string($element)): ?>
                            <span aria-disabled="true">
                                <span class="-ml-px inline-flex items-center border border-stone-700 bg-ink-900 px-4 py-2 text-sm font-medium text-stone-500 cursor-default"><?php echo e($element); ?></span>
                            </span>
                        <?php endif; ?>

                        <?php if(is_array($element)): ?>
                            <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($page == $paginator->currentPage()): ?>
                                    <span aria-current="page">
                                        <span class="-ml-px inline-flex items-center border border-brand-500 bg-brand-500 px-4 py-2 text-sm font-semibold text-ink-950 cursor-default"><?php echo e($page); ?></span>
                                    </span>
                                <?php else: ?>
                                    <a href="<?php echo e($url); ?>" aria-label="<?php echo e(__('Go to page :page', ['page' => $page])); ?>"
                                       class="-ml-px inline-flex items-center border border-stone-700 bg-ink-900 px-4 py-2 text-sm font-medium text-stone-300 transition hover:bg-ink-800 hover:text-white focus:outline-none focus:ring-2 focus:ring-brand-500">
                                        <?php echo e($page); ?>

                                    </a>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php if($paginator->hasMorePages()): ?>
                        <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" aria-label="<?php echo e(__('pagination.next')); ?>"
                           class="-ml-px inline-flex items-center rounded-r-md border border-stone-700 bg-ink-900 px-2 py-2 text-sm font-medium text-stone-300 transition hover:bg-ink-800 hover:text-white focus:outline-none focus:ring-2 focus:ring-brand-500">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    <?php else: ?>
                        <span aria-disabled="true" aria-label="<?php echo e(__('pagination.next')); ?>">
                            <span class="-ml-px inline-flex items-center rounded-r-md border border-stone-700 bg-ink-800 px-2 py-2 text-sm font-medium text-stone-500 cursor-not-allowed" aria-hidden="true">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    <?php endif; ?>
                </span>
            </div>
        </div>
    </nav>
<?php endif; ?>
<?php /**PATH C:\Users\user\Documents\udbekasindo\udbekasindoweb\resources\views/vendor/pagination/tailwind.blade.php ENDPATH**/ ?>