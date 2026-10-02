@extends('layouts.admin')

@section('title', 'Pengaturan')

@section('content')
    <form method="POST" action="{{ route('admin.settings.update') }}" class="card max-w-3xl p-6 sm:p-8">
        @csrf
        @method('PUT')

        <p class="text-sm text-stone-400">
            Informasi ini tampil di beranda, halaman tentan, footer, dan tautan WhatsApp.
        </p>

        <div class="mt-6 grid gap-5 sm:grid-cols-2">
            @foreach ($fields as $key => $label)
                <div class="{{ in_array($key, ['about', 'address', 'footer_note']) ? 'sm:col-span-2' : '' }}">
                    @if ($key === 'about')
                        <label for="{{ $key }}" class="label">{{ $label }}</label>
                        <textarea name="{{ $key }}" id="{{ $key }}" rows="6" class="input">{{ old($key, $settings[$key] ?? '') }}</textarea>
                    @else
                        <label for="{{ $key }}" class="label">{{ $label }}</label>
                        <input type="text" name="{{ $key }}" id="{{ $key }}" class="input"
                               value="{{ old($key, $settings[$key] ?? '') }}">
                    @endif
                    @error($key) <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
            @endforeach
        </div>

        <div class="mt-7">
            <button type="submit" class="btn-primary px-8">Simpan Pengaturan</button>
        </div>
    </form>
@endsection
