<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    private const FIELDS = [
        'company_name' => 'Nama Perusahaan',
        'tagline' => 'Tagline',
        'phone' => 'Nomor Telepon',
        'whatsapp' => 'Nomor WhatsApp (format: 6281234567890)',
        'email' => 'Email',
        'address' => 'Alamat',
        'working_hours' => 'Jam Operasional',
        'about' => 'Tentang Perusahaan',
        'footer_note' => 'Catatan Footer',
    ];

    public function edit(): View
    {
        return view('admin.settings.edit', [
            'fields' => self::FIELDS,
            'settings' => Setting::allMap(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $rules = [];

        foreach (array_keys(self::FIELDS) as $key) {
            $rules[$key] = $key === 'company_name'
                ? ['required', 'string', 'max:255']
                : ($key === 'whatsapp'
                    ? ['nullable', 'string', 'max:20', 'regex:/^\d{8,15}$/']
                    : ['nullable', 'string', 'max:5000']);
        }

        $data = $request->validate($rules);

        foreach ($data as $key => $value) {
            Setting::set($key, $value === '' ? null : $value);
        }

        return redirect()->route('admin.settings.edit')
            ->with('success', 'Pengaturan berhasil disimpan.');
    }
}
