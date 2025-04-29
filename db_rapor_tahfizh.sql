-- Create database
CREATE DATABASE IF NOT EXISTS `db_rapor_tahfizh`;
USE `db_rapor_tahfizh`;

-- Kelas table
CREATE TABLE `kelas` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `nama_kelas` VARCHAR(50) NOT NULL,
    `tahun_ajaran` VARCHAR(20) NOT NULL,
    `kapasitas` INT DEFAULT 32,
    `dibuat_pada` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `diperbarui_pada` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Pengguna table
CREATE TABLE `pengguna` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `peran` ENUM('admin', 'instruktur', 'siswa') DEFAULT 'siswa',
    `nama_lengkap` VARCHAR(100) NOT NULL,
    `foto_profil` VARCHAR(255) DEFAULT NULL,
    `dibuat_pada` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `diperbarui_pada` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Siswa table
CREATE TABLE `siswa` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `id_pengguna` INT UNSIGNED NOT NULL,
    `id_kelas` INT UNSIGNED NOT NULL,
    `nisn` VARCHAR(20) NOT NULL UNIQUE,
    `nama_siswa` VARCHAR(100) NOT NULL,
    `jenis_kelamin` ENUM('L', 'P') NOT NULL,
    `dibuat_pada` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `diperbarui_pada` TIMESTAMP NULL,
    FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`id_kelas`) REFERENCES `kelas`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Instruktur table
CREATE TABLE `instruktur` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `id_pengguna` INT UNSIGNED NOT NULL,
    `nip` VARCHAR(20) NULL,
    `nama_instruktur` VARCHAR(100) NOT NULL,
    `dibuat_pada` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `diperbarui_pada` TIMESTAMP NULL,
    FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Surat table
CREATE TABLE `surat` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `nomor_surat` INT NOT NULL,
    `nama_surat_arab` VARCHAR(100) NOT NULL,
    `nama_surat_latin` VARCHAR(100) NOT NULL,
    `jumlah_ayat` INT NOT NULL,
    `jenis_turun` ENUM('Makkiyah', 'Madaniyah') NOT NULL,
    `dibuat_pada` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Penilaian table (updated with CAT score)
CREATE TABLE `penilaian` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `id_siswa` INT UNSIGNED NOT NULL,
    `id_surat` INT UNSIGNED NOT NULL,
    `id_instruktur` INT UNSIGNED NOT NULL,
    `nilai_fashohah` DECIMAL(5,2) NOT NULL,
    `nilai_tajwid` DECIMAL(5,2) NOT NULL,
    `nilai_kelancaran` DECIMAL(5,2) NOT NULL,
    `nilai_cat` DECIMAL(5,2) NOT NULL DEFAULT 0,
    `predikat` VARCHAR(10) DEFAULT NULL,
    `catatan` TEXT DEFAULT NULL,
    `tanggal_penilaian` DATE NOT NULL,
    `dibuat_pada` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`id_siswa`) REFERENCES `siswa`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`id_surat`) REFERENCES `surat`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`id_instruktur`) REFERENCES `instruktur`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Pencapaian Surat table
CREATE TABLE `pencapaian_surat` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `id_siswa` INT UNSIGNED NOT NULL,
    `id_surat` INT UNSIGNED NOT NULL,
    `ayat_mulai` INT NOT NULL,
    `ayat_selesai` INT NOT NULL,
    `id_instruktur` INT UNSIGNED NOT NULL,
    `tanggal_setor` DATE NOT NULL,
    `dibuat_pada` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`id_siswa`) REFERENCES `siswa`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`id_surat`) REFERENCES `surat`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`id_instruktur`) REFERENCES `instruktur`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Settings table (updated with letterhead)
CREATE TABLE `pengaturan` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `site_title` VARCHAR(100) NOT NULL DEFAULT 'Rapor Tahfizh',
    `site_description` TEXT,
    `logo` VARCHAR(255),
    `favicon` VARCHAR(255),
    `kop_surat` VARCHAR(255),
    `nama_madrasah` VARCHAR(100),
    `alamat_madrasah` TEXT,
    `kepala_madrasah` VARCHAR(100),
    `nip_kepala_madrasah` VARCHAR(50),
    `ttd_kepala_madrasah` VARCHAR(255),
    `stempel_madrasah` VARCHAR(255),
    `dibuat_pada` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `diperbarui_pada` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Slider table
CREATE TABLE `slider` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `judul` VARCHAR(255) NOT NULL,
    `deskripsi` TEXT,
    `gambar` VARCHAR(255) NOT NULL,
    `urutan` INT NOT NULL DEFAULT 0,
    `status` ENUM('aktif', 'nonaktif') DEFAULT 'aktif',
    `dibuat_pada` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `diperbarui_pada` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Article table
CREATE TABLE `artikel` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `judul` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL UNIQUE,
    `konten` TEXT NOT NULL,
    `gambar` VARCHAR(255),
    `id_pengguna` INT UNSIGNED NOT NULL,
    `status` ENUM('published', 'draft') DEFAULT 'draft',
    `tanggal` TIMESTAMP NOT NULL,
    `dibuat_pada` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `diperbarui_pada` TIMESTAMP NULL,
    FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert default admin user
INSERT INTO `pengguna` (`username`, `password`, `peran`, `nama_lengkap`, `dibuat_pada`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'Administrator', NOW());

-- Insert initial classes
INSERT INTO `kelas` (`nama_kelas`, `tahun_ajaran`, `kapasitas`) VALUES
('Kelas 7A', '2023/2024', 32),
('Kelas 7B', '2023/2024', 32),
('Kelas 7C', '2023/2024', 32),
('Kelas 7D', '2023/2024', 32),
('Kelas 7E', '2023/2024', 32),
('Kelas 7F', '2023/2024', 32),
('Kelas 7G', '2023/2024', 32),
('Kelas 8A', '2023/2024', 32),
('Kelas 8B', '2023/2024', 32),
('Kelas 8C', '2023/2024', 32),
('Kelas 8D', '2023/2024', 32),
('Kelas 8E', '2023/2024', 32),
('Kelas 8F', '2023/2024', 32),
('Kelas 8G', '2023/2024', 32),
('Kelas 9A', '2023/2024', 32),
('Kelas 9B', '2023/2024', 32),
('Kelas 9C', '2023/2024', 32),
('Kelas 9D', '2023/2024', 32),
('Kelas 9E', '2023/2024', 32),
('Kelas 9F', '2023/2024', 32),
('Kelas 9G', '2023/2024', 32);

-- Insert first 10 surahs (as example)
INSERT INTO `surat` (`nomor_surat`, `nama_surat_arab`, `nama_surat_latin`, `jumlah_ayat`, `jenis_turun`) VALUES
(1, 'الفاتحة', 'Al-Fatihah', 7, 'Makkiyah'),
(2, 'البقرة', 'Al-Baqarah', 286, 'Madaniyah'),
(3, 'آل عمران', 'Ali Imran', 200, 'Madaniyah'),
(4, 'النساء', 'An-Nisa', 176, 'Madaniyah'),
(5, 'المائدة', 'Al-Maidah', 120, 'Madaniyah'),
(6, 'الأنعام', 'Al-Anam', 165, 'Makkiyah'),
(7, 'الأعراف', 'Al-Araf', 206, 'Makkiyah'),
(8, 'الأنفال', 'Al-Anfal', 75, 'Madaniyah'),
(9, 'التوبة', 'At-Taubah', 129, 'Madaniyah'),
(10, 'يونس', 'Yunus', 109, 'Makkiyah');
