<?php $__env->startSection('title', 'Katalog Produk & Jasa'); ?>

<?php $__env->startSection('content'); ?>
    <section class="bg-ash py-12 text-white">
        <div class="container-page">
            <p class="text-sm font-semibold uppercase tracking-widest text-brand-400">Katalog</p>
            <h1 class="mt-2 text-3xl text-white">Produk &amp; Jasa</h1>
            <p class="mt-2 max-w-2xl text-stone-400">Barang bekas terpilih, material logam, dan jasa angkut. Harga mengikuti pasar — hubungi kami untuk partai besar.</p>
        </div>
    </section>

    <section class="container-page bg-ash py-10">
        <form method="GET" action="<?php echo e(route('products.index')); ?>" class="flex flex-col gap-4 sm:flex-row sm:items-center">
            <div class="flex flex-wrap gap-2">
                <a href="<?php echo e(route('products.index')); ?>"
                   class="badge px-3 py-1.5 <?php echo e($activeCategory === '' ? 'bg-ink-950 text-white' : 'bg-ink-900 text-stone-300 ring-1 ring-stone-600 hover:ring-brand-400'); ?>">
                    Semua
                </a>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('products.index', ['kategori' => $key])); ?>"
                       class="badge px-3 py-1.5 <?php echo e($activeCategory === $key ? 'bg-ink-950 text-white' : 'bg-ink-900 text-stone-300 ring-1 ring-stone-600 hover:ring-brand-400'); ?>">
                        <?php echo e($label); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="flex gap-2 sm:ml-auto sm:w-72">
                <input type="search" name="q" value="<?php echo e($q); ?>" placeholder="Cari produk..."
                       class="input" aria-label="Cari produk">
                <button type="submit" class="btn-dark shrink-0">Cari</button>
            </div>
        </form>

        <?php if($products->isEmpty()): ?>
            <div class="card mt-8 p-12 text-center">
                <p class="text-lg font-semibold text-stone-200">Produk tidak ditemukan</p>
                <p class="mt-1 text-sm text-stone-400">Coba kata kunci atau kategori lain.</p>
                <a href="<?php echo e(route('products.index')); ?>" class="btn-outline mt-5">Reset Filter</a>
            </div>
        <?php else: ?>
            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if (isset($component)) { $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-card','data' => ['product' => $product]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product)]); ?>
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

            <div class="mt-10">
                <?php echo e($products->links()); ?>

            </div>
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Documents\udbekasindo\udbekasindoweb\resources\views/products/index.blade.php ENDPATH**/ ?>