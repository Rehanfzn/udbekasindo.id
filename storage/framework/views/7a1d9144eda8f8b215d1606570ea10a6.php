<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Admin'); ?> — UD Bekas Indo</title>
    <style>html{background-color:#121212}</style>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="min-h-screen bg-ink-950">
<div class="flex min-h-screen">

    <aside class="hidden w-64 shrink-0 flex-col border-r border-stone-800 bg-ink-950 lg:flex">
        <div class="flex h-16 items-center gap-3 border-b border-stone-800 px-5">
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-500 text-sm font-black text-ink-950">UB</span>
            <span class="text-sm font-extrabold text-white">Admin Panel</span>
        </div>

        <nav class="flex-1 space-y-1 p-4 text-sm">
            <?php ($adminNav = [
                ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => '&#9632;'],
                ['route' => 'admin.products.index', 'label' => 'Katalog Produk', 'icon' => '&#9635;'],
                ['route' => 'admin.materials.index', 'label' => 'Material & Harga', 'icon' => '&#9878;'],
                ['route' => 'admin.profiles.index', 'label' => 'Tabel Profil Baja', 'icon' => '&#9711;'],
                ['route' => 'admin.settings.edit', 'label' => 'Pengaturan', 'icon' => '&#9881;'],
            ]); ?>
            <?php $__currentLoopData = $adminNav; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route($item['route'])); ?>"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium <?php echo e(request()->routeIs($item['route']) ? 'bg-brand-500 text-ink-950' : 'text-stone-400 hover:bg-ink-800 hover:text-white'); ?>">
                    <span class="w-4 text-center"><?php echo $item['icon']; ?></span>
                    <?php echo e($item['label']); ?>

                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </nav>

        <div class="space-y-1 border-t border-stone-800 p-4 text-sm">
            <a href="<?php echo e(route('home')); ?>" target="_blank" class="flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium text-stone-400 hover:bg-ink-800 hover:text-white">
                <span class="w-4 text-center">&#8599;</span> Lihat Website
            </a>
            <form method="POST" action="<?php echo e(route('admin.logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 font-medium text-red-400 hover:bg-ink-800">
                    <span class="w-4 text-center">&#10162;</span> Keluar (<?php echo e(auth()->user()->name); ?>)
                </button>
            </form>
        </div>
    </aside>

    <div class="flex min-w-0 flex-1 flex-col">
        <header class="flex h-16 items-center justify-between border-b border-stone-800 bg-ink-900 px-4 lg:px-8">
            <div class="flex items-center gap-3">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-ink-950 text-sm font-black text-brand-400 lg:hidden">UB</span>
                <h1 class="text-base font-bold text-white"><?php echo $__env->yieldContent('title', 'Dashboard'); ?></h1>
            </div>

            <div class="flex items-center gap-2">
                <a href="<?php echo e(route('home')); ?>" class="btn-outline hidden sm:inline-flex">Lihat Website</a>
                <form method="POST" action="<?php echo e(route('admin.logout')); ?>" class="sm:hidden">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn-outline">Keluar</button>
                </form>
            </div>
        </header>

        <div class="p-4 lg:p-8">
            <?php if(session('success')): ?>
                <div class="mb-6 rounded-lg border border-green-900 bg-green-950 px-4 py-3 text-sm text-green-300">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="mb-6 rounded-lg border border-red-900 bg-red-950 px-4 py-3 text-sm text-red-300">
                    <ul class="list-inside list-disc space-y-1">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
</div>
</body>
</html>
<?php /**PATH C:\Users\user\Documents\udbekasindo\udbekasindoweb\resources\views/layouts/admin.blade.php ENDPATH**/ ?>