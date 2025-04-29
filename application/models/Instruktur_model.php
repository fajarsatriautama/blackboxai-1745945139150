<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Instruktur_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }

    public function get_id_by_user($user_id) {
        $instruktur = $this->db->get_where('instruktur', ['id_pengguna' => $user_id])->row_array();
        return $instruktur ? $instruktur['id'] : null;
    }

    public function get_profile($user_id) {
        $this->db->select('pengguna.*, instruktur.nip');
        $this->db->from('pengguna');
        $this->db->join('instruktur', 'instruktur.id_pengguna = pengguna.id');
        $this->db->where('pengguna.id', $user_id);
        return $this->db->get()->row_array();
    }

    public function update_profile($user_id, $data) {
        $this->db->where('id', $user_id);
        return $this->db->update('pengguna', $data);
    }

    public function count_all() {
        return $this->db->count_all('instruktur');
    }

    public function get_all() {
        $this->db->select('instruktur.*, pengguna.nama_lengkap, pengguna.foto_profil');
        $this->db->from('instruktur');
        $this->db->join('pengguna', 'pengguna.id = instruktur.id_pengguna');
        return $this->db->get()->result_array();
    }

    public function get_by_id($id) {
        $this->db->select('instruktur.*, pengguna.nama_lengkap, pengguna.foto_profil');
        $this->db->from('instruktur');
        $this->db->join('pengguna', 'pengguna.id = instruktur.id_pengguna');
        $this->db->where('instruktur.id', $id);
        return $this->db->get()->row_array();
    }

    // Penilaian Functions
    public function add_penilaian($data) {
        return $this->db->insert('penilaian', $data);
    }

    public function get_penilaian_by_instruktur($id_instruktur, $limit = null) {
        $this->db->select('penilaian.*, siswa.nama_siswa, surat.nama_surat_latin, kelas.nama_kelas');
        $this->db->from('penilaian');
        $this->db->join('siswa', 'siswa.id = penilaian.id_siswa');
        $this->db->join('surat', 'surat.id = penilaian.id_surat');
        $this->db->join('kelas', 'kelas.id = siswa.id_kelas');
        $this->db->where('penilaian.id_instruktur', $id_instruktur);
        $this->db->order_by('penilaian.tanggal_penilaian', 'DESC');
        if($limit) {
            $this->db->limit($limit);
        }
        return $this->db->get()->result_array();
    }

    // Pencapaian Functions
    public function add_pencapaian($data) {
        return $this->db->insert('pencapaian_surat', $data);
    }

    public function get_pencapaian_by_instruktur($id_instruktur, $limit = null) {
        $this->db->select('pencapaian_surat.*, siswa.nama_siswa, surat.nama_surat_latin, kelas.nama_kelas');
        $this->db->from('pencapaian_surat');
        $this->db->join('siswa', 'siswa.id = pencapaian_surat.id_siswa');
        $this->db->join('surat', 'surat.id = pencapaian_surat.id_surat');
        $this->db->join('kelas', 'kelas.id = siswa.id_kelas');
        $this->db->where('pencapaian_surat.id_instruktur', $id_instruktur);
        $this->db->order_by('pencapaian_surat.tanggal_setor', 'DESC');
        if($limit) {
            $this->db->limit($limit);
        }
        return $this->db->get()->result_array();
    }

    // Report Generation
    public function get_report_data($id_instruktur, $start_date = null, $end_date = null, $id_kelas = null) {
        $this->db->select('
            penilaian.*,
            siswa.nama_siswa,
            siswa.nisn,
            kelas.nama_kelas,
            surat.nama_surat_latin,
            surat.nama_surat_arab
        ');
        $this->db->from('penilaian');
        $this->db->join('siswa', 'siswa.id = penilaian.id_siswa');
        $this->db->join('kelas', 'kelas.id = siswa.id_kelas');
        $this->db->join('surat', 'surat.id = penilaian.id_surat');
        $this->db->where('penilaian.id_instruktur', $id_instruktur);
        
        if($start_date && $end_date) {
            $this->db->where('penilaian.tanggal_penilaian >=', $start_date);
            $this->db->where('penilaian.tanggal_penilaian <=', $end_date);
        }
        
        if($id_kelas) {
            $this->db->where('siswa.id_kelas', $id_kelas);
        }
        
        $this->db->order_by('penilaian.tanggal_penilaian', 'DESC');
        return $this->db->get()->result_array();
    }

    // Statistics
    public function get_statistics($id_instruktur) {
        $stats = [];
        
        // Total penilaian
        $this->db->where('id_instruktur', $id_instruktur);
        $stats['total_penilaian'] = $this->db->count_all_results('penilaian');
        
        // Total pencapaian
        $this->db->where('id_instruktur', $id_instruktur);
        $stats['total_pencapaian'] = $this->db->count_all_results('pencapaian_surat');
        
        // Average scores
        $this->db->select_avg('nilai_fashohah', 'avg_fashohah');
        $this->db->select_avg('nilai_tajwid', 'avg_tajwid');
        $this->db->select_avg('nilai_kelancaran', 'avg_kelancaran');
        $this->db->where('id_instruktur', $id_instruktur);
        $stats['average_scores'] = $this->db->get('penilaian')->row_array();
        
        // Penilaian per month
        $this->db->select('MONTH(tanggal_penilaian) as bulan, COUNT(*) as total');
        $this->db->where('id_instruktur', $id_instruktur);
        $this->db->where('YEAR(tanggal_penilaian)', date('Y'));
        $this->db->group_by('MONTH(tanggal_penilaian)');
        $stats['penilaian_per_month'] = $this->db->get('penilaian')->result_array();
        
        return $stats;
    }
}
