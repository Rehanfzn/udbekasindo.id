<?php $__env->startSection('title', 'Katalog Produk'); ?>

<?php $__env->startSection('content'); ?>
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <p class="text-sm text-stone-600">Produk yang aktif akan tampil di halaman katalog publik.</p>
        <a href="<?php echo e(route('admin.products.create')); ?>" class="btn-primary">+ Tambah Produk</a>
    </div>

    <div class="card overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-ink-800 text-left text-xs font-semibold uppercase tracking-wide text-stone-400">
                <tr>
                    <th class="px-5 py-3">Produk</th>
                    <th class="px-5 py-3">Kategori</th>
                    <th class="px-5 py-3">Harga</th>
                    <th class="px-5 py-3 text-center">Status</th>
                    <th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-800">
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <?php if($product->image): ?>
                                    <img src="<?php echo e(\Illuminate\Support\Facades\Storage::url($product->image)); ?>" alt=""
                                         class="h-10 w-10 rounded-lg object-cover ring-1 ring-stone-700">
                                <?php else: ?>
                                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-ink-950 text-sm font-black text-brand-400">
                                        <?php echo e(mb_substr($product->title, 0, 1)); ?>

                                    </span>
                                <?php endif; ?>
                                <div>
                                    <p class="font-medium text-white"><?php echo e($product->title); ?></p>
                                    <?php if($product->is_featured): ?>
                                        <span class="badge mt-0.5 bg-brand-500/20 text-brand-300">Unggulan</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-stone-400"><?php echo e($product->category_label); ?></td>
                        <td class="px-5 py-3 text-stone-400"><?php echo e($product->price_label ?: '—'); ?></td>
                        <td class="px-5 py-3 text-center">
                            <?php if($product->is_active): ?>
                                <span class="badge bg-green-950 text-green-400">Aktif</span>
                            <?php else: ?>
                                <span class="badge bg-ink-800 text-stone-400">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-5 py-3 text-right whitespace-nowrap">
                            <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="font-medium text-brand-400 hover:underline">Edit</a>
                            <form method="POST" action="<?php echo e(route('admin.products.destroy', $product)); ?>"
                                  class="ml-3 inline" data-confirm="Hapus produk <?php echo e($product->title); ?>?">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="font-medium text-red-400 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="5" class="px-5 py-8 text-center text-stone-400">Belum ada produk.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <?php echo e($products->links()); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Documents\udbekasindo\udbekasindoweb\resources\views/admin/products/index.blade.php ENDPATH**/ ?>