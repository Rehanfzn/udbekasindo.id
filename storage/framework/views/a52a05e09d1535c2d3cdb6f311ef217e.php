<?php $__env->startSection('title', 'Kalkulator Berat & Harga Material'); ?>

<?php $__env->startSection('content'); ?>
    <section class="bg-ash py-12 text-white">
        <div class="container-page">
            <p class="text-sm font-semibold uppercase tracking-widest text-brand-400">Kalkulator</p>
            <h1 class="mt-2 text-3xl text-white">Hitung Berat &amp; Estimasi Harga Material</h1>
            <p class="mt-2 max-w-2xl text-stone-400">
                Pilih bentuk material, masukkan dimensi, lalu sistem menghitung volume × density → berat → estimasi rupiah berdasarkan harga terkini.
            </p>
        </div>
    </section>

    <section class="container-page grid gap-8 bg-ash py-12 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <form id="calculator-form" method="POST" action="<?php echo e(route('calculator.calculate')); ?>" class="card p-6 sm:p-8">
                <?php echo csrf_field(); ?>

                
                <fieldset>
                    <legend class="label">Bentuk Material</legend>
                    <div class="grid grid-cols-2 gap-2 sm:grid-cols-3">
                        <?php $__currentLoopData = $shapes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $shape): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="cursor-pointer">
                            <input type="radio" name="shape" value="<?php echo e($key); ?>" class="peer sr-only"
                                   data-description="<?php echo e($shape['description']); ?>"
                                   data-formula="<?php echo e($shape['formula']); ?>"
                                   <?php if(old('shape', 'plat') === $key): echo 'checked'; endif; ?>>
                            <span class="block rounded-lg border border-stone-600 px-3 py-2.5 text-center text-sm font-medium text-stone-300 transition peer-checked:border-brand-500 peer-checked:bg-brand-500 peer-checked:text-ink-950 hover:border-brand-400">
                                <?php echo e($shape['label']); ?>

                            </span>
                        </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <p class="mt-2 text-xs text-stone-400">
                        <span data-shape-description><?php echo e($shapes[old('shape', 'plat')]['description'] ?? ''); ?></span>
                        <span class="text-stone-400" data-shape-formula>— <?php echo e($shapes[old('shape', 'plat')]['formula'] ?? ''); ?></span>
                    </p>
                    <?php $__errorArgs = ['shape'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-2 text-xs text-red-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </fieldset>

                
                <div class="mt-6 grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="material_id" class="label">Jenis Material</label>
                        <select name="material_id" id="material_id" class="input" required>
                            <option value="">— Pilih material —</option>
                            <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($material->id); ?>"
                                    <?php if((int) old('material_id') === $material->id): echo 'selected'; endif; ?>>
                                    <?php echo e($material->name); ?> — Rp <?php echo e(number_format($material->price_per_kg, 0, ',', '.')); ?>/kg
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['material_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs text-red-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label for="jumlah" class="label">Jumlah (pcs / potong)</label>
                        <input type="number" name="jumlah" id="jumlah" class="input" min="1" step="1"
                               value="<?php echo e(old('jumlah', $inputs['jumlah'] ?? 1)); ?>">
                        <?php $__errorArgs = ['jumlah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs text-red-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                
                <?php $__currentLoopData = $shapes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $shape): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div data-shape-panel="<?php echo e($key); ?>" class="<?php echo e(old('shape', 'plat') === $key ? '' : 'hidden'); ?> mt-6">
                        <div class="grid gap-5 sm:grid-cols-3">
                            <?php $__currentLoopData = $shape['fields']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div>
                                    <label for="<?php echo e($field['key']); ?>" class="label">
                                        <?php echo e($field['label']); ?>

                                        <span class="font-normal text-stone-400">(<?php echo e($field['unit']); ?>)</span>
                                    </label>
                                    <input type="number" name="<?php echo e($field['key']); ?>" id="<?php echo e($field['key']); ?>"
                                           class="input" min="0.01" step="any"
                                           placeholder="0"
                                           value="<?php echo e(old($field['key'], $inputs[$field['key']] ?? '')); ?>">
                                    <?php $__errorArgs = [$field['key']];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs text-red-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php if($shape['uses_profile']): ?>
                                <div class="sm:col-span-3">
                                    <label for="profile_id" class="label">Ukuran Profil (tabel berat standar)</label>
                                    <select name="profile_id" id="profile_id" class="input">
                                        <option value="">— Pilih ukuran —</option>
                                        <?php $__currentLoopData = $profileGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <optgroup label="<?php echo e($types[$type] ?? $type); ?>">
                                                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($profile->id); ?>"
                                                        <?php if((int) old('profile_id') === $profile->id): echo 'selected'; endif; ?>>
                                                        <?php echo e($profile->size); ?> — <?php echo e(number_format($profile->weight_per_m, 2, ',', '.')); ?> kg/m
                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </optgroup>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['profile_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs text-red-400"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <div id="calculator-errors" class="mt-5 hidden rounded-lg border border-red-900 bg-red-950 p-4 text-sm text-red-300"></div>

                <div class="mt-7 flex flex-wrap items-center gap-3">
                    <button type="submit" class="btn-primary px-8 py-3">Hitung Sekarang</button>
                    <span class="text-xs text-stone-400">Hasil terhitung otomatis saat Anda mengubah nilai.</span>
                </div>
            </form>

            <div id="calculator-result" class="mt-6 <?php echo e($result ? '' : 'hidden'); ?>">
                <?php echo $__env->renderWhen($result, 'calculator._result', ['result' => $result, 'inputs' => $inputs], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1])); ?>
            </div>
        </div>

        
        <aside class="space-y-6">
            <div class="card overflow-hidden">
                <div class="border-b border-ink-800 bg-ink-800 px-5 py-4">
                    <h2 class="text-sm font-bold uppercase tracking-wide text-stone-200">Harga Material Terkini</h2>
                    <p class="mt-0.5 text-xs text-stone-400">Per kg — dapat berubah mengikuti pasar.</p>
                </div>
                <table class="w-full text-sm">
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="border-b border-stone-800 last:border-0">
                            <td class="px-5 py-2.5">
                                <?php echo e($material->name); ?>

                                <span class="block text-xs text-stone-400">ρ <?php echo e(number_format($material->density_kg_m3, 0, ',', '.')); ?> kg/m³</span>
                            </td>
                            <td class="px-5 py-2.5 text-right font-semibold text-brand-400 whitespace-nowrap">
                                Rp <?php echo e(number_format($material->price_per_kg, 0, ',', '.')); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td class="px-5 py-4 text-stone-400">Belum ada data harga.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="card p-5">
                <h2 class="text-sm font-bold uppercase tracking-wide text-stone-200">Cara Menghitung</h2>
                <ol class="mt-3 list-inside list-decimal space-y-2 text-sm text-stone-300">
                    <li>Pilih bentuk material (plat, pipa, batang, siku, kawat, atau profil).</li>
                    <li>Masukkan dimensi dalam <strong>mm</strong> (profil: meter).</li>
                    <li>Sistem menghitung volume × density = berat.</li>
                    <li>Berat × harga/kg = estimasi harga Anda.</li>
                </ol>
                <p class="mt-3 text-xs text-stone-400">Nilai density &amp; harga dikelola admin dan diperbarui berkala. Hasil bersifat estimasi — harga final mengikuti negosiasi &amp; kondisi barang.</p>
            </div>
        </aside>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\user\Documents\udbekasindo\udbekasindoweb\resources\views/calculator/index.blade.php ENDPATH**/ ?>