<?php $__env->startSection('title', 'Material & Harga'); ?>

<?php $__env->startSection('content'); ?>
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <p class="text-sm text-stone-600">Density &amp; harga per kg dipakai langsung oleh kalkulator.</p>
        <a href="<?php echo e(route('admin.materials.create')); ?>" class="btn-primary">+ Tambah Material</a>
    </div>

    <div class="card overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-ink-800 text-left text-xs font-semibold uppercase tracking-wide text-stone-400">
                <tr>
                    <th class="px-5 py-3">Material</th>
                    <th class="px-5 py-3">Kategori</th>
                    <th class="px-5 py-3 text-right">Density (kg/m³)</th>
                    <th class="px-5 py-3 text-right">Harga / kg</th>
                    <th class="px-5 py-3 text-center">Status</th>
                    <th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-800">
                <?php $__empty_1 = true; $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="px-5 py-3">
                            <p class="font-medium text-white"><?php echo e($material->name); ?></p>
                            <?php if($material->description): ?>
                                <p class="mt-0.5 max-w-md truncate text-xs text-stone-400"><?php echo e($material->description); ?></p>
                            <?php endif; ?>
                        </td>
                        <td class="px-5 py-3 text-stone-400"><?php echo e($material->category_label); ?></td>
                        <td class="px-5 py-3 text-right tabular-nums"><?php echo e(number_format($material->density_kg_m3, 0, ',', '.')); ?></td>
                        <td class="px-5 py-3 text-right font-semibold text-brand-400 tabular-nums">
                            Rp <?php echo e(number_format($material->price_per_kg, 0, ',', '.')); ?>

                        </td>
                        <td class="px-5 py-3 text-center">
                            <?php if($material->is_active): ?>
                                <span class="badge bg-green-950 text-green-400">Aktif</span>
                            <?php else: ?>
                                <span class="badge bg-ink-800 text-stone-400">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-5 py-3 text-right whitespace-nowrap">
                            <a href="<?php echo e(route('admin.materials.edit', $material)); ?>" class="font-medium text-brand-400 hover:underline">Edit</a>
                            <form method="POST" action="<?php echo e(route('admin.materials.destroy', $material)); ?>"
                                  class="ml-3 inline" data-confirm="Hapus material <?php echo e($material->name); ?>?">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="font-medium text-red-400 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6" class="px-5 py-8 text-center text-stone-400">Belum ada material.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <?php echo e($materials->links()); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Documents\udbekasindo\udbekasindoweb\resources\views/admin/materials/index.blade.php ENDPATH**/ ?>