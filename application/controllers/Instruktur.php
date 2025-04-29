<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Instruktur extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Check if user is logged in
        if(!$this->session->userdata('logged_in')) {
            redirect('auth/login/instruktur');
        }
        // Check if user is instruktur
        if($this->session->userdata('peran') !== 'instruktur') {
            redirect('auth/login/instruktur');
        }
        
        $this->load->model('instruktur_model');
        $this->load->model('siswa_model');
        $this->load->model('penilaian_model');
        $this->load->model('surat_model');
    }

    public function index() {
        redirect('instruktur/dashboard');
    }

    public function dashboard() {
        $data['title'] = 'Dashboard Instruktur';
        $id_instruktur = $this->instruktur_model->get_id_by_user($this->session->userdata('user_id'));
        
        // Get statistics
        $data['total_penilaian'] = $this->penilaian_model->count_by_instruktur($id_instruktur);
        $data['total_siswa'] = $this->siswa_model->count_all();
        
        // Get recent activities
        $data['recent_penilaian'] = $this->penilaian_model->get_recent_by_instruktur($id_instruktur, 5);
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('instruktur/dashboard', $data);
        $this->load->view('templates/footer');
    }

    public function siswa() {
        $data['title'] = 'Daftar Siswa';
        $data['siswa'] = $this->siswa_model->get_all_with_class();
        
        $this->load->view('templates/header', $data);
        $this->load->view('instruktur/siswa/index', $data);
        $this->load->view('templates/footer');
    }

    public function penilaian($id_siswa = null) {
        if(!$id_siswa) {
            redirect('instruktur/siswa');
        }

        $data['title'] = 'Input Penilaian';
        $data['siswa'] = $this->siswa_model->get_by_id($id_siswa);
        $data['surat'] = $this->surat_model->get_all();
        
        $this->form_validation->set_rules('id_surat', 'Surat', 'required');
        $this->form_validation->set_rules('nilai_fashohah', 'Nilai Fashohah', 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
        $this->form_validation->set_rules('nilai_tajwid', 'Nilai Tajwid', 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
        $this->form_validation->set_rules('nilai_kelancaran', 'Nilai Kelancaran', 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('instruktur/penilaian/form', $data);
            $this->load->view('templates/footer');
        } else {
            $penilaian_data = [
                'id_siswa' => $id_siswa,
                'id_surat' => $this->input->post('id_surat'),
                'id_instruktur' => $this->instruktur_model->get_id_by_user($this->session->userdata('user_id')),
                'nilai_fashohah' => $this->input->post('nilai_fashohah'),
                'nilai_tajwid' => $this->input->post('nilai_tajwid'),
                'nilai_kelancaran' => $this->input->post('nilai_kelancaran'),
                'tanggal_penilaian' => date('Y-m-d')
            ];
            
            if($this->penilaian_model->add($penilaian_data)) {
                $this->session->set_flashdata('message', '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">Penilaian berhasil disimpan!</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">Gagal menyimpan penilaian!</div>');
            }
            redirect('instruktur/siswa/detail/'.$id_siswa);
        }
    }

    public function pencapaian($id_siswa = null) {
        if(!$id_siswa) {
            redirect('instruktur/siswa');
        }

        $data['title'] = 'Catat Pencapaian';
        $data['siswa'] = $this->siswa_model->get_by_id($id_siswa);
        $data['surat'] = $this->surat_model->get_all();
        
        $this->form_validation->set_rules('id_surat', 'Surat', 'required');
        $this->form_validation->set_rules('ayat_mulai', 'Ayat Mulai', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('ayat_selesai', 'Ayat Selesai', 'required|numeric|greater_than[0]');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('instruktur/pencapaian/form', $data);
            $this->load->view('templates/footer');
        } else {
            $pencapaian_data = [
                'id_siswa' => $id_siswa,
                'id_surat' => $this->input->post('id_surat'),
                'id_instruktur' => $this->instruktur_model->get_id_by_user($this->session->userdata('user_id')),
                'ayat_mulai' => $this->input->post('ayat_mulai'),
                'ayat_selesai' => $this->input->post('ayat_selesai'),
                'tanggal_setor' => date('Y-m-d')
            ];
            
            if($this->instruktur_model->add_pencapaian($pencapaian_data)) {
                $this->session->set_flashdata('message', '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">Pencapaian berhasil dicatat!</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">Gagal mencatat pencapaian!</div>');
            }
            redirect('instruktur/siswa/detail/'.$id_siswa);
        }
    }

    public function laporan() {
        $data['title'] = 'Laporan';
        $id_instruktur = $this->instruktur_model->get_id_by_user($this->session->userdata('user_id'));
        
        if($this->input->post('generate')) {
            $tanggal_mulai = $this->input->post('tanggal_mulai');
            $tanggal_selesai = $this->input->post('tanggal_selesai');
            $id_kelas = $this->input->post('id_kelas');
            
            $data['laporan'] = $this->penilaian_model->get_report_by_instruktur(
                $id_instruktur, 
                $tanggal_mulai, 
                $tanggal_selesai, 
                $id_kelas
            );
        }
        
        $data['kelas'] = $this->db->get('kelas')->result_array();
        
        $this->load->view('templates/header', $data);
        $this->load->view('instruktur/laporan/index', $data);
        $this->load->view('templates/footer');
    }

    public function profile() {
        $data['title'] = 'Profil Instruktur';
        $data['user'] = $this->instruktur_model->get_profile($this->session->userdata('user_id'));
        
        $this->load->view('templates/header', $data);
        $this->load->view('instruktur/profile', $data);
        $this->load->view('templates/footer');
    }

    public function update_profile() {
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
        
        if ($this->form_validation->run() == FALSE) {
            redirect('instruktur/profile');
        } else {
            $user_data = [
                'nama_lengkap' => $this->input->post('nama_lengkap')
            ];
            
            // Handle photo upload if exists
            if(!empty($_FILES['foto']['name'])) {
                $config['upload_path'] = './assets/uploads/profile/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 2048;
                $config['file_name'] = 'instruktur_'.$this->session->userdata('user_id');
                
                $this->load->library('upload', $config);
                
                if($this->upload->do_upload('foto')) {
                    $user_data['foto_profil'] = $this->upload->data('file_name');
                }
            }
            
            if($this->instruktur_model->update_profile($this->session->userdata('user_id'), $user_data)) {
                $this->session->set_flashdata('message', '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">Profil berhasil diperbarui!</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">Gagal memperbarui profil!</div>');
            }
            redirect('instruktur/profile');
        }
    }
}
