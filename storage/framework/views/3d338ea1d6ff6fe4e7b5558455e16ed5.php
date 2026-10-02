<?php $__env->startSection('title', 'Tabel Profil Baja'); ?>

<?php $__env->startSection('content'); ?>
    <div class="mb-5 max-w-3xl rounded-lg border border-brand-700 bg-brand-950 px-4 py-3 text-sm text-brand-300">
        Daftar berat per meter standar yang dipakai kalkulator untuk bentuk <strong>Profil Baja (IWF/UNP)</strong>.
        Nilai ini bersifat geometris (tidak berubah oleh pasar) — hanya disesuaikan bila ada profil non-standar.
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card overflow-hidden">
                <div class="border-b border-ink-800 bg-ink-800 px-5 py-4">
                    <h2 class="text-sm font-bold uppercase tracking-wide text-stone-200">
                        <?php echo e($types[$type] ?? $type); ?>

                    </h2>
                </div>
                <table class="w-full text-sm">
                    <thead class="text-left text-xs font-semibold uppercase tracking-wide text-stone-400">
                        <tr>
                            <th class="px-5 py-2.5">Ukuran</th>
                            <th class="px-5 py-2.5 text-right">Berat (kg/m)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-800">
                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="px-5 py-2.5 text-stone-300"><?php echo e($profile->size); ?></td>
                                <td class="px-5 py-2.5 text-right font-semibold text-white tabular-nums">
                                    <?php echo e(number_format($profile->weight_per_m, 2, ',', '.')); ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Documents\udbekasindo\udbekasindoweb\resources\views/admin/profiles/index.blade.php ENDPATH**/ ?>