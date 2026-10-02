@extends('layouts.app')

@section('title', $product->title)

@section('content')
    <div class="border-b border-stone-800 bg-ink-900">
        <div class="container-page py-4 text-sm text-stone-400">
            <a href="{{ route('home') }}" class="hover:text-brand-400">Beranda</a>
            <span class="mx-2">/</span>
            <a href="{{ route('products.index') }}" class="hover:text-brand-400">Katalog</a>
            <span class="mx-2">/</span>
            <span class="text-stone-100">{{ $product->title }}</span>
        </div>
    </div>

    <section class="container-page grid gap-10 bg-ash py-12 lg:grid-cols-2">
        <div class="card overflow-hidden">
            @if ($product->image)
                <img src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}"
                     alt="{{ $product->title }}" class="h-full max-h-[420px] w-full object-cover">
            @else
                <div class="flex h-80 items-center justify-center bg-gradient-to-br from-ink-900 to-ink-950 sm:h-full sm:min-h-[420px]">
                    <span class="text-7xl font-black text-ink-800 select-none">{{ mb_substr($product->title, 0, 1) }}</span>
                </div>
            @endif
        </div>

        <div>
            <span class="badge bg-ink-800 text-brand-400 ring-1 ring-brand-500/40">{{ $product->category_label }}</span>
            <h1 class="mt-4 text-3xl">{{ $product->title }}</h1>

            @if ($product->price_label)
                <p class="mt-3 text-lg font-semibold text-brand-400">{{ $product->price_label }}</p>
            @endif

            <div class="mt-5 leading-relaxed text-stone-300">
                {!! nl2br(e($product->description ?? '')) !!}
            </div>

            <div class="mt-8 rounded-xl bg-ink-900 p-5 text-stone-300">
                <h2 class="text-sm font-bold uppercase tracking-wide text-stone-400">Estimasi sendiri dulu?</h2>
                <p class="mt-1 text-sm text-stone-300">Gunakan kalkulator kami untuk menghitung berat dan estimasi harga dari dimensi material.</p>
                <a href="{{ route('calculator.index') }}" class="btn-primary mt-4">Buka Kalkulator Harga</a>
            </div>

            @if (\App\Models\Setting::get('whatsapp'))
                <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp') }}?text={{ rawurlencode('Halo, saya tertarik dengan: '.$product->title.' ('.route('products.show', $product->slug).')') }}"
                   target="_blank" rel="noopener" class="btn-dark mt-4 w-full">
                    Tanya via WhatsApp
                </a>
            @endif
        </div>
    </section>

    @if ($related->isNotEmpty())
        <section class="container-page bg-ash py-12">
            <h2 class="text-2xl text-white">Produk Lainnya</h2>
            <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($related as $item)
                    <x-product-card :product="$item" />
                @endforeach
            </div>
        </section>
    @endif
@endsection
