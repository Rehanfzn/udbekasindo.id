@extends('layouts.admin')

@section('title', $product->exists ? 'Edit Produk' : 'Tambah Produk')

@section('content')
    <form method="POST"
          action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}"
          enctype="multipart/form-data"
          class="card max-w-3xl p-6 sm:p-8">
        @csrf
        @if ($product->exists) @method('PUT') @endif

        <div class="grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="title" class="label">Judul Produk</label>
                <input type="text" name="title" id="title" class="input" required
                       value="{{ old('title', $product->title) }}" placeholder="Contoh: Plat Baja Bekas">
                @error('title') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="category" class="label">Kategori</label>
                <select name="category" id="category" class="input" required>
                    @foreach ($categories as $key => $label)
                        <option value="{{ $key }}" @selected(old('category', $product->category) === $key)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('category') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="price_label" class="label">Label Harga (opsional)</label>
                <input type="text" name="price_label" id="price_label" class="input"
                       value="{{ old('price_label', $product->price_label) }}" placeholder="Per kg / Hubungi kami / Nego">
                @error('price_label') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="image" class="label">Gambar (opsional, maks 2 MB)</label>
                <input type="file" name="image" id="image" class="input" accept="image/*">
                @error('image') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="is_featured" class="label">&nbsp;</label>
                <label class="flex h-[42px] items-center gap-2 rounded-lg border border-stone-600 px-3.5 text-sm text-stone-300">
                    <input type="checkbox" name="is_featured" value="1" class="rounded border-stone-600 text-brand-700 focus:ring-brand-600"
                           @checked(old('is_featured', $product->is_featured))>
                    Tampilkan di beranda (unggulan)
                </label>
            </div>

            <div class="sm:col-span-2">
                <label for="description" class="label">Deskripsi</label>
                <textarea name="description" id="description" rows="5" class="input"
                          placeholder="Jelaskan kondisi, jenis, dan ketersediaan barang.">{{ old('description', $product->description) }}</textarea>
                @error('description') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <label class="flex items-center gap-2 text-sm text-stone-300 sm:col-span-2">
                <input type="checkbox" name="is_active" value="1" class="rounded border-stone-600 text-brand-700 focus:ring-brand-600"
                       @checked(old('is_active', $product->exists ? $product->is_active : true))>
                Aktif (tampilkan di katalog)
            </label>
        </div>

        @if ($product->image)
            <div class="mt-5">
                <p class="label">Gambar saat ini</p>
                <img src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}" alt="{{ $product->title }}"
                     class="h-24 w-24 rounded-lg object-cover ring-1 ring-stone-700">
            </div>
        @endif

        <div class="mt-7 flex gap-3">
            <button type="submit" class="btn-primary px-8">{{ $product->exists ? 'Simpan Perubahan' : 'Tambah Produk' }}</button>
            <a href="{{ route('admin.products.index') }}" class="btn-outline">Batal</a>
        </div>
    </form>
@endsection
