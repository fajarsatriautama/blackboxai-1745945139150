# Panduan Troubleshooting Rapor Tahfizh

## 1. Error "Your system folder path does not appear to be set correctly"

Masalah ini muncul karena folder `system` CodeIgniter belum lengkap. Untuk memperbaiki:

1. Download CodeIgniter 3.1.11 dari https://codeigniter.com/download
2. Extract file zip CodeIgniter yang baru didownload
3. Copy SELURUH isi folder `system` dari CodeIgniter ke folder `system` di aplikasi
4. Struktur folder yang benar:
   ```
   system/
   ├── core/
   ├── database/
   ├── fonts/
   ├── helpers/
   ├── language/
   ├── libraries/
   └── [file-file lainnya]
   ```
5. Pastikan semua file CodeIgniter tercopy, bukan hanya placeholder

## 2. Langkah Instalasi Detail

1. **Persiapan File:**
   ```bash
   # 1. Extract aplikasi
   unzip rapor_tahfizh.zip
   
   # 2. Download & extract CodeIgniter
   wget https://github.com/bcit-ci/CodeIgniter/archive/3.1.11.zip
   unzip 3.1.11.zip
   
   # 3. Copy folder system
   cp -r CodeIgniter-3.1.11/system/* system/
   ```

2. **Setting Permission:**
   ```bash
   chmod 755 application/
   chmod 755 system/
   chmod 755 assets/uploads/ -R
   ```

3. **Database:**
   ```sql
   CREATE DATABASE db_rapor_tahfizh;
   USE db_rapor_tahfizh;
   SOURCE db_rapor_tahfizh.sql;
   ```

4. **Konfigurasi:**
   - Edit `application/config/database.php`
   - Edit `application/config/config.php`
   - Set base_url sesuai domain

## 3. Checklist Instalasi

- [ ] Folder `system` berisi semua file CodeIgniter
- [ ] Database sudah dibuat dan diimport
- [ ] Konfigurasi database sudah sesuai
- [ ] Base URL sudah disesuaikan
- [ ] Permission folder sudah diset
- [ ] .htaccess ada di root folder
- [ ] mod_rewrite Apache sudah aktif

## 4. Pesan Error Umum

1. **Database Error:**
   - Periksa username/password database
   - Periksa nama database
   - Pastikan MySQL berjalan

2. **404 Not Found:**
   - Periksa .htaccess
   - Periksa base_url
   - Aktifkan mod_rewrite

3. **Upload Error:**
   - Periksa permission folder uploads
   - Periksa ukuran file
   - Periksa php.ini untuk upload_max_filesize

## 5. Kontak Support

Jika masih mengalami masalah:
1. Screenshot pesan error
2. Catat langkah yang sudah dilakukan
3. Periksa log error di application/logs
4. Kirim detail ke support

## 6. Keamanan

Setelah instalasi berhasil:
1. Hapus atau rename file:
   - install.php
   - TROUBLESHOOTING.md
2. Ubah password admin default
3. Backup database
4. Aktifkan HTTPS jika tersedia
