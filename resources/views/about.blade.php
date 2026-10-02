@extends('layouts.app')

@section('title', 'Tentang Kami — '.($settings['company_name'] ?? 'UD Bekas Indo'))

@section('content')
    <section class="bg-ash py-16 text-white lg:py-20">
        <div class="container-page max-w-3xl">
            <p class="text-sm font-semibold uppercase tracking-widest text-brand-400">Tentang Kami</p>
            <h1 class="mt-3 text-3xl text-white sm:text-4xl">{{ $settings['company_name'] ?? 'UD Bekas Indo' }}</h1>
            <p class="mt-4 text-lg leading-relaxed text-stone-400">{{ $settings['tagline'] ?? '' }}</p>
        </div>
    </section>

    <section class="container-page grid gap-10 bg-ash py-16 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <h2 class="text-2xl text-white">Siapa Kami</h2>
            <div class="mt-4 space-y-4 leading-relaxed text-stone-300">
                {!! nl2br(e($settings['about'] ?? '')) !!}
            </div>

            <h2 class="mt-10 text-2xl text-white">Nilai Kami</h2>
            <div class="mt-5 grid gap-4 sm:grid-cols-3">
                @php($values = [
                    ['t' => 'Transparan', 'd' => 'Timbangan dibuka, harga pasar — tanpa potongan tersembunyi.'],
                    ['t' => 'Responsif', 'd' => 'Chat cepat dijawab, jemput sesuai janji.'],
                    ['t' => 'Tepat Waktu', 'd' => 'Barang diangkut dan pembayaran dilakukan di lokasi.'],
                ])
                @foreach ($values as $value)
                    <div class="card p-5">
                        <h3 class="text-base text-brand-400">{{ $value['t'] }}</h3>
                        <p class="mt-1.5 text-sm text-stone-400">{{ $value['d'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <aside class="card h-fit p-6">
            <h2 class="text-lg text-white">Informasi Kontak</h2>
            <dl class="mt-4 space-y-4 text-sm">
                <div>
                    <dt class="font-semibold text-stone-400">Alamat</dt>
                    <dd class="mt-0.5 text-stone-100">{{ $settings['address'] ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-stone-400">Telepon</dt>
                    <dd class="mt-0.5 text-stone-100">{{ $settings['phone'] ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-stone-400">Email</dt>
                    <dd class="mt-0.5 text-stone-100">{{ $settings['email'] ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-stone-400">Jam Operasional</dt>
                    <dd class="mt-0.5 text-stone-100">{{ $settings['working_hours'] ?? '-' }}</dd>
                </div>
            </dl>

            @if (! empty($settings['whatsapp']))
                <a href="https://wa.me/{{ $settings['whatsapp'] }}" target="_blank" rel="noopener" class="btn-primary mt-6 w-full">
                    Chat WhatsApp
                </a>
            @endif
            <a href="{{ route('calculator.index') }}" class="btn-outline mt-3 w-full">Kalkulator Harga</a>
        </aside>
    </section>
@endsection
