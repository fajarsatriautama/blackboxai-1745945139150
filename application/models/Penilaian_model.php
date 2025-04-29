<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penilaian_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }

    public function add($data) {
        return $this->db->insert('penilaian', $data);
    }

    public function get_by_id($id) {
        $this->db->select('penilaian.*, siswa.nama_siswa, surat.nama_surat_latin, surat.nama_surat_arab, instruktur.nama_instruktur');
        $this->db->from('penilaian');
        $this->db->join('siswa', 'siswa.id = penilaian.id_siswa');
        $this->db->join('surat', 'surat.id = penilaian.id_surat');
        $this->db->join('instruktur', 'instruktur.id = penilaian.id_instruktur');
        $this->db->where('penilaian.id', $id);
        return $this->db->get()->row_array();
    }

    public function get_by_siswa($id_siswa, $limit = null) {
        $this->db->select('penilaian.*, surat.nama_surat_latin, surat.nama_surat_arab, instruktur.nama_instruktur');
        $this->db->from('penilaian');
        $this->db->join('surat', 'surat.id = penilaian.id_surat');
        $this->db->join('instruktur', 'instruktur.id = penilaian.id_instruktur');
        $this->db->where('penilaian.id_siswa', $id_siswa);
        $this->db->order_by('penilaian.tanggal_penilaian', 'DESC');
        if($limit) {
            $this->db->limit($limit);
        }
        return $this->db->get()->result_array();
    }

    public function get_by_instruktur($id_instruktur, $limit = null) {
        $this->db->select('penilaian.*, siswa.nama_siswa, surat.nama_surat_latin, surat.nama_surat_arab');
        $this->db->from('penilaian');
        $this->db->join('siswa', 'siswa.id = penilaian.id_siswa');
        $this->db->join('surat', 'surat.id = penilaian.id_surat');
        $this->db->where('penilaian.id_instruktur', $id_instruktur);
        $this->db->order_by('penilaian.tanggal_penilaian', 'DESC');
        if($limit) {
            $this->db->limit($limit);
        }
        return $this->db->get()->result_array();
    }

    public function get_by_kelas($id_kelas, $limit = null) {
        $this->db->select('penilaian.*, siswa.nama_siswa, surat.nama_surat_latin, surat.nama_surat_arab, instruktur.nama_instruktur');
        $this->db->from('penilaian');
        $this->db->join('siswa', 'siswa.id = penilaian.id_siswa');
        $this->db->join('surat', 'surat.id = penilaian.id_surat');
        $this->db->join('instruktur', 'instruktur.id = penilaian.id_instruktur');
        $this->db->where('siswa.id_kelas', $id_kelas);
        $this->db->order_by('penilaian.tanggal_penilaian', 'DESC');
        if($limit) {
            $this->db->limit($limit);
        }
        return $this->db->get()->result_array();
    }

    public function get_averages($id_siswa) {
        $this->db->select('
            AVG(nilai_fashohah) as avg_fashohah,
            AVG(nilai_tajwid) as avg_tajwid,
            AVG(nilai_kelancaran) as avg_kelancaran,
            (AVG(nilai_fashohah) + AVG(nilai_tajwid) + AVG(nilai_kelancaran))/3 as avg_total
        ');
        $this->db->from('penilaian');
        $this->db->where('id_siswa', $id_siswa);
        return $this->db->get()->row_array();
    }

    public function get_class_averages($id_kelas) {
        $this->db->select('
            siswa.id,
            siswa.nama_siswa,
            AVG(nilai_fashohah) as avg_fashohah,
            AVG(nilai_tajwid) as avg_tajwid,
            AVG(nilai_kelancaran) as avg_kelancaran,
            (AVG(nilai_fashohah) + AVG(nilai_tajwid) + AVG(nilai_kelancaran))/3 as avg_total
        ');
        $this->db->from('penilaian');
        $this->db->join('siswa', 'siswa.id = penilaian.id_siswa');
        $this->db->where('siswa.id_kelas', $id_kelas);
        $this->db->group_by('siswa.id');
        return $this->db->get()->result_array();
    }

    public function count_by_instruktur($id_instruktur) {
        $this->db->where('id_instruktur', $id_instruktur);
        return $this->db->count_all_results('penilaian');
    }

    public function get_recent_by_instruktur($id_instruktur, $limit) {
        return $this->get_by_instruktur($id_instruktur, $limit);
    }

    public function get_report_by_instruktur($id_instruktur, $start_date = null, $end_date = null, $id_kelas = null) {
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

    public function get_student_report($id_siswa, $start_date = null, $end_date = null) {
        $this->db->select('
            penilaian.*,
            surat.nama_surat_latin,
            surat.nama_surat_arab,
            instruktur.nama_instruktur
        ');
        $this->db->from('penilaian');
        $this->db->join('surat', 'surat.id = penilaian.id_surat');
        $this->db->join('instruktur', 'instruktur.id = penilaian.id_instruktur');
        $this->db->where('penilaian.id_siswa', $id_siswa);
        
        if($start_date && $end_date) {
            $this->db->where('penilaian.tanggal_penilaian >=', $start_date);
            $this->db->where('penilaian.tanggal_penilaian <=', $end_date);
        }
        
        $this->db->order_by('penilaian.tanggal_penilaian', 'DESC');
        return $this->db->get()->result_array();
    }
}
