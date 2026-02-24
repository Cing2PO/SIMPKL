# Dokumentasi View Login, Profil, dan Logout

## Ringkasan
Telah berhasil membuat sistem autentikasi lengkap untuk aplikasi SIMPKL dengan view untuk Login, Register, Profil, Ubah Profil, dan Ubah Kata Sandi.

## File yang Dibuat

### 1. **View Files** (`resources/views/auth/`)

#### a. login.blade.php
- **Fungsi**: Form login untuk pengguna
- **Fitur**:
  - Input email dan password
  - Validasi form dengan error messages
  - Link ke halaman register
  - Desain modern dengan Tailwind CSS
  - Responsive design

#### b. register.blade.php
- **Fungsi**: Form pendaftaran akun baru
- **Fitur**:
  - Input nama, email, password
  - Konfirmasi password
  - Validasi form dengan error messages
  - Link ke halaman login
  - Requirement password minimal 8 karakter dengan angka

#### c. profile.blade.php
- **Fungsi**: Menampilkan profil pengguna yang sudah login
- **Fitur**:
  - Informasi user (ID, nama, email, role, institusi)
  - Status akun (aktif, verifikasi email)
  - Tombol ubah profil dan ubah kata sandi
  - Tombol logout
  - Design dengan profile card yang menarik

#### d. editProfile.blade.php
- **Fungsi**: Form untuk mengubah data profil
- **Fitur**:
  - Edit nama dan email
  - Informasi institusi (read-only)
  - Validasi email unique
  - Success/error messages
  - Tombol simpan dan batal

#### e. changePassword.blade.php
- **Fungsi**: Form untuk mengubah kata sandi
- **Fitur**:
  - Verifikasi password saat ini
  - Input password baru dengan konfirmasi
  - Requirement password (min 8 karakter, angka, huruf)
  - Tips keamanan untuk pengguna
  - Success/error messages

### 2. **Controller Update** (`app/Http/Controllers/AuthController.php`)

**Method yang ditambahkan:**
- `registerForm()` - Tampilkan form register
- `register()` - Proses pendaftaran (validasi, hash password, auto-login)
- `profile()` - Tampilkan profil user
- `editProfile()` - Tampilkan form edit profil
- `updateProfile()` - Update data profil
- `changePassword()` - Tampilkan form ubah password
- `updatePassword()` - Update password dengan verifikasi password lama

**Validasi yang diimplementasikan:**
- Email validation (required, valid email format, unique untuk register)
- Password validation (required, min 8 chars, letters, numbers untuk register)
- Current password verification untuk change password
- Password confirmation

### 3. **Routes Update** (`routes/web.php`)

**Authentication Routes:**
```
GET  /login          -> auth.loginForm      (Show login form)
POST /login          -> auth.login          (Process login)
GET  /register       -> auth.registerForm   (Show register form)
POST /register       -> auth.register       (Process register)
POST /logout         -> auth.logout         (Process logout)

Protected Routes (middleware: auth):
GET  /profile        -> auth.profile        (Show profile)
GET  /profile/edit   -> auth.editProfile    (Show edit profile form)
PUT  /profile        -> auth.updateProfile  (Update profile)
GET  /password/change-> auth.changePassword (Show change password form)
PUT  /password       -> auth.updatePassword (Update password)
```

## Cara Penggunaan

### 1. **Login**
- Buka `/login`
- Masukkan email dan password
- Klik "Masuk"
- Jika berhasil, redirect ke `/dashboard`

### 2. **Register**
- Buka `/register`
- Isi form dengan nama, email, dan password
- Klik "Daftar"
- Jika berhasil, akan langsung login dan redirect ke `/dashboard`

### 3. **Profil**
- Login terlebih dahulu
- Buka `/profile` atau klik link profil di navbar
- Lihat informasi akun Anda

### 4. **Ubah Profil**
- Di halaman profil, klik tombol "Ubah Profil"
- Edit nama dan/atau email Anda
- Klik "Simpan Perubahan"

### 5. **Ubah Kata Sandi**
- Di halaman profil, klik tombol "Ubah Kata Sandi"
- Masukkan password saat ini
- Masukkan password baru dan konfirmasi
- Klik "Ubah Kata Sandi"

### 6. **Logout**
- Di navbar, klik tombol "Keluar"
- Akan di-redirect ke halaman utama

## Fitur Keamanan

✅ Password hashing menggunakan bcrypt
✅ Password disimpan dengan hashed
✅ Current password verification
✅ Session regeneration saat login
✅ Session invalidation saat logout
✅ CSRF protection (dilakukan otomatis oleh Laravel)
✅ Email unique validation
✅ Password confirmation validation
✅ Protected routes dengan middleware auth

## Styling

Semua view menggunakan:
- **Tailwind CSS** (via CDN)
- Responsive design (mobile-friendly)
- Konsisten dengan design system yang ada
- Error dan success messages dengan styling khusus

## Testing

Untuk melakukan test, Anda bisa:

1. **Register user baru:**
   - Buka http://localhost/SIMPKL/register
   - Isi form
   - Klik Daftar

2. **Login:**
   - Buka http://localhost/SIMPKL/login
   - Gunakan email dan password yang sudah didaftarkan
   - Klik Masuk

3. **Akses Profil:**
   - Setelah login, buka http://localhost/SIMPKL/profile

4. **Edit Profil:**
   - Di halaman profil, klik "Ubah Profil"
   - Edit data
   - Simpan

5. **Ubah Password:**
   - Di halaman profil, klik "Ubah Kata Sandi"
   - Masukkan password lama dan password baru
   - Simpan

6. **Logout:**
   - Klik tombol "Keluar" di navbar mana pun

## Database Migrations

Pastikan table users sudah ada dengan kolom:
- id (primary key)
- name
- email (unique)
- email_verified_at (nullable)
- password
- institution_id (foreign key, nullable)
- role (nullable)
- created_at
- updated_at

Jika belum ada, jalankan:
```bash
php artisan migrate
```

## Notes

- Sistem ini menggunakan Laravel's built-in authentication
- Password minimal 8 karakter dengan letter dan number
- Email harus unique untuk registration
- Protected routes memerlukan user untuk logged in
- Setelah logout, user akan di-redirect ke halaman utama

