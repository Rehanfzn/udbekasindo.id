<?php $__env->startSection('title', $product->exists ? 'Edit Produk' : 'Tambah Produk'); ?>

<?php $__env->startSection('content'); ?>
    <form method="POST"
          action="<?php echo e($product->exists ? route('admin.products.update', $product) : route('admin.products.store')); ?>"
          enctype="multipart/form-data"
          class="card max-w-3xl p-6 sm:p-8">
        <?php echo csrf_field(); ?>
        <?php if($product->exists): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

        <div class="grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="title" class="label">Judul Produk</label>
                <input type="text" name="title" id="title" class="input" required
                       value="<?php echo e(old('title', $product->title)); ?>" placeholder="Contoh: Plat Baja Bekas">
                <?php $__errorArgs = ['title'];
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
                        <option value="<?php echo e($key); ?>" <?php if(old('category', $product->category) === $key): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
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
                <label for="price_label" class="label">Label Harga (opsional)</label>
                <input type="text" name="price_label" id="price_label" class="input"
                       value="<?php echo e(old('price_label', $product->price_label)); ?>" placeholder="Per kg / Hubungi kami / Nego">
                <?php $__errorArgs = ['price_label'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs text-red-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="image" class="label">Gambar (opsional, maks 2 MB)</label>
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

            <div>
                <label for="is_featured" class="label">&nbsp;</label>
                <label class="flex h-[42px] items-center gap-2 rounded-lg border border-stone-600 px-3.5 text-sm text-stone-300">
                    <input type="checkbox" name="is_featured" value="1" class="rounded border-stone-600 text-brand-700 focus:ring-brand-600"
                           <?php if(old('is_featured', $product->is_featured)): echo 'checked'; endif; ?>>
                    Tampilkan di beranda (unggulan)
                </label>
            </div>

            <div class="sm:col-span-2">
                <label for="description" class="label">Deskripsi</label>
                <textarea name="description" id="description" rows="5" class="input"
                          placeholder="Jelaskan kondisi, jenis, dan ketersediaan barang."><?php echo e(old('description', $product->description)); ?></textarea>
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
                       <?php if(old('is_active', $product->exists ? $product->is_active : true)): echo 'checked'; endif; ?>>
                Aktif (tampilkan di katalog)
            </label>
        </div>

        <?php if($product->image): ?>
            <div class="mt-5">
                <p class="label">Gambar saat ini</p>
                <img src="<?php echo e(\Illuminate\Support\Facades\Storage::url($product->image)); ?>" alt="<?php echo e($product->title); ?>"
                     class="h-24 w-24 rounded-lg object-cover ring-1 ring-stone-700">
            </div>
        <?php endif; ?>

        <div class="mt-7 flex gap-3">
            <button type="submit" class="btn-primary px-8"><?php echo e($product->exists ? 'Simpan Perubahan' : 'Tambah Produk'); ?></button>
            <a href="<?php echo e(route('admin.products.index')); ?>" class="btn-outline">Batal</a>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Documents\udbekasindo\udbekasindoweb\resources\views/admin/products/form.blade.php ENDPATH**/ ?>