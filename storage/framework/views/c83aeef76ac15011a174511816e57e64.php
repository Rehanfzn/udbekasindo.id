<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($code); ?> — UD Bekas Indo</title>
    <style>
        :root { color-scheme: dark; }
        * { box-sizing: border-box; }
        html { background-color: #1a1a1a; }
        body {
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
            background-color: #1a1a1a;
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        .panel {
            width: 100%;
            max-width: 32rem;
            border: 1px solid #2f2f2f;
            border-radius: 1rem;
            background-color: #212121;
            padding: 2.75rem 2rem;
            text-align: center;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.5);
        }
        .brand {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #a8a29e;
        }
        .brand span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 1.75rem;
            height: 1.75rem;
            border-radius: 0.5rem;
            background-color: #eab308;
            color: #121212;
            font-size: 0.6875rem;
            font-weight: 800;
            letter-spacing: 0;
        }
        .code {
            font-size: 4rem;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -0.04em;
            color: #eab308;
        }
        h1 {
            margin: 0.875rem 0 0;
            font-size: 1.25rem;
            font-weight: 700;
            color: #ffffff;
        }
        p {
            margin: 0.75rem auto 0;
            max-width: 26rem;
            font-size: 0.9375rem;
            line-height: 1.65;
            color: #d6d3d1;
        }
        .actions {
            margin-top: 1.75rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            justify-content: center;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
            padding: 0.625rem 1.25rem;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.15s ease, border-color 0.15s ease, color 0.15s ease;
        }
        .btn-primary { background-color: #eab308; color: #121212; }
        .btn-primary:hover { background-color: #ca8a04; }
        .btn-dark { border: 1px solid #57534e; background-color: #2f2f2f; color: #e7e5e4; }
        .btn-dark:hover { border-color: #eab308; color: #facc15; }
    </style>
</head>
<body>
    <main class="panel">
        <div class="brand"><span>UB</span> UD Bekas Indo</div>
        <div class="code"><?php echo e($code); ?></div>
        <h1><?php echo e($title); ?></h1>
        <p><?php echo e($message); ?></p>
        <div class="actions">
            <a class="btn btn-primary" href="<?php echo e(url('/')); ?>">Kembali ke Beranda</a>
            <a class="btn btn-dark" href="javascript:history.back()">Halaman Sebelumnya</a>
        </div>
    </main>
</body>
</html>
<?php /**PATH C:\Users\user\Documents\udbekasindo\udbekasindoweb\resources\views/errors/_frame.blade.php ENDPATH**/ ?>