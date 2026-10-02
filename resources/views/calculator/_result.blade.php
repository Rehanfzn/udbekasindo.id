@php
    $material = $result['material'];
    $shapeConfig = config('calculator.shapes.'.$result['shape']);
    $whatsapp = \App\Models\Setting::get('whatsapp');

    $dimensionLines = [];
    foreach ($shapeConfig['fields'] ?? [] as $field) {
        $value = $inputs[$field['key']] ?? null;
        if ($value !== null && $value !== '') {
            $dimensionLines[] = $field['label'].': '.$value.' '.$field['unit'];
        }
    }
    if ($result['profile']) {
        $dimensionLines[] = 'Profil: '.$result['profile']->size.' ('.number_format($result['profile']->weight_per_m, 2, ',', '.') .' kg/m)';
    }
    $dimensionLines[] = 'Jumlah: '.$result['quantity'];

    $waLines = [
        'Halo '.(\App\Models\Setting::get('company_name') ?? 'UD Bekas Indo').', saya minta penawaran untuk:',
        'Material: '.$material->name.' ('.($shapeConfig['label'] ?? '').')',
        'Dimensi: '.implode(', ', $dimensionLines),
    ];
    if ($result['volume_m3'] !== null) {
        $waLines[] = 'Volume: '.number_format($result['volume_m3'], 4, ',', ' ').' m³';
    }
    $waLines[] = 'Berat: '.number_format($result['weight_kg'], 2, ',', '.').' kg';
    $waLines[] = 'Estimasi harga: Rp '.number_format($result['price'], 0, ',', '.');
    $waMessage = implode("\n", $waLines);
@endphp

<div class="card overflow-hidden">
    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-ink-800 bg-ink-950 px-6 py-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-widest text-brand-400">Hasil Perhitungan</p>
            <h2 class="mt-1 text-lg text-white">{{ $shapeConfig['label'] ?? '' }} — {{ $material->name }}</h2>
        </div>
        <span class="badge bg-brand-500/15 text-brand-400 ring-1 ring-brand-500/30">Estimasi</span>
    </div>

    <div class="grid gap-6 p-6 sm:grid-cols-2">
        <div class="space-y-3 text-sm">
            <div class="flex justify-between border-b border-dashed border-stone-700 pb-2">
                <span class="text-stone-400">Dimensi</span>
                <span class="text-right font-medium text-stone-100">{!! implode('<br>', array_map(fn ($line) => e($line), $dimensionLines)) !!}</span>
            </div>

            <div class="flex justify-between border-b border-dashed border-stone-700 pb-2">
                <span class="text-stone-400">Volume total</span>
                <span class="font-medium text-stone-100">
                    @if ($result['volume_m3'] !== null)
                        {{ number_format($result['volume_m3'], 4, ',', '.') }} m³
                    @else
                        — (memakai kg/m)
                    @endif
                </span>
            </div>

            <div class="flex justify-between border-b border-dashed border-stone-700 pb-2">
                <span class="text-stone-400">Density</span>
                <span class="font-medium text-stone-100">{{ number_format($material->density_kg_m3, 0, ',', '.') }} kg/m³</span>
            </div>

            <div class="flex justify-between border-b border-dashed border-stone-700 pb-2">
                <span class="text-stone-400">Harga / kg</span>
                <span class="font-medium text-stone-100">Rp {{ number_format($material->price_per_kg, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="rounded-xl bg-ink-800 p-5">
            <p class="text-xs font-semibold uppercase tracking-widest text-stone-400">Berat Total</p>
            <p class="mt-1 text-3xl font-extrabold text-white">
                {{ number_format($result['weight_kg'], 2, ',', '.') }} <span class="text-base font-semibold text-stone-400">kg</span>
            </p>
            @if ($result['weight_kg'] >= 1000)
                <p class="text-sm text-stone-400">= {{ number_format($result['weight_kg'] / 1000, 3, ',', '.') }} ton</p>
            @endif

            <p class="mt-5 text-xs font-semibold uppercase tracking-widest text-stone-400">Estimasi Harga</p>
            <p class="mt-1 text-3xl font-extrabold text-brand-400">Rp {{ number_format($result['price'], 0, ',', '.') }}</p>

            @if ($whatsapp)
                <a href="https://wa.me/{{ $whatsapp }}?text={{ rawurlencode($waMessage) }}"
                   target="_blank" rel="noopener" class="btn-primary mt-5 w-full">
                    Minta Penawaran via WhatsApp
                </a>
            @endif
            <p class="mt-3 text-center text-[11px] leading-relaxed text-stone-400">
                Estimasi bersifat tidak mengikat. Harga final menyesuaikan kondisi barang &amp; pasar hari ini.
            </p>
        </div>
    </div>
</div>
