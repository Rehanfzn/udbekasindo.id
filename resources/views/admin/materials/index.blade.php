@extends('layouts.admin')

@section('title', 'Material & Harga')

@section('content')
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <p class="text-sm text-stone-600">Density &amp; harga per kg dipakai langsung oleh kalkulator.</p>
        <a href="{{ route('admin.materials.create') }}" class="btn-primary">+ Tambah Material</a>
    </div>

    <div class="card overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-ink-800 text-left text-xs font-semibold uppercase tracking-wide text-stone-400">
                <tr>
                    <th class="px-5 py-3">Material</th>
                    <th class="px-5 py-3">Kategori</th>
                    <th class="px-5 py-3 text-right">Density (kg/m³)</th>
                    <th class="px-5 py-3 text-right">Harga / kg</th>
                    <th class="px-5 py-3 text-center">Status</th>
                    <th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-800">
                @forelse ($materials as $material)
                    <tr>
                        <td class="px-5 py-3">
                            <p class="font-medium text-white">{{ $material->name }}</p>
                            @if ($material->description)
                                <p class="mt-0.5 max-w-md truncate text-xs text-stone-400">{{ $material->description }}</p>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-stone-400">{{ $material->category_label }}</td>
                        <td class="px-5 py-3 text-right tabular-nums">{{ number_format($material->density_kg_m3, 0, ',', '.') }}</td>
                        <td class="px-5 py-3 text-right font-semibold text-brand-400 tabular-nums">
                            Rp {{ number_format($material->price_per_kg, 0, ',', '.') }}
                        </td>
                        <td class="px-5 py-3 text-center">
                            @if ($material->is_active)
                                <span class="badge bg-green-950 text-green-400">Aktif</span>
                            @else
                                <span class="badge bg-ink-800 text-stone-400">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-right whitespace-nowrap">
                            <a href="{{ route('admin.materials.edit', $material) }}" class="font-medium text-brand-400 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.materials.destroy', $material) }}"
                                  class="ml-3 inline" data-confirm="Hapus material {{ $material->name }}?">
                                @csrf @method('DELETE')
                                <button type="submit" class="font-medium text-red-400 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-8 text-center text-stone-400">Belum ada material.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $materials->links() }}
    </div>
@endsection
