<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home', [
            'featured' => Product::query()->active()->where('is_featured', true)->limit(3)->get(),
            'latest' => Product::query()->active()->latest()->limit(6)->get(),
            'settings' => Setting::allMap(),
        ]);
    }

    public function about(): View
    {
        return view('about', [
            'settings' => Setting::allMap(),
        ]);
    }
}
