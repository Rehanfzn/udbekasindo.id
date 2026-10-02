<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <div class="grid gap-4 sm:grid-cols-3">
        <div class="card p-6">
            <p class="text-xs font-semibold uppercase tracking-widest text-stone-400">Material</p>
            <p class="mt-2 text-3xl font-extrabold text-white"><?php echo e($materialCount); ?></p>
            <a href="<?php echo e(route('admin.materials.index')); ?>" class="mt-2 inline-block text-sm font-medium text-brand-400 hover:underline">Kelola harga &amp; density &rarr;</a>
        </div>

        <div class="card p-6">
            <p class="text-xs font-semibold uppercase tracking-widest text-stone-400">Produk di Katalog</p>
            <p class="mt-2 text-3xl font-extrabold text-white"><?php echo e($productCount); ?></p>
            <p class="mt-1 text-sm text-stone-400"><?php echo e($activeProductCount); ?> aktif ditampilkan</p>
        </div>

        <div class="card p-6">
            <p class="text-xs font-semibold uppercase tracking-widest text-stone-400">Profil Baja (Tabel Standar)</p>
            <p class="mt-2 text-3xl font-extrabold text-white">IWF / UNP</p>
            <a href="<?php echo e(route('admin.profiles.index')); ?>" class="mt-2 inline-block text-sm font-medium text-brand-400 hover:underline">Lihat tabel &rarr;</a>
        </div>
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        <div class="card overflow-hidden">
            <div class="flex items-center justify-between border-b border-ink-800 bg-ink-800 px-5 py-4">
                <h2 class="text-sm font-bold uppercase tracking-wide text-stone-200">Produk Terbaru</h2>
                <a href="<?php echo e(route('admin.products.create')); ?>" class="text-sm font-medium text-brand-400 hover:underline">+ Tambah</a>
            </div>
            <ul class="divide-y divide-stone-800 text-sm">
                <?php $__empty_1 = true; $__currentLoopData = $recentProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <li class="flex items-center justify-between gap-3 px-5 py-3">
                        <div class="min-w-0">
                            <p class="truncate font-medium text-white"><?php echo e($product->title); ?></p>
                            <p class="text-xs text-stone-400"><?php echo e($product->category_label); ?></p>
                        </div>
                        <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="shrink-0 text-sm font-medium text-brand-400 hover:underline">Edit</a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <li class="px-5 py-6 text-stone-400">Belum ada produk.</li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="card p-5">
            <h2 class="text-sm font-bold uppercase tracking-wide text-stone-200">Aksi Cepat</h2>
            <div class="mt-4 grid gap-3">
                <a href="<?php echo e(route('admin.products.create')); ?>" class="btn-outline justify-between">
                    Tambah Produk <span>&rarr;</span>
                </a>
                <a href="<?php echo e(route('admin.materials.create')); ?>" class="btn-outline justify-between">
                    Tambah Material / Ubah Harga <span>&rarr;</span>
                </a>
                <a href="<?php echo e(route('admin.settings.edit')); ?>" class="btn-outline justify-between">
                    Edit Kontak &amp; Profil Perusahaan <span>&rarr;</span>
                </a>
                <a href="<?php echo e(route('calculator.index')); ?>" target="_blank" class="btn-outline justify-between">
                    Coba Kalkulator <span>&rarr;</span>
                </a>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Documents\udbekasindo\udbekasindoweb\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>