<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['product']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['product']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<a href="<?php echo e(route('products.show', $product->slug)); ?>"
   class="card group flex flex-col overflow-hidden transition hover:-translate-y-1 hover:border-brand-500/40 hover:shadow-lg">
    <div class="relative h-48 overflow-hidden bg-gradient-to-br from-ink-900 to-ink-950">
        <?php if($product->image): ?>
            <img src="<?php echo e(\Illuminate\Support\Facades\Storage::url($product->image)); ?>"
                 alt="<?php echo e($product->title); ?>"
                 class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
        <?php else: ?>
            <div class="flex h-full items-center justify-center">
                <span class="text-5xl font-black text-ink-800 select-none"><?php echo e(mb_substr($product->title, 0, 1)); ?></span>
            </div>
        <?php endif; ?>
        <span class="badge absolute left-3 top-3 bg-ink-950/95 text-stone-100"><?php echo e($product->category_label); ?></span>
    </div>

    <div class="flex flex-1 flex-col p-5">
        <h3 class="text-lg leading-snug text-white group-hover:text-brand-400"><?php echo e($product->title); ?></h3>
        <p class="mt-2 line-clamp-2 flex-1 text-sm leading-relaxed text-stone-400"><?php echo e($product->description); ?></p>
        <div class="mt-4 flex items-center justify-between border-t border-ink-800 pt-4">
            <span class="text-sm font-semibold text-brand-400"><?php echo e($product->price_label ?: 'Hubungi kami'); ?></span>
            <span class="text-xs font-medium text-stone-400 group-hover:text-brand-400">Detail &rarr;</span>
        </div>
    </div>
</a>
<?php /**PATH C:\Users\user\Documents\udbekasindo\udbekasindoweb\resources\views/components/product-card.blade.php ENDPATH**/ ?>