<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::query()->active()->latest();

        if ($request->filled('kategori') && array_key_exists($request->string('kategori')->toString(), Product::CATEGORIES)) {
            $query->where('category', $request->string('kategori')->toString());
        }

        if ($request->filled('q')) {
            $q = $request->string('q')->toString();
            $query->where(function ($builder) use ($q) {
                $builder->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        return view('products.index', [
            'products' => $query->paginate(9)->withQueryString(),
            'categories' => Product::CATEGORIES,
            'activeCategory' => $request->string('kategori')->toString(),
            'q' => $request->string('q')->toString(),
        ]);
    }

    public function show(string $slug): View
    {
        $product = Product::query()->active()->where('slug', $slug)->firstOrFail();

        $related = Product::query()
            ->active()
            ->where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->limit(3)
            ->get();

        return view('products.show', [
            'product' => $product,
            'related' => $related,
        ]);
    }
}
