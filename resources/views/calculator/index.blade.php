@extends('layouts.app')

@section('title', 'Kalkulator Berat & Harga Material')

@section('content')
    <section class="bg-ash py-12 text-white">
        <div class="container-page">
            <p class="text-sm font-semibold uppercase tracking-widest text-brand-400">Kalkulator</p>
            <h1 class="mt-2 text-3xl text-white">Hitung Berat &amp; Estimasi Harga Material</h1>
            <p class="mt-2 max-w-2xl text-stone-400">
                Pilih bentuk material, masukkan dimensi, lalu sistem menghitung volume × density → berat → estimasi rupiah berdasarkan harga terkini.
            </p>
        </div>
    </section>

    <section class="container-page grid gap-8 bg-ash py-12 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <form id="calculator-form" method="POST" action="{{ route('calculator.calculate') }}" class="card p-6 sm:p-8">
                @csrf

                {{-- PILIH BENTUK --}}
                <fieldset>
                    <legend class="label">Bentuk Material</legend>
                    <div class="grid grid-cols-2 gap-2 sm:grid-cols-3">
                        @foreach ($shapes as $key => $shape)
                        <label class="cursor-pointer">
                            <input type="radio" name="shape" value="{{ $key }}" class="peer sr-only"
                                   data-description="{{ $shape['description'] }}"
                                   data-formula="{{ $shape['formula'] }}"
                                   @checked(old('shape', 'plat') === $key)>
                            <span class="block rounded-lg border border-stone-600 px-3 py-2.5 text-center text-sm font-medium text-stone-300 transition peer-checked:border-brand-500 peer-checked:bg-brand-500 peer-checked:text-ink-950 hover:border-brand-400">
                                {{ $shape['label'] }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                    <p class="mt-2 text-xs text-stone-400">
                        <span data-shape-description>{{ $shapes[old('shape', 'plat')]['description'] ?? '' }}</span>
                        <span class="text-stone-400" data-shape-formula>— {{ $shapes[old('shape', 'plat')]['formula'] ?? '' }}</span>
                    </p>
                    @error('shape') <p class="mt-2 text-xs text-red-400">{{ $message }}</p> @enderror
                </fieldset>

                {{-- MATERIAL --}}
                <div class="mt-6 grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="material_id" class="label">Jenis Material</label>
                        <select name="material_id" id="material_id" class="input" required>
                            <option value="">— Pilih material —</option>
                            @foreach ($materials as $material)
                                <option value="{{ $material->id }}"
                                    @selected((int) old('material_id') === $material->id)>
                                    {{ $material->name }} — Rp {{ number_format($material->price_per_kg, 0, ',', '.') }}/kg
                                </option>
                            @endforeach
                        </select>
                        @error('material_id') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="jumlah" class="label">Jumlah (pcs / potong)</label>
                        <input type="number" name="jumlah" id="jumlah" class="input" min="1" step="1"
                               value="{{ old('jumlah', $inputs['jumlah'] ?? 1) }}">
                        @error('jumlah') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- DIMENSI PER BENTUK --}}
                @foreach ($shapes as $key => $shape)
                    <div data-shape-panel="{{ $key }}" class="{{ old('shape', 'plat') === $key ? '' : 'hidden' }} mt-6">
                        <div class="grid gap-5 sm:grid-cols-3">
                            @foreach ($shape['fields'] as $field)
                                <div>
                                    <label for="{{ $field['key'] }}" class="label">
                                        {{ $field['label'] }}
                                        <span class="font-normal text-stone-400">({{ $field['unit'] }})</span>
                                    </label>
                                    <input type="number" name="{{ $field['key'] }}" id="{{ $field['key'] }}"
                                           class="input" min="0.01" step="any"
                                           placeholder="0"
                                           value="{{ old($field['key'], $inputs[$field['key']] ?? '') }}">
                                    @error($field['key']) <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
                                </div>
                            @endforeach

                            @if ($shape['uses_profile'])
                                <div class="sm:col-span-3">
                                    <label for="profile_id" class="label">Ukuran Profil (tabel berat standar)</label>
                                    <select name="profile_id" id="profile_id" class="input">
                                        <option value="">— Pilih ukuran —</option>
                                        @foreach ($profileGroups as $type => $items)
                                            <optgroup label="{{ $types[$type] ?? $type }}">
                                                @foreach ($items as $profile)
                                                    <option value="{{ $profile->id }}"
                                                        @selected((int) old('profile_id') === $profile->id)>
                                                        {{ $profile->size }} — {{ number_format($profile->weight_per_m, 2, ',', '.') }} kg/m
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                    @error('profile_id') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

                <div id="calculator-errors" class="mt-5 hidden rounded-lg border border-red-900 bg-red-950 p-4 text-sm text-red-300"></div>

                <div class="mt-7 flex flex-wrap items-center gap-3">
                    <button type="submit" class="btn-primary px-8 py-3">Hitung Sekarang</button>
                    <span class="text-xs text-stone-400">Hasil terhitung otomatis saat Anda mengubah nilai.</span>
                </div>
            </form>

            <div id="calculator-result" class="mt-6 {{ $result ? '' : 'hidden' }}">
                @includeWhen($result, 'calculator._result', ['result' => $result, 'inputs' => $inputs])
            </div>
        </div>

        {{-- SIDEBAR: HARGA MATERIAL --}}
        <aside class="space-y-6">
            <div class="card overflow-hidden">
                <div class="border-b border-ink-800 bg-ink-800 px-5 py-4">
                    <h2 class="text-sm font-bold uppercase tracking-wide text-stone-200">Harga Material Terkini</h2>
                    <p class="mt-0.5 text-xs text-stone-400">Per kg — dapat berubah mengikuti pasar.</p>
                </div>
                <table class="w-full text-sm">
                    <tbody>
                    @forelse ($materials as $material)
                        <tr class="border-b border-stone-800 last:border-0">
                            <td class="px-5 py-2.5">
                                {{ $material->name }}
                                <span class="block text-xs text-stone-400">ρ {{ number_format($material->density_kg_m3, 0, ',', '.') }} kg/m³</span>
                            </td>
                            <td class="px-5 py-2.5 text-right font-semibold text-brand-400 whitespace-nowrap">
                                Rp {{ number_format($material->price_per_kg, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr><td class="px-5 py-4 text-stone-400">Belum ada data harga.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card p-5">
                <h2 class="text-sm font-bold uppercase tracking-wide text-stone-200">Cara Menghitung</h2>
                <ol class="mt-3 list-inside list-decimal space-y-2 text-sm text-stone-300">
                    <li>Pilih bentuk material (plat, pipa, batang, siku, kawat, atau profil).</li>
                    <li>Masukkan dimensi dalam <strong>mm</strong> (profil: meter).</li>
                    <li>Sistem menghitung volume × density = berat.</li>
                    <li>Berat × harga/kg = estimasi harga Anda.</li>
                </ol>
                <p class="mt-3 text-xs text-stone-400">Nilai density &amp; harga dikelola admin dan diperbarui berkala. Hasil bersifat estimasi — harga final mengikuti negosiasi &amp; kondisi barang.</p>
            </div>
        </aside>
    </section>
@endsection
