<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MaterialController extends Controller
{
    public function index(): View
    {
        return view('admin.materials.index', [
            'materials' => Material::query()->orderBy('name')->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.materials.form', [
            'material' => new Material,
            'categories' => Material::CATEGORIES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('materials', 'public');
        }

        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        Material::query()->create($data);

        return redirect()->route('admin.materials.index')
            ->with('success', 'Material berhasil ditambahkan.');
    }

    public function edit(Material $material): View
    {
        return view('admin.materials.form', [
            'material' => $material,
            'categories' => Material::CATEGORIES,
        ]);
    }

    public function update(Request $request, Material $material): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $this->deleteImage($material->image);
            $data['image'] = $request->file('image')->store('materials', 'public');
        }

        $data['slug'] = $this->uniqueSlug($data['name'], $material->id);
        $data['is_active'] = $request->boolean('is_active');

        $material->update($data);

        return redirect()->route('admin.materials.index')
            ->with('success', 'Material berhasil diperbarui.');
    }

    public function destroy(Material $material): RedirectResponse
    {
        $this->deleteImage($material->image);
        $material->delete();

        return redirect()->route('admin.materials.index')
            ->with('success', 'Material berhasil dihapus.');
    }

    /** @return array<string, mixed> */
    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:'.implode(',', array_keys(Material::CATEGORIES))],
            'density_kg_m3' => ['required', 'numeric', 'min:0.01', 'max:100000'],
            'price_per_kg' => ['required', 'numeric', 'min:0', 'max:1000000000'],
            'description' => ['nullable', 'string', 'max:2000'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'material';
        $slug = $base;
        $i = 2;

        while (Material::query()->where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    private function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
