<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin — UD Bekas Indo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen items-center justify-center bg-ink-950 p-4">
    <div class="w-full max-w-md">
        <div class="mb-6 text-center">
            <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-brand-500 text-lg font-black text-ink-950">UB</span>
            <h1 class="mt-4 text-xl text-white">UD Bekas Indo</h1>
            <p class="mt-1 text-sm text-stone-400">Login ke panel admin</p>
        </div>

        <form method="POST" action="{{ route('admin.login.attempt') }}" class="card space-y-5 p-8">
            @csrf

            @if ($errors->any())
                <div class="rounded-lg border border-red-900 bg-red-950 px-4 py-3 text-sm text-red-300">
                    {{ $errors->first() }}
                </div>
            @endif

            <div>
                <label for="email" class="label">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="input"
                       autocomplete="username" required autofocus>
            </div>

            <div>
                <label for="password" class="label">Password</label>
                <input type="password" name="password" id="password" class="input"
                       autocomplete="current-password" required>
            </div>

            <label class="flex items-center gap-2 text-sm text-stone-400">
                <input type="checkbox" name="remember" value="1" class="rounded border-stone-600 text-brand-700 focus:ring-brand-600">
                Ingat saya
            </label>

            <button type="submit" class="btn-primary w-full py-3">Masuk</button>
        </form>

        <p class="mt-6 text-center text-xs text-stone-400">
            <a href="{{ route('home') }}" class="hover:text-brand-400">&larr; Kembali ke website</a>
        </p>
    </div>
</body>
</html>
