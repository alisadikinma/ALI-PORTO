# Dynamic Section Management

System ini memungkinkan Anda untuk mengaktifkan/menonaktifkan section-section di homepage secara dinamis melalui dashboard admin.

## Fitur Baru

### Section yang Dapat Dikelola:
- ✅ **About Section** - Bagian tentang/profil
- ✅ **Services Section** - Daftar layanan
- ✅ **Portfolio Section** - Portfolio/proyek
- ✅ **Testimonials Section** - Testimoni klien
- ✅ **Gallery Section** - Galeri foto/video
- ✅ **Articles Section** - Artikel/blog
- ✅ **Awards Section** - Penghargaan
- ✅ **Contact Section** - Formulir kontak

## Cara Menggunakan

### 1. Akses Section Management
1. Login ke dashboard admin
2. Masuk ke menu **Settings**
3. Klik tombol **"Manage Sections"**
4. Anda akan diarahkan ke halaman Section Visibility Management

### 2. Mengatur Visibility Section
1. **Toggle Switch**: Gunakan toggle switch untuk mengaktifkan/menonaktifkan section
   - ✅ **Hijau/Checked** = Section akan ditampilkan
   - ❌ **Abu-abu/Unchecked** = Section disembunyikan

2. **Save Changes**: Klik tombol "Save Section Settings" untuk menyimpan perubahan

### 3. Automatic Conditional Display
System akan otomatis:
- Mengecek apakah section diaktifkan di setting
- Mengecek apakah ada data untuk section tersebut
- Hanya menampilkan section jika kedua kondisi terpenuhi

## Contoh Penggunaan

### Case 1: Website Baru
Jika Anda baru memulai website dan belum memiliki:
- Portfolio → Nonaktifkan Portfolio Section
- Testimonials → Nonaktifkan Testimonials Section  
- Gallery → Nonaktifkan Gallery Section

### Case 2: Maintenance Mode
Jika ada section yang sedang dalam perbaikan:
- Nonaktifkan section tersebut sementara
- Pengunjung tidak akan melihat section yang kosong

### Case 3: Custom Layout
Sesuaikan layout homepage dengan kebutuhan:
- Aktifkan hanya section yang relevan untuk bisnis Anda
- Ubah urutan dengan mengaktifkan/menonaktifkan section tertentu

## Technical Details

### Database Changes
Menambahkan kolom baru di tabel `setting`:
```sql
- about_section_active (boolean, default: true)
- services_section_active (boolean, default: true)  
- portfolio_section_active (boolean, default: true)
- testimonials_section_active (boolean, default: true)
- gallery_section_active (boolean, default: true)
- articles_section_active (boolean, default: true)
- awards_section_active (boolean, default: true)
- contact_section_active (boolean, default: true)
```

### Blade Template Logic
```php
@if($konf->section_name_active && $data->count() > 0)
    <!-- Section Content -->
@endif
```

### Routes Added
```php
Route::get('/setting/sections/manage', [SettingController::class, 'sections'])
    ->name('setting.sections');

Route::put('/setting/sections/update', [SettingController::class, 'updateSections'])
    ->name('setting.sections.update');
```

## Benefits

1. **Better UX**: Tidak ada section kosong yang ditampilkan
2. **Flexible Layout**: Sesuaikan homepage sesuai kebutuhan
3. **Easy Management**: Interface yang user-friendly
4. **Performance**: Mengurangi render section yang tidak diperlukan
5. **SEO Friendly**: Homepage lebih clean dan fokus

## Migration Guide

Untuk mengaktifkan fitur ini:

```bash
# Run migration
php artisan migrate --path=database/migrations/2024_12_21_000001_add_section_visibility_to_setting_table.php

# Clear cache
php artisan cache:clear
```

Atau gunakan script otomatis:
```bash
./run_section_migration.sh
```

## Default Settings

Semua section akan **aktif secara default** setelah migration. Anda dapat mengatur sesuai kebutuhan melalui dashboard.

## Support

Jika ada pertanyaan atau issue, silakan:
1. Cek dokumentasi ini terlebih dahulu
2. Test di local environment
3. Clear cache Laravel jika ada masalah

---

**Happy Managing! 🚀**
