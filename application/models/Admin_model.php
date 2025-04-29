<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }

    // User Management
    public function get_all_users() {
        return $this->db->get('pengguna')->result_array();
    }

    public function get_users_by_role($role) {
        return $this->db->get_where('pengguna', ['peran' => $role])->result_array();
    }

    public function get_user_by_id($id) {
        return $this->db->get_where('pengguna', ['id' => $id])->row_array();
    }

    public function add_user($data) {
        return $this->db->insert('pengguna', $data);
    }

    public function update_user($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('pengguna', $data);
    }

    public function delete_user($id) {
        // Check user role first
        $user = $this->get_user_by_id($id);
        if($user) {
            // Delete related data based on role
            switch($user['peran']) {
                case 'siswa':
                    $this->db->delete('siswa', ['id_pengguna' => $id]);
                    $this->db->delete('penilaian', ['id_siswa' => $id]);
                    $this->db->delete('pencapaian_surat', ['id_siswa' => $id]);
                    break;
                case 'instruktur':
                    $this->db->delete('instruktur', ['id_pengguna' => $id]);
                    break;
            }
            // Delete user
            return $this->db->delete('pengguna', ['id' => $id]);
        }
        return false;
    }

    // Recent Activities
    public function get_recent_penilaian($limit = 5) {
        $this->db->select('penilaian.*, siswa.nama_siswa, surat.nama_surat_latin, instruktur.nama_instruktur');
        $this->db->from('penilaian');
        $this->db->join('siswa', 'siswa.id = penilaian.id_siswa');
        $this->db->join('surat', 'surat.id = penilaian.id_surat');
        $this->db->join('instruktur', 'instruktur.id = penilaian.id_instruktur');
        $this->db->order_by('penilaian.tanggal_penilaian', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function get_recent_users($limit = 5) {
        $this->db->order_by('dibuat_pada', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('pengguna')->result_array();
    }

    // Statistics
    public function get_statistics() {
        $stats = [];
        
        // Total users by role
        $this->db->select('peran, COUNT(*) as total');
        $this->db->group_by('peran');
        $stats['users_by_role'] = $this->db->get('pengguna')->result_array();
        
        // Total evaluations this month
        $this->db->where('MONTH(tanggal_penilaian)', date('m'));
        $this->db->where('YEAR(tanggal_penilaian)', date('Y'));
        $stats['evaluations_this_month'] = $this->db->count_all_results('penilaian');
        
        // Average scores
        $this->db->select_avg('nilai_fashohah', 'avg_fashohah');
        $this->db->select_avg('nilai_tajwid', 'avg_tajwid');
        $this->db->select_avg('nilai_kelancaran', 'avg_kelancaran');
        $stats['average_scores'] = $this->db->get('penilaian')->row_array();
        
        return $stats;
    }

    // Class Management
    public function get_all_classes() {
        return $this->db->get('kelas')->result_array();
    }

    public function get_class_by_id($id) {
        return $this->db->get_where('kelas', ['id' => $id])->row_array();
    }

    public function add_class($data) {
        return $this->db->insert('kelas', $data);
    }

    public function update_class($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('kelas', $data);
    }

    public function delete_class($id) {
        // Check if class has students
        $students = $this->db->get_where('siswa', ['id_kelas' => $id])->num_rows();
        if($students > 0) {
            return false;
        }
        return $this->db->delete('kelas', ['id' => $id]);
    }

    // Report Generation
    public function get_class_report($class_id) {
        $this->db->select('siswa.*, kelas.nama_kelas');
        $this->db->from('siswa');
        $this->db->join('kelas', 'kelas.id = siswa.id_kelas');
        $this->db->where('siswa.id_kelas', $class_id);
        return $this->db->get()->result_array();
    }

    public function get_student_evaluations($student_id) {
        $this->db->select('penilaian.*, surat.nama_surat_latin, instruktur.nama_instruktur');
        $this->db->from('penilaian');
        $this->db->join('surat', 'surat.id = penilaian.id_surat');
        $this->db->join('instruktur', 'instruktur.id = penilaian.id_instruktur');
        $this->db->where('penilaian.id_siswa', $student_id);
        $this->db->order_by('penilaian.tanggal_penilaian', 'DESC');
        return $this->db->get()->result_array();
    }

    // System Settings
    public function get_settings() {
        return $this->db->get('pengaturan')->row_array();
    }

    public function update_settings($data) {
        if($this->db->get('pengaturan')->num_rows() > 0) {
            return $this->db->update('pengaturan', $data);
        } else {
            return $this->db->insert('pengaturan', $data);
        }
    }
}
