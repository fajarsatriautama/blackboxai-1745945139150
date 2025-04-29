<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }

    public function get_user_by_username($username) {
        return $this->db->get_where('pengguna', ['username' => $username])->row_array();
    }

    public function get_user_by_id($id) {
        return $this->db->get_where('pengguna', ['id' => $id])->row_array();
    }

    public function get_user_role_data($user_id, $role) {
        switch($role) {
            case 'siswa':
                $this->db->select('siswa.*, kelas.nama_kelas');
                $this->db->from('siswa');
                $this->db->join('kelas', 'kelas.id = siswa.id_kelas');
                $this->db->where('siswa.id_pengguna', $user_id);
                return $this->db->get()->row_array();
            
            case 'instruktur':
                return $this->db->get_where('instruktur', ['id_pengguna' => $user_id])->row_array();
            
            default:
                return null;
        }
    }

    public function create_user($data) {
        $this->db->insert('pengguna', $data);
        return $this->db->insert_id();
    }

    public function update_user($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('pengguna', $data);
    }

    public function update_password($id, $new_password) {
        $this->db->where('id', $id);
        return $this->db->update('pengguna', [
            'password' => password_hash($new_password, PASSWORD_DEFAULT)
        ]);
    }

    public function check_old_password($id, $old_password) {
        $user = $this->get_user_by_id($id);
        if($user) {
            return password_verify($old_password, $user['password']);
        }
        return false;
    }

    public function update_last_login($id) {
        $this->db->where('id', $id);
        return $this->db->update('pengguna', [
            'last_login' => date('Y-m-d H:i:s')
        ]);
    }

    public function is_username_exists($username, $exclude_id = null) {
        if($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        $query = $this->db->get_where('pengguna', ['username' => $username]);
        return $query->num_rows() > 0;
    }

    public function delete_user($id) {
        return $this->db->delete('pengguna', ['id' => $id]);
    }
}
