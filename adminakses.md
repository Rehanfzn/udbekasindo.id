# Akses Admin — UD Bekas Indo

Dokumen ini berisi kredensial login admin dan struktur panel admin.
Sumber kebenaran ada di kode — dokumen ini hanya ringkasan referensi.

---

## 1. Kredensial Admin

| Item        | Nilai                       |
|-------------|-----------------------------|
| URL login   | `/admin/login`              |
| Email (ID)  | `admin@udbekasindo.id`      |
| Password    | `password`                  |
| Nama        | Admin UD Bekas Indo         |
| Role        | `is_admin = true`           |

- Login hanya menggunakan **email + password** (tidak ada field username).
- Akun dibuat oleh `database/seeders/AdminUserSeeder.php` dan didaftarkan
  pertama kali di `database/seeders/DatabaseSeeder.php`.
- Password diambil dari env `APP_ADMIN_PASSWORD`, fallback ke literal
  `password`. Karena `APP_ADMIN_PASSWORD` **tidak didefinisikan** di `.env`
  maupun `.env.example`, maka password aktif saat ini adalah `password`.
- Password disimpan sebagai bcrypt (cost 12) via cast
  `'password' => 'hashed'` di `app/Models/User.php`.

### Mengubah password

```powershell
# Opsi A — lewat env (disarankan)
# 1. tambahkan ke .env :  APP_ADMIN_PASSWORD=rahasia-baru
# 2. jalankan ulang seeder (idempoten, email jadi kunci update)
php artisan db:seed --class=AdminUserSeeder
```

```php
// Opsi B — lewat tinker (wajib lewat model, bukan query builder,
// agar cast 'hashed' ikut terpakai)
php artisan tinker
>>> $u = App\Models\User::firstWhere('email', 'admin@udbekasindo.id');
>>> $u->password = 'rahasia-baru';
>>> $u->save();   // tersimpan bcrypt otomatis
```

> Hindari `User::where(...)->update([...])` — query builder mem-bypass cast,
> password akan tersimpan dalam bentuk plaintext dan login jadi gagal.

---

## 2. Model & Kolom

Tabel admin terpisah **tidak ada**. Satu tabel `users` dipakai untuk semua
pengguna, dibedakan hanya oleh satu kolom boolean.

| Field | Sumber |
|-------|--------|
| `id`, `name`, `email` (unique), `password`, `remember_token` | `database/migrations/0001_01_01_000000_create_users_table.php` |
| `is_admin` (boolean, default `false`) | `database/migrations/2026_10_01_000500_add_is_admin_to_users_table.php` |

- Model: `app/Models/User.php` — `fillable`: `name, email, password, is_admin`;
  `hidden`: `password, remember_token`; cast `is_admin` => boolean.
- Tidak ada package role/permission (spatie dkk.) dan tidak ada Gate/Policy —
  cukup satu boolean `is_admin`.

---

## 3. Alur Autentikasi & Proteksi

```
GET  /admin/login          → AuthController@showLogin   (middleware: guest)
POST /admin/login          → AuthController@login       (middleware: guest, throttle:5,1)
POST /admin/logout         → AuthController@logout      (middleware: auth, admin)
```

Dua lapis penjagaan (defense in depth):

1. **Route middleware `admin`** → `app/Http/Middleware/EnsureAdmin.php`
   - abort `403 "Anda tidak memiliki akses ke halaman admin."` bila user null
     atau `is_admin` false.
   - Alias didaftarkan di `bootstrap/app.php` (`'admin' => EnsureAdmin::class`),
     bersama `redirectGuestsTo` → `admin.login` dan `redirectUsersTo` →
     `admin.dashboard` (jika admin) / `admin.login`.
2. **Cek ulang di `AuthController::login`** — sesudah `Auth::attempt` berhasil,
   bila `is_admin` false maka session di-invalidate dan user di-logout dengan
   pesan "Akun ini tidak memiliki akses admin."

Tambahan: rate limit **5 percobaan / 1 menit** pada `POST /admin/login`.

---

## 4. Route Admin

Semua route ber-prefix `/admin` dan bernama `admin.*` — `routes/web.php`.

