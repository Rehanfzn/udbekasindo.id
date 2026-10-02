<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $settings['tagline'] ?? 'Jual beli barang bekas, besi, tembaga & logam lainnya' }}">

    <title>@yield('title', ($settings['company_name'] ?? 'UD Bekas Indo').' — '.($settings['tagline'] ?? ''))</title>

    <style>html{background-color:#1a1a1a}</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col">
    <header class="sticky top-0 z-40 border-b border-stone-800 bg-ink-900/90 font-nav backdrop-blur">
        <div class="container-page flex h-16 items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-ink-950 text-sm font-black text-brand-400">UB</span>
                <span class="leading-tight">
                    <span class="block text-sm font-extrabold text-white">{{ $settings['company_name'] ?? 'UD Bekas Indo' }}</span>
                    <span class="block text-[11px] text-stone-400">Scrap &amp; Barang Bekas</span>
                </span>
            </a>

            <nav class="hidden items-center gap-1 md:flex">
                @php($navItems = [
                    ['route' => 'home', 'label' => 'Beranda'],
                    ['route' => 'about', 'label' => 'Tentang Kami'],
                    ['route' => 'products.index', 'label' => 'Katalog'],
                ])
                @foreach ($navItems as $item)
                    <a href="{{ route($item['route']) }}"
                       class="rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs($item['route']) ? 'bg-ink-800 text-brand-400' : 'text-stone-300 hover:bg-ink-800 hover:text-white' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
                <a href="{{ route('calculator.index') }}"
                   class="ml-2 btn-primary {{ request()->routeIs('calculator.*') ? 'ring-2 ring-brand-300' : '' }}">
                    Kalkulator Harga
                </a>
            </nav>

            <button type="button" data-menu-toggle
                    class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-stone-600 text-stone-300 md:hidden"
                    aria-label="Buka menu">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <div data-mobile-menu class="hidden border-t border-stone-800 bg-ink-900 md:hidden">
            <nav class="container-page flex flex-col gap-1 py-3">
                <a href="{{ route('home') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-stone-300 hover:bg-ink-800 hover:text-white">Beranda</a>
                <a href="{{ route('about') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-stone-300 hover:bg-ink-800 hover:text-white">Tentang Kami</a>
                <a href="{{ route('products.index') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-stone-300 hover:bg-ink-800 hover:text-white">Katalog</a>
                <a href="{{ route('calculator.index') }}" class="btn-primary mt-1">Kalkulator Harga</a>
            </nav>
        </div>
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="mt-16 bg-ink-950 text-stone-300">
        <div class="container-page grid gap-10 py-12 sm:grid-cols-2 lg:grid-cols-4">
            <div>
                <div class="flex items-center gap-3">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-500 text-sm font-black text-ink-950">UB</span>
                    <span class="text-base font-extrabold text-white">{{ $settings['company_name'] ?? 'UD Bekas Indo' }}</span>
                </div>
                <p class="mt-4 text-sm leading-relaxed text-stone-400">{{ $settings['tagline'] ?? '' }}</p>
            </div>

            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-white">Navigasi</h3>
                <ul class="mt-4 space-y-2 text-sm">
                    <li><a class="hover:text-brand-400" href="{{ route('home') }}">Beranda</a></li>
                    <li><a class="hover:text-brand-400" href="{{ route('about') }}">Tentang Kami</a></li>
                    <li><a class="hover:text-brand-400" href="{{ route('products.index') }}">Katalog Produk</a></li>
                    <li><a class="hover:text-brand-400" href="{{ route('calculator.index') }}">Kalkulator Harga</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-white">Kontak</h3>
                <ul class="mt-4 space-y-2 text-sm text-stone-400">
                    <li>{{ $settings['address'] ?? '-' }}</li>
                    <li>{{ $settings['phone'] ?? '-' }}</li>
                    <li>{{ $settings['email'] ?? '-' }}</li>
                    <li>{{ $settings['working_hours'] ?? '-' }}</li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-white">Hubungi Kami</h3>
                <p class="mt-4 text-sm text-stone-400">Butuh penawaran atau mau barang dijemput? Chat langsung.</p>
                @if (! empty($settings['whatsapp']))
                    <a href="https://wa.me/{{ $settings['whatsapp'] }}" target="_blank" rel="noopener"
                       class="btn-primary mt-4">Chat WhatsApp</a>
                @endif
            </div>
        </div>

        <div class="border-t border-stone-800">
            <div class="container-page flex flex-col items-center justify-between gap-2 py-5 text-xs text-stone-500 sm:flex-row">
                <span>{{ $settings['footer_note'] ?? '© '.date('Y').' UD Bekas Indo.' }}</span>
                <span>Menerima jemput barang di lokasi — timbang di tempat, bayar saat itu juga.</span>
            </div>
        </div>
    </footer>

    {{-- Tombol WhatsApp mengambang + popup di pojok kanan bawah --}}
    @php($waNumber = $settings['whatsapp'] ?? null)
    @if ($waNumber)
        @php($waHref = 'https://wa.me/'.$waNumber.'?text='.rawurlencode('Halo '.($settings['company_name'] ?? 'UD Bekas Indo').', saya mau tanya seputar barang bekas dan material.'))
        <div class="fixed bottom-5 right-5 z-50 flex flex-col items-end gap-3" data-wa-popup>
            <div id="wa-panel" data-wa-panel
                 class="hidden w-72 overflow-hidden rounded-2xl border border-ink-800 bg-ink-900 shadow-2xl">
                <div class="flex items-center justify-between gap-3 bg-[#25D366] px-4 py-3 text-white">
                    <div class="flex items-center gap-2.5">
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-white/20 text-xs font-black">UB</span>
                        <span class="leading-tight">
                            <span class="block text-sm font-bold">{{ $settings['company_name'] ?? 'UD Bekas Indo' }}</span>
                            <span class="block text-[11px] text-white/80">Online — balas cepat</span>
                        </span>
                    </div>
                    <button type="button" data-wa-close aria-label="Tutup popup WhatsApp"
                            class="flex h-7 w-7 items-center justify-center rounded-full text-white/80 transition hover:bg-white/15 hover:text-white">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="p-4">
                    <p class="text-sm leading-relaxed text-stone-300">
                        Butuh barang dijemput, mau cek harga, atau hitung berat material? Chat langsung —
                        tim kami siap bantu.
                    </p>
                    <a href="{{ $waHref }}" target="_blank" rel="noopener" class="btn-primary mt-4 w-full justify-center">
                        Chat Sekarang
                    </a>
                    @if (! empty($settings['working_hours']))
                        <p class="mt-2.5 text-center text-[11px] text-stone-500">{{ $settings['working_hours'] }}</p>
                    @endif
                </div>
            </div>

            <button type="button" data-wa-toggle aria-expanded="false" aria-controls="wa-panel" aria-label="Buka chat WhatsApp"
                    class="flex h-14 w-14 items-center justify-center rounded-full bg-[#25D366] text-white shadow-xl ring-1 ring-black/10 transition hover:scale-105 hover:bg-[#1ebe5b] focus:outline-none focus:ring-2 focus:ring-[#25D366] focus:ring-offset-2 focus:ring-offset-ash">
                <svg class="h-7 w-7" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
            </button>
        </div>
    @endif
</body>
</html>
