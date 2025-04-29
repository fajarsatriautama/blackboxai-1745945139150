<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }

    public function get_id_by_user($user_id) {
        $siswa = $this->db->get_where('siswa', ['id_pengguna' => $user_id])->row_array();
        return $siswa ? $siswa['id'] : null;
    }

    public function get_profile($user_id) {
        $this->db->select('pengguna.*, siswa.nisn, siswa.nama_siswa, kelas.nama_kelas');
        $this->db->from('pengguna');
        $this->db->join('siswa', 'siswa.id_pengguna = pengguna.id');
        $this->db->join('kelas', 'kelas.id = siswa.id_kelas');
        $this->db->where('pengguna.id', $user_id);
        return $this->db->get()->row_array();
    }

    public function update_profile($user_id, $data) {
        $this->db->where('id', $user_id);
        return $this->db->update('pengguna', $data);
    }

    public function count_all() {
        return $this->db->count_all('siswa');
    }

    public function get_all_with_class() {
        $this->db->select('siswa.*, pengguna.nama_lengkap, pengguna.foto_profil, kelas.nama_kelas');
        $this->db->from('siswa');
        $this->db->join('pengguna', 'pengguna.id = siswa.id_pengguna');
        $this->db->join('kelas', 'kelas.id = siswa.id_kelas');
        return $this->db->get()->result_array();
    }

    public function get_by_id($id) {
        $this->db->select('siswa.*, pengguna.nama_lengkap, pengguna.foto_profil, kelas.nama_kelas');
        $this->db->from('siswa');
        $this->db->join('pengguna', 'pengguna.id = siswa.id_pengguna');
        $this->db->join('kelas', 'kelas.id = siswa.id_kelas');
        $this->db->where('siswa.id', $id);
        return $this->db->get()->row_array();
    }

    public function get_pencapaian($id_siswa) {
        $this->db->select('pencapaian_surat.*, surat.nama_surat_latin, surat.nama_surat_arab');
        $this->db->from('pencapaian_surat');
        $this->db->join('surat', 'surat.id = pencapaian_surat.id_surat');
        $this->db->where('pencapaian_surat.id_siswa', $id_siswa);
        return $this->db->get()->result_array();
    }

    public function get_statistics($id_siswa) {
        $stats = [];
        
        // Total pencapaian
        $this->db->where('id_siswa', $id_siswa);
        $stats['total_pencapaian'] = $this->db->count_all_results('pencapaian_surat');
        
        // Total penilaian
        $this->db->where('id_siswa', $id_siswa);
        $stats['total_penilaian'] = $this->db->count_all_results('penilaian');
        
        return $stats;
    }
}