| Method | URI | Name | Controller | Middleware |
|--------|-----|------|------------|------------|
| GET | `/admin/login` | `admin.login` | `AuthController@showLogin` | guest |
| POST | `/admin/login` | `admin.login.attempt` | `AuthController@login` | guest, throttle:5,1 |
| POST | `/admin/logout` | `admin.logout` | `AuthController@logout` | auth, admin |
| GET | `/admin` | `admin.dashboard` | `DashboardController@index` | auth, admin |
| GET | `/admin/materials` | `admin.materials.index` | `MaterialController@index` | auth, admin |
| GET | `/admin/materials/create` | `admin.materials.create` | `MaterialController@create` | auth, admin |
| POST | `/admin/materials` | `admin.materials.store` | `MaterialController@store` | auth, admin |
| GET | `/admin/materials/{material}/edit` | `admin.materials.edit` | `MaterialController@edit` | auth, admin |
| PUT/PATCH | `/admin/materials/{material}` | `admin.materials.update` | `MaterialController@update` | auth, admin |
| DELETE | `/admin/materials/{material}` | `admin.materials.destroy` | `MaterialController@destroy` | auth, admin |
| GET | `/admin/products` | `admin.products.index` | `ProductController@index` | auth, admin |
| GET | `/admin/products/create` | `admin.products.create` | `ProductController@create` | auth, admin |
| POST | `/admin/products` | `admin.products.store` | `ProductController@store` | auth, admin |
| GET | `/admin/products/{product}/edit` | `admin.products.edit` | `ProductController@edit` | auth, admin |
| PUT/PATCH | `/admin/products/{product}` | `admin.products.update` | `ProductController@update` | auth, admin |
| DELETE | `/admin/products/{product}` | `admin.products.destroy` | `ProductController@destroy` | auth, admin |
| GET | `/admin/settings` | `admin.settings.edit` | `SettingController@edit` | auth, admin |
| PUT | `/admin/settings` | `admin.settings.update` | `SettingController@update` | auth, admin |
| GET | `/admin/profiles` | `admin.profiles.index` | `ProfileController@index` | auth, admin |

> `Route::resource ... ->except(['show'])` — halaman detail tidak dipakai.

---

## 5. Controllers

Semua berada di `app/Http/Controllers/Admin/`:

| File | Method | Keterangan |
|------|--------|------------|
| `AuthController.php` | `showLogin`, `login`, `logout` | login/logout + guard `is_admin` |
| `DashboardController.php` | `index` | ringkasan: jumlah material/produk, 5 produk terbaru |
| `MaterialController.php` | `index`, `create`, `store`, `edit`, `update`, `destroy` | CRUD material & harga |
| `ProductController.php` | `index`, `create`, `store`, `edit`, `update`, `destroy` | CRUD katalog produk |
| `SettingController.php` | `edit`, `update` | pengaturan situs |
| `ProfileController.php` | `index` | tabel profil baja (read-only) |

---

## 6. Views

```
resources/views/
├── layouts/
│   ├── admin.blade.php        # shell panel: sidebar, header, flash message
│   └── app.blade.php          # shell website publik
└── admin/
    ├── login.blade.php        # halaman login
    ├── dashboard.blade.php
    ├── materials/
    │   ├── index.blade.php
    │   └── form.blade.php     # dipakai create & edit
    ├── products/
    │   ├── index.blade.php
    │   └── form.blade.php     # dipakai create & edit
    ├── profiles/
    │   └── index.blade.php
    └── settings/
        └── edit.blade.php
```

---

## 7. Menu Sidebar

Didefinisikan di `resources/views/layouts/admin.blade.php` (array `$adminNav`):

1. Dashboard — `admin.dashboard`
2. Katalog Produk — `admin.products.index`
3. Material & Harga — `admin.materials.index`
4. Tabel Profil Baja — `admin.profiles.index`
5. Pengaturan — `admin.settings.edit`

Link bantuan di bagian bawah sidebar: **Lihat Website** (`route('home')`, tab baru)
dan **Keluar** (`POST admin.logout`).

---

## 8. Catatan Keamanan

- [ ] File ini berisi kredensial plaintext. **Jangan commit ke repo publik.**
      Tambahkan `/adminakses.md` ke `.gitignore` bila repo akan dipublikasikan,
      atau ganti nilai password dengan placeholder.
- [ ] Ganti password default `password` di lingkungan produksi
      (`APP_ADMIN_PASSWORD` di `.env`), lalu `php artisan db:seed --class=AdminUserSeeder`.
- [ ] Pastikan `APP_DEBUG=false` di produksi.
- [ ] Backup `database/database.sqlite` mengandung hash password — jangan dibagikan.

---

## 9. Verifikasi Cepat

```powershell
php artisan serve            # jalankan server dev
# buka http://127.0.0.1:8000/admin/login
# login: admin@udbekasindo.id / password

php artisan test --filter=Admin   # tes fitur admin (AdminAuthTest, AdminCrudTest)
```
