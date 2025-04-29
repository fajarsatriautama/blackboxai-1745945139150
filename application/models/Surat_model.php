<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }

    public function get_all() {
        $this->db->order_by('nomor_surat', 'ASC');
        return $this->db->get('surat')->result_array();
    }

    public function get_by_id($id) {
        return $this->db->get_where('surat', ['id' => $id])->row_array();
    }

    public function get_by_number($nomor) {
        return $this->db->get_where('surat', ['nomor_surat' => $nomor])->row_array();
    }

    public function initialize_surahs() {
        // Data 114 surat Al-Quran
        $surahs = [
            ['nomor_surat' => 1, 'nama_surat_arab' => 'الفاتحة', 'nama_surat_latin' => 'Al-Fatihah', 'jumlah_ayat' => 7, 'jenis_turun' => 'Makkiyah'],
            ['nomor_surat' => 2, 'nama_surat_arab' => 'البقرة', 'nama_surat_latin' => 'Al-Baqarah', 'jumlah_ayat' => 286, 'jenis_turun' => 'Madaniyah'],
            ['nomor_surat' => 3, 'nama_surat_arab' => 'آل عمران', 'nama_surat_latin' => 'Ali Imran', 'jumlah_ayat' => 200, 'jenis_turun' => 'Madaniyah'],
            ['nomor_surat' => 4, 'nama_surat_arab' => 'النساء', 'nama_surat_latin' => 'An-Nisa', 'jumlah_ayat' => 176, 'jenis_turun' => 'Madaniyah'],
            ['nomor_surat' => 5, 'nama_surat_arab' => 'المائدة', 'nama_surat_latin' => 'Al-Maidah', 'jumlah_ayat' => 120, 'jenis_turun' => 'Madaniyah'],
            ['nomor_surat' => 6, 'nama_surat_arab' => 'الأنعام', 'nama_surat_latin' => 'Al-Anam', 'jumlah_ayat' => 165, 'jenis_turun' => 'Makkiyah'],
            ['nomor_surat' => 7, 'nama_surat_arab' => 'الأعراف', 'nama_surat_latin' => 'Al-Araf', 'jumlah_ayat' => 206, 'jenis_turun' => 'Makkiyah'],
            ['nomor_surat' => 8, 'nama_surat_arab' => 'الأنفال', 'nama_surat_latin' => 'Al-Anfal', 'jumlah_ayat' => 75, 'jenis_turun' => 'Madaniyah'],
            ['nomor_surat' => 9, 'nama_surat_arab' => 'التوبة', 'nama_surat_latin' => 'At-Taubah', 'jumlah_ayat' => 129, 'jenis_turun' => 'Madaniyah'],
            ['nomor_surat' => 10, 'nama_surat_arab' => 'يونس', 'nama_surat_latin' => 'Yunus', 'jumlah_ayat' => 109, 'jenis_turun' => 'Makkiyah'],
            // ... Add remaining surahs
        ];

        // Insert all surahs
        foreach ($surahs as $surah) {
            $this->db->insert('surat', $surah);
        }
    }

    public function get_student_progress($id_siswa) {
        $this->db->select('
            surat.*,
            pencapaian_surat.ayat_mulai,
            pencapaian_surat.ayat_selesai,
            pencapaian_surat.tanggal_setor,
            penilaian.nilai_fashohah,
            penilaian.nilai_tajwid,
            penilaian.nilai_kelancaran
        ');
        $this->db->from('surat');
        $this->db->join('pencapaian_surat', 'pencapaian_surat.id_surat = surat.id AND pencapaian_surat.id_siswa = '.$id_siswa, 'left');
        $this->db->join('penilaian', 'penilaian.id_surat = surat.id AND penilaian.id_siswa = '.$id_siswa, 'left');
        $this->db->order_by('surat.nomor_surat', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_class_progress($id_kelas) {
        $this->db->select('
            siswa.nama_siswa,
            COUNT(DISTINCT pencapaian_surat.id_surat) as total_surat,
            COUNT(DISTINCT penilaian.id) as total_penilaian
        ');
        $this->db->from('siswa');
        $this->db->join('pencapaian_surat', 'pencapaian_surat.id_siswa = siswa.id', 'left');
        $this->db->join('penilaian', 'penilaian.id_siswa = siswa.id', 'left');
        $this->db->where('siswa.id_kelas', $id_kelas);
        $this->db->group_by('siswa.id');
        return $this->db->get()->result_array();
    }

    public function get_surah_statistics() {
        $this->db->select('
            surat.*,
            COUNT(DISTINCT pencapaian_surat.id_siswa) as total_siswa,
            AVG(penilaian.nilai_fashohah) as avg_fashohah,
            AVG(penilaian.nilai_tajwid) as avg_tajwid,
            AVG(penilaian.nilai_kelancaran) as avg_kelancaran
        ');
        $this->db->from('surat');
        $this->db->join('pencapaian_surat', 'pencapaian_surat.id_surat = surat.id', 'left');
        $this->db->join('penilaian', 'penilaian.id_surat = surat.id', 'left');
        $this->db->group_by('surat.id');
        $this->db->order_by('surat.nomor_surat', 'ASC');
        return $this->db->get()->result_array();
    }
}
