@extends('layouts.app')

@section('title', ($settings['company_name'] ?? 'UD Bekas Indo').' — '.($settings['tagline'] ?? ''))

@section('content')
    {{-- HERO --}}
    <section class="relative overflow-hidden bg-ash text-white bg-cover bg-center"
             style="background-image: url('{{ asset('asset gambar/homepage bg ud.jfif') }}');">
        {{-- Overlay/shadow hitam 78% agar teks tetap terbaca di atas foto --}}
        <div class="absolute inset-0 bg-black/78"></div>

        <div class="container-page relative grid items-center gap-12 py-20 lg:grid-cols-2 lg:py-28">
            <div>
                <span class="badge bg-brand-500/15 text-brand-400 ring-1 ring-brand-500/30">Jual &amp; Beli — Timbang di Tempat</span>
                <h1 class="mt-5 text-4xl leading-tight text-white sm:text-5xl">
                    Barang Bekas &amp; Logam Anda <span class="text-brand-400">Bernilai Rupiah</span>
                </h1>
                <p class="mt-5 max-w-xl text-lg leading-relaxed text-stone-400">
                    {{ $settings['tagline'] ?? 'Jual beli barang bekas, besi, tembaga, kuningan, alumunium, dan logam lainnya.' }}
                    Jemput ke lokasi, timbang transparan, bayar saat itu juga.
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('calculator.index') }}" class="btn-primary px-6 py-3 text-base">
                        Hitung Berat &amp; Harga
                    </a>
                    <a href="{{ route('products.index') }}" class="btn border border-stone-600 bg-transparent px-6 py-3 text-base text-white hover:border-brand-400 hover:text-brand-400 focus:ring-brand-400">
                        Lihat Katalog
                    </a>
                </div>

                <dl class="mt-10 grid grid-cols-3 gap-6 border-t border-stone-800 pt-6">
                    <div>
                        <dt class="text-3xl font-extrabold text-brand-400">9+</dt>
                        <dd class="mt-1 text-xs text-stone-400">Jenis material</dd>
                    </div>
                    <div>
                        <dt class="text-3xl font-extrabold text-brand-400">Harian</dt>
                        <dd class="mt-1 text-xs text-stone-400">Harga diperbarui</dd>
                    </div>
                    <div>
                        <dt class="text-3xl font-extrabold text-brand-400">COD</dt>
                        <dd class="mt-1 text-xs text-stone-400">Bayar di tempat</dd>
                    </div>
                </dl>
            </div>

            <div class="card overflow-hidden border-0 bg-ink-900 p-6 shadow-2xl sm:p-8">
                <p class="text-xs font-semibold uppercase tracking-widest text-brand-400">Kalkulator Cepat</p>
                <h2 class="mt-2 text-2xl text-white">Plat Baja 1000 × 500 × 10 mm</h2>
                <div class="mt-6 space-y-4 text-sm">
                    <div class="flex items-center justify-between border-b border-stone-800 pb-3">
                        <span class="text-stone-400">Volume</span>
                        <span class="font-semibold text-white">0,005 m³</span>
                    </div>
                    <div class="flex items-center justify-between border-b border-stone-800 pb-3">
                        <span class="text-stone-400">Berat (density 7.850 kg/m³)</span>
                        <span class="font-semibold text-white">39,25 kg</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-stone-400">Estimasi harga @ Rp 7.000/kg</span>
                        <span class="text-2xl font-extrabold text-brand-400">Rp 274.750</span>
                    </div>
                </div>
                <a href="{{ route('calculator.index') }}" class="btn-primary mt-6 w-full">Coba Kalkulator Lengkap</a>
                <p class="mt-3 text-center text-xs text-stone-400">Mendukung plat, pipa, batang, siku, kawat &amp; profil IWF/UNP</p>
            </div>
        </div>
    </section>

    {{-- LAYANAN --}}
    <section class="bg-ash">
        <div class="container-page py-16 lg:py-20">
            <div class="mx-auto max-w-2xl text-center">
                <p class="text-sm font-semibold uppercase tracking-widest text-brand-400">Layanan Kami</p>
                <h2 class="mt-2 text-3xl text-white sm:text-4xl">Satu tempat untuk semua scrap Anda</h2>
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-3">
                @php($services = [
                    ['title' => 'Beli Barang Bekas', 'desc' => 'Kami beli berbagai barang bekas layak pakai maupun rongsok: elektronik, furnitur, mesin, dan peralatan.', 'icon' => '&#8644;'],
                    ['title' => 'Jual Logam & Besi', 'desc' => 'Menjual besi, plat, pipa, tembaga, kuningan, alumunium, dan stainless terpilih untuk kebutuhan Anda.', 'icon' => '&#9874;'],
                    ['title' => 'Jasa Angkut', 'desc' => 'Armada siap jemput barang dari rumah, bengkel, maupun pabrik — termasuk bongkar muat.', 'icon' => '&#8646;'],
                ])
                @foreach ($services as $service)
                    <div class="card border-stone-600 p-6 transition hover:-translate-y-1 hover:shadow-lg">
                        <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-ink-800 text-2xl text-brand-400">{!! $service['icon'] !!}</span>
                        <h3 class="mt-5 text-lg text-white">{{ $service['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-stone-400">{{ $service['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- KATALOG PREVIEW --}}
    <section class="section-divider bg-ash py-16 text-stone-100 lg:py-20">
        <div class="container-page">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-widest text-brand-400">Katalog</p>
                    <h2 class="mt-2 text-3xl">Yang kami jual &amp; terima</h2>
                </div>
                <a href="{{ route('products.index') }}" class="btn-outline">Semua Produk &rarr;</a>
            </div>

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($featured as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- CARA KERJA --}}
    <section class="section-divider bg-ash">
        <div class="container-page py-16 lg:py-20">
            <div class="mx-auto max-w-2xl text-center">
                <p class="text-sm font-semibold uppercase tracking-widest text-brand-400">Cara Kerja</p>
                <h2 class="mt-2 text-3xl text-white sm:text-4xl">Tiga langkah, langsung cair</h2>
            </div>

            <ol class="mt-12 grid gap-6 md:grid-cols-3">
                @php($steps = [
                    ['no' => '01', 'title' => 'Kirim Daftar Barang', 'desc' => 'Chat WhatsApp, kirim foto & perkiraan berat, atau datang langsung ke lokasi kami.'],
                    ['no' => '02', 'title' => 'Timbang di Tempat', 'desc' => 'Tim kami jemput, lalu timbang bersama secara transparan menggunakan timbangan resmi.'],
                    ['no' => '03', 'title' => 'Bayar Saat Itu Juga', 'desc' => 'Harga mengikuti pasar harian. Setuju → bayar tunai/transfer saat itu juga.'],
                ])
                @foreach ($steps as $step)
                    <li class="card relative border-stone-600 p-6">
                        <span class="text-4xl font-extrabold text-ink-800">{{ $step['no'] }}</span>
                        <h3 class="mt-3 text-lg text-white">{{ $step['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-stone-400">{{ $step['desc'] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- CTA --}}
    <section class="section-divider bg-ash">
        <div class="container-page flex flex-col items-center justify-between gap-6 py-12 text-center sm:text-left lg:flex-row">
            <div>
                <h2 class="text-2xl text-white sm:text-3xl">Punya barang bekas atau scrap logam?</h2>
                <p class="mt-2 text-stone-300">Hubungi kami sekarang — estimasi harga gratis lewat kalkulator atau chat langsung.</p>
            </div>
            <div class="flex flex-wrap justify-center gap-3">
                <a href="{{ route('calculator.index') }}" class="btn-primary px-6 py-3">Kalkulator Harga</a>
                @if (! empty($settings['whatsapp']))
                    <a href="https://wa.me/{{ $settings['whatsapp'] }}" target="_blank" rel="noopener"
                       class="btn border border-stone-500 bg-transparent px-6 py-3 text-white hover:border-brand-400 hover:text-brand-400 focus:ring-brand-400">Chat WhatsApp</a>
                @endif
            </div>
        </div>
    </section>
@endsection
