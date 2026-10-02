<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StructuralProfile;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        return view('admin.profiles.index', [
            'groups' => StructuralProfile::query()
                ->orderBy('type')
                ->orderBy('weight_per_m')
                ->get()
                ->groupBy('type'),
            'types' => StructuralProfile::TYPES,
        ]);
    }
}
