<?php $__env->startSection('title', $material->exists ? 'Edit Material' : 'Tambah Material'); ?>

<?php $__env->startSection('content'); ?>
    <form method="POST"
          action="<?php echo e($material->exists ? route('admin.materials.update', $material) : route('admin.materials.store')); ?>"
          enctype="multipart/form-data"
          class="card max-w-3xl p-6 sm:p-8">
        <?php echo csrf_field(); ?>
        <?php if($material->exists): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

        <div class="grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="name" class="label">Nama Material</label>
                <input type="text" name="name" id="name" class="input" required
                       value="<?php echo e(old('name', $material->name)); ?>" placeholder="Contoh: Tembaga">
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs text-red-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="category" class="label">Kategori</label>
                <select name="category" id="category" class="input" required>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($key); ?>" <?php if(old('category', $material->category) === $key): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs text-red-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="density_kg_m3" class="label">Density (kg/m³)</label>
                <input type="number" name="density_kg_m3" id="density_kg_m3" class="input" required min="0.01" step="any"
                       value="<?php echo e(old('density_kg_m3', $material->density_kg_m3)); ?>" placeholder="7850">
                <?php $__errorArgs = ['density_kg_m3'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs text-red-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="price_per_kg" class="label">Harga per Kg (Rp)</label>
                <input type="number" name="price_per_kg" id="price_per_kg" class="input" required min="0" step="1"
                       value="<?php echo e(old('price_per_kg', $material->price_per_kg)); ?>" placeholder="7000">
                <?php $__errorArgs = ['price_per_kg'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs text-red-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="image" class="label">Gambar (opsional, JPG/PNG/WEBP maks 2 MB)</label>
                <input type="file" name="image" id="image" class="input" accept="image/*">
                <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs text-red-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="sm:col-span-2">
                <label for="description" class="label">Deskripsi Singkat</label>
                <textarea name="description" id="description" rows="3" class="input"
                          placeholder="Contoh: Tembaga murni dari kabel, pipa, trafo."><?php echo e(old('description', $material->description)); ?></textarea>
                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs text-red-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <label class="flex items-center gap-2 text-sm text-stone-300 sm:col-span-2">
                <input type="checkbox" name="is_active" value="1" class="rounded border-stone-600 text-brand-700 focus:ring-brand-600"
                       <?php if(old('is_active', $material->exists ? $material->is_active : true)): echo 'checked'; endif; ?>>
                Tampilkan di kalkulator &amp; daftar harga (aktif)
            </label>
        </div>

        <?php if($material->image): ?>
            <div class="mt-5">
                <p class="label">Gambar saat ini</p>
                <img src="<?php echo e(\Illuminate\Support\Facades\Storage::url($material->image)); ?>" alt="<?php echo e($material->name); ?>"
                     class="h-24 w-24 rounded-lg object-cover ring-1 ring-stone-700">
            </div>
        <?php endif; ?>

        <div class="mt-7 flex gap-3">
            <button type="submit" class="btn-primary px-8"><?php echo e($material->exists ? 'Simpan Perubahan' : 'Tambah Material'); ?></button>
            <a href="<?php echo e(route('admin.materials.index')); ?>" class="btn-outline">Batal</a>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Documents\udbekasindo\udbekasindoweb\resources\views/admin/materials/form.blade.php ENDPATH**/ ?>