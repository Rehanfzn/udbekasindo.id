@extends('layouts.app')

@section('title', 'Katalog Produk & Jasa')

@section('content')
    <section class="bg-ash py-12 text-white">
        <div class="container-page">
            <p class="text-sm font-semibold uppercase tracking-widest text-brand-400">Katalog</p>
            <h1 class="mt-2 text-3xl text-white">Produk &amp; Jasa</h1>
            <p class="mt-2 max-w-2xl text-stone-400">Barang bekas terpilih, material logam, dan jasa angkut. Harga mengikuti pasar — hubungi kami untuk partai besar.</p>
        </div>
    </section>

    <section class="container-page bg-ash py-10">
        <form method="GET" action="{{ route('products.index') }}" class="flex flex-col gap-4 sm:flex-row sm:items-center">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('products.index') }}"
                   class="badge px-3 py-1.5 {{ $activeCategory === '' ? 'bg-ink-950 text-white' : 'bg-ink-900 text-stone-300 ring-1 ring-stone-600 hover:ring-brand-400' }}">
                    Semua
                </a>
                @foreach ($categories as $key => $label)
                    <a href="{{ route('products.index', ['kategori' => $key]) }}"
                       class="badge px-3 py-1.5 {{ $activeCategory === $key ? 'bg-ink-950 text-white' : 'bg-ink-900 text-stone-300 ring-1 ring-stone-600 hover:ring-brand-400' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            <div class="flex gap-2 sm:ml-auto sm:w-72">
                <input type="search" name="q" value="{{ $q }}" placeholder="Cari produk..."
                       class="input" aria-label="Cari produk">
                <button type="submit" class="btn-dark shrink-0">Cari</button>
            </div>
        </form>

        @if ($products->isEmpty())
            <div class="card mt-8 p-12 text-center">
                <p class="text-lg font-semibold text-stone-200">Produk tidak ditemukan</p>
                <p class="mt-1 text-sm text-stone-400">Coba kata kunci atau kategori lain.</p>
                <a href="{{ route('products.index') }}" class="btn-outline mt-5">Reset Filter</a>
            </div>
        @else
            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            <div class="mt-10">
                {{ $products->links() }}
            </div>
        @endif
    </section>
@endsection
