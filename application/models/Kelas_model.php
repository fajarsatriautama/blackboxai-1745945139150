<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }

    public function get_all() {
        $this->db->order_by('nama_kelas', 'ASC');
        return $this->db->get('kelas')->result_array();
    }

    public function get_by_id($id) {
        return $this->db->get_where('kelas', ['id' => $id])->row_array();
    }

    public function count_all() {
        return $this->db->count_all('kelas');
    }

    public function get_students($id_kelas) {
        $this->db->select('siswa.*, pengguna.nama_lengkap, pengguna.foto_profil');
        $this->db->from('siswa');
        $this->db->join('pengguna', 'pengguna.id = siswa.id_pengguna');
        $this->db->where('siswa.id_kelas', $id_kelas);
        $this->db->order_by('siswa.nama_siswa', 'ASC');
        return $this->db->get()->result_array();
    }

    public function count_students($id_kelas) {
        $this->db->where('id_kelas', $id_kelas);
        return $this->db->count_all_results('siswa');
    }

    public function add($data) {
        return $this->db->insert('kelas', $data);
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('kelas', $data);
    }

    public function delete($id) {
        // Check if class has students
        if($this->count_students($id) > 0) {
            return false;
        }
        return $this->db->delete('kelas', ['id' => $id]);
    }

    public function get_class_statistics($id_kelas) {
        $stats = [];
        
        // Total students
        $stats['total_siswa'] = $this->count_students($id_kelas);
        
        // Average scores
        $this->db->select('
            AVG(nilai_fashohah) as avg_fashohah,
            AVG(nilai_tajwid) as avg_tajwid,
            AVG(nilai_kelancaran) as avg_kelancaran,
            (AVG(nilai_fashohah) + AVG(nilai_tajwid) + AVG(nilai_kelancaran))/3 as avg_total
        ');
        $this->db->from('penilaian');
        $this->db->join('siswa', 'siswa.id = penilaian.id_siswa');
        $this->db->where('siswa.id_kelas', $id_kelas);
        $stats['nilai_rata_rata'] = $this->db->get()->row_array();
        
        // Total evaluations
        $this->db->select('COUNT(*) as total');
        $this->db->from('penilaian');
        $this->db->join('siswa', 'siswa.id = penilaian.id_siswa');
        $this->db->where('siswa.id_kelas', $id_kelas);
        $stats['total_penilaian'] = $this->db->get()->row()->total;
        
        // Total achievements
        $this->db->select('COUNT(*) as total');
        $this->db->from('pencapaian_surat');
        $this->db->join('siswa', 'siswa.id = pencapaian_surat.id_siswa');
        $this->db->where('siswa.id_kelas', $id_kelas);
        $stats['total_pencapaian'] = $this->db->get()->row()->total;
        
        return $stats;
    }

    public function initialize_classes() {
        // Data for 21 classes (7A-7G, 8A-8G, 9A-9G)
        $classes = [];
        $grades = ['7', '8', '9'];
        $sections = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
        
        foreach ($grades as $grade) {
            foreach ($sections as $section) {
                $classes[] = [
                    'nama_kelas' => 'Kelas ' . $grade . $section,
                    'tahun_ajaran' => '2023/2024',
                    'kapasitas' => 32,
                    'dibuat_pada' => date('Y-m-d H:i:s')
                ];
            }
        }

        // Insert all classes
        foreach ($classes as $class) {
            $this->db->insert('kelas', $class);
        }
    }

    public function get_class_report($id_kelas, $start_date = null, $end_date = null) {
        $this->db->select('
            siswa.nama_siswa,
            siswa.nisn,
            COUNT(DISTINCT pencapaian_surat.id_surat) as total_surat,
            COUNT(DISTINCT penilaian.id) as total_penilaian,
            AVG(penilaian.nilai_fashohah) as avg_fashohah,
            AVG(penilaian.nilai_tajwid) as avg_tajwid,
            AVG(penilaian.nilai_kelancaran) as avg_kelancaran,
            (AVG(penilaian.nilai_fashohah) + AVG(penilaian.nilai_tajwid) + AVG(penilaian.nilai_kelancaran))/3 as avg_total
        ');
        $this->db->from('siswa');
        $this->db->join('pencapaian_surat', 'pencapaian_surat.id_siswa = siswa.id', 'left');
        $this->db->join('penilaian', 'penilaian.id_siswa = siswa.id', 'left');
        $this->db->where('siswa.id_kelas', $id_kelas);
        
        if($start_date && $end_date) {
            $this->db->where('penilaian.tanggal_penilaian >=', $start_date);
            $this->db->where('penilaian.tanggal_penilaian <=', $end_date);
        }
        
        $this->db->group_by('siswa.id');
        $this->db->order_by('siswa.nama_siswa', 'ASC');
        return $this->db->get()->result_array();
    }
}
