@extends('layouts.admin')

@section('title', 'Katalog Produk')

@section('content')
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <p class="text-sm text-stone-600">Produk yang aktif akan tampil di halaman katalog publik.</p>
        <a href="{{ route('admin.products.create') }}" class="btn-primary">+ Tambah Produk</a>
    </div>

    <div class="card overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-ink-800 text-left text-xs font-semibold uppercase tracking-wide text-stone-400">
                <tr>
                    <th class="px-5 py-3">Produk</th>
                    <th class="px-5 py-3">Kategori</th>
                    <th class="px-5 py-3">Harga</th>
                    <th class="px-5 py-3 text-center">Status</th>
                    <th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-800">
                @forelse ($products as $product)
                    <tr>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                @if ($product->image)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}" alt=""
                                         class="h-10 w-10 rounded-lg object-cover ring-1 ring-stone-700">
                                @else
                                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-ink-950 text-sm font-black text-brand-400">
                                        {{ mb_substr($product->title, 0, 1) }}
                                    </span>
                                @endif
                                <div>
                                    <p class="font-medium text-white">{{ $product->title }}</p>
                                    @if ($product->is_featured)
                                        <span class="badge mt-0.5 bg-brand-500/20 text-brand-300">Unggulan</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-stone-400">{{ $product->category_label }}</td>
                        <td class="px-5 py-3 text-stone-400">{{ $product->price_label ?: '—' }}</td>
                        <td class="px-5 py-3 text-center">
                            @if ($product->is_active)
                                <span class="badge bg-green-950 text-green-400">Aktif</span>
                            @else
                                <span class="badge bg-ink-800 text-stone-400">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-right whitespace-nowrap">
                            <a href="{{ route('admin.products.edit', $product) }}" class="font-medium text-brand-400 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                  class="ml-3 inline" data-confirm="Hapus produk {{ $product->title }}?">
                                @csrf @method('DELETE')
                                <button type="submit" class="font-medium text-red-400 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-8 text-center text-stone-400">Belum ada produk.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
@endsection
