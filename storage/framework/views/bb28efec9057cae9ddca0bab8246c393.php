<?php $__env->startSection('title', 'Pengaturan'); ?>

<?php $__env->startSection('content'); ?>
    <form method="POST" action="<?php echo e(route('admin.settings.update')); ?>" class="card max-w-3xl p-6 sm:p-8">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <p class="text-sm text-stone-400">
            Informasi ini tampil di beranda, halaman tentan, footer, dan tautan WhatsApp.
        </p>

        <div class="mt-6 grid gap-5 sm:grid-cols-2">
            <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="<?php echo e(in_array($key, ['about', 'address', 'footer_note']) ? 'sm:col-span-2' : ''); ?>">
                    <?php if($key === 'about'): ?>
                        <label for="<?php echo e($key); ?>" class="label"><?php echo e($label); ?></label>
                        <textarea name="<?php echo e($key); ?>" id="<?php echo e($key); ?>" rows="6" class="input"><?php echo e(old($key, $settings[$key] ?? '')); ?></textarea>
                    <?php else: ?>
                        <label for="<?php echo e($key); ?>" class="label"><?php echo e($label); ?></label>
                        <input type="text" name="<?php echo e($key); ?>" id="<?php echo e($key); ?>" class="input"
                               value="<?php echo e(old($key, $settings[$key] ?? '')); ?>">
                    <?php endif; ?>
                    <?php $__errorArgs = [$key];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs text-red-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="mt-7">
            <button type="submit" class="btn-primary px-8">Simpan Pengaturan</button>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Documents\udbekasindo\udbekasindoweb\resources\views/admin/settings/edit.blade.php ENDPATH**/ ?>