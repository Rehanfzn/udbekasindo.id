<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'materialCount' => Material::query()->count(),
            'productCount' => Product::query()->count(),
            'activeProductCount' => Product::query()->active()->count(),
            'recentProducts' => Product::query()->latest()->limit(5)->get(),
        ]);
    }
}
