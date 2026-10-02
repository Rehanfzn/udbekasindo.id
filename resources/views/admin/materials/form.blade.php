@extends('layouts.admin')

@section('title', $material->exists ? 'Edit Material' : 'Tambah Material')

@section('content')
    <form method="POST"
          action="{{ $material->exists ? route('admin.materials.update', $material) : route('admin.materials.store') }}"
          enctype="multipart/form-data"
          class="card max-w-3xl p-6 sm:p-8">
        @csrf
        @if ($material->exists) @method('PUT') @endif

        <div class="grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="name" class="label">Nama Material</label>
                <input type="text" name="name" id="name" class="input" required
                       value="{{ old('name', $material->name) }}" placeholder="Contoh: Tembaga">
                @error('name') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="category" class="label">Kategori</label>
                <select name="category" id="category" class="input" required>
                    @foreach ($categories as $key => $label)
                        <option value="{{ $key }}" @selected(old('category', $material->category) === $key)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('category') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="density_kg_m3" class="label">Density (kg/m³)</label>
                <input type="number" name="density_kg_m3" id="density_kg_m3" class="input" required min="0.01" step="any"
                       value="{{ old('density_kg_m3', $material->density_kg_m3) }}" placeholder="7850">
                @error('density_kg_m3') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="price_per_kg" class="label">Harga per Kg (Rp)</label>
                <input type="number" name="price_per_kg" id="price_per_kg" class="input" required min="0" step="1"
                       value="{{ old('price_per_kg', $material->price_per_kg) }}" placeholder="7000">
                @error('price_per_kg') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="image" class="label">Gambar (opsional, JPG/PNG/WEBP maks 2 MB)</label>
                <input type="file" name="image" id="image" class="input" accept="image/*">
                @error('image') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <div class="sm:col-span-2">
                <label for="description" class="label">Deskripsi Singkat</label>
                <textarea name="description" id="description" rows="3" class="input"
                          placeholder="Contoh: Tembaga murni dari kabel, pipa, trafo.">{{ old('description', $material->description) }}</textarea>
                @error('description') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <label class="flex items-center gap-2 text-sm text-stone-300 sm:col-span-2">
                <input type="checkbox" name="is_active" value="1" class="rounded border-stone-600 text-brand-700 focus:ring-brand-600"
                       @checked(old('is_active', $material->exists ? $material->is_active : true))>
                Tampilkan di kalkulator &amp; daftar harga (aktif)
            </label>
        </div>

        @if ($material->image)
            <div class="mt-5">
                <p class="label">Gambar saat ini</p>
                <img src="{{ \Illuminate\Support\Facades\Storage::url($material->image) }}" alt="{{ $material->name }}"
                     class="h-24 w-24 rounded-lg object-cover ring-1 ring-stone-700">
            </div>
        @endif

        <div class="mt-7 flex gap-3">
            <button type="submit" class="btn-primary px-8">{{ $material->exists ? 'Simpan Perubahan' : 'Tambah Material' }}</button>
            <a href="{{ route('admin.materials.index') }}" class="btn-outline">Batal</a>
        </div>
    </form>
@endsection
