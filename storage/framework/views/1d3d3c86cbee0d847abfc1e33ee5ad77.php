<?php $__env->startSection('title', $product->title); ?>

<?php $__env->startSection('content'); ?>
    <div class="border-b border-stone-800 bg-ink-900">
        <div class="container-page py-4 text-sm text-stone-400">
            <a href="<?php echo e(route('home')); ?>" class="hover:text-brand-400">Beranda</a>
            <span class="mx-2">/</span>
            <a href="<?php echo e(route('products.index')); ?>" class="hover:text-brand-400">Katalog</a>
            <span class="mx-2">/</span>
            <span class="text-stone-100"><?php echo e($product->title); ?></span>
        </div>
    </div>

    <section class="container-page grid gap-10 bg-ash py-12 lg:grid-cols-2">
        <div class="card overflow-hidden">
            <?php if($product->image): ?>
                <img src="<?php echo e(\Illuminate\Support\Facades\Storage::url($product->image)); ?>"
                     alt="<?php echo e($product->title); ?>" class="h-full max-h-[420px] w-full object-cover">
            <?php else: ?>
                <div class="flex h-80 items-center justify-center bg-gradient-to-br from-ink-900 to-ink-950 sm:h-full sm:min-h-[420px]">
                    <span class="text-7xl font-black text-ink-800 select-none"><?php echo e(mb_substr($product->title, 0, 1)); ?></span>
                </div>
            <?php endif; ?>
        </div>

        <div>
            <span class="badge bg-ink-800 text-brand-400 ring-1 ring-brand-500/40"><?php echo e($product->category_label); ?></span>
            <h1 class="mt-4 text-3xl"><?php echo e($product->title); ?></h1>

            <?php if($product->price_label): ?>
                <p class="mt-3 text-lg font-semibold text-brand-400"><?php echo e($product->price_label); ?></p>
            <?php endif; ?>

            <div class="mt-5 leading-relaxed text-stone-300">
                <?php echo nl2br(e($product->description ?? '')); ?>

            </div>

            <div class="mt-8 rounded-xl bg-ink-900 p-5 text-stone-300">
                <h2 class="text-sm font-bold uppercase tracking-wide text-stone-400">Estimasi sendiri dulu?</h2>
                <p class="mt-1 text-sm text-stone-300">Gunakan kalkulator kami untuk menghitung berat dan estimasi harga dari dimensi material.</p>
                <a href="<?php echo e(route('calculator.index')); ?>" class="btn-primary mt-4">Buka Kalkulator Harga</a>
            </div>

            <?php if(\App\Models\Setting::get('whatsapp')): ?>
                <a href="https://wa.me/<?php echo e(\App\Models\Setting::get('whatsapp')); ?>?text=<?php echo e(rawurlencode('Halo, saya tertarik dengan: '.$product->title.' ('.route('products.show', $product->slug).')')); ?>"
                   target="_blank" rel="noopener" class="btn-dark mt-4 w-full">
                    Tanya via WhatsApp
                </a>
            <?php endif; ?>
        </div>
    </section>

    <?php if($related->isNotEmpty()): ?>
        <section class="container-page bg-ash py-12">
            <h2 class="text-2xl text-white">Produk Lainnya</h2>
            <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if (isset($component)) { $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-card','data' => ['product' => $item]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $attributes = $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $component = $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </section>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Documents\udbekasindo\udbekasindoweb\resources\views/products/show.blade.php ENDPATH**/ ?>