<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Install extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->dbforge();
    }

    public function index() {
        // Create tables
        $this->create_tables();
        
        // Load models for initialization
        $this->load->model('kelas_model');
        $this->load->model('surat_model');
        
        // Initialize data
        $this->kelas_model->initialize_classes();
        $this->surat_model->initialize_surahs();
        
        // Create default admin account
        $this->create_admin();
        
        // Load the installation success view
        $this->load->view('install/index');
    }

    private function create_tables() {
        // Kelas (Class) Table
        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
            'nama_kelas' => ['type' => 'VARCHAR', 'constraint' => 50],
            'tahun_ajaran' => ['type' => 'VARCHAR', 'constraint' => 20],
            'kapasitas' => ['type' => 'INT', 'constraint' => 11, 'default' => 32],
            'dibuat_pada' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP'],
            'diperbarui_pada' => ['type' => 'TIMESTAMP', 'null' => TRUE]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('kelas', TRUE);

        // Pengguna (User) Table
        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
            'username' => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => TRUE],
            'password' => ['type' => 'VARCHAR', 'constraint' => 255],
            'peran' => ['type' => 'ENUM("admin","instruktur","siswa")', 'default' => 'siswa'],
            'nama_lengkap' => ['type' => 'VARCHAR', 'constraint' => 100],
            'foto_profil' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE],
            'dibuat_pada' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP'],
            'diperbarui_pada' => ['type' => 'TIMESTAMP', 'null' => TRUE]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('pengguna', TRUE);

        // Siswa (Student) Table
        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
            'id_pengguna' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
            'id_kelas' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
            'nisn' => ['type' => 'VARCHAR', 'constraint' => 20, 'unique' => TRUE],
            'nama_siswa' => ['type' => 'VARCHAR', 'constraint' => 100],
            'jenis_kelamin' => ['type' => 'ENUM("L","P")'],
            'dibuat_pada' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP'],
            'diperbarui_pada' => ['type' => 'TIMESTAMP', 'null' => TRUE]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (id_pengguna) REFERENCES pengguna(id) ON DELETE CASCADE');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (id_kelas) REFERENCES kelas(id) ON DELETE CASCADE');
        $this->dbforge->create_table('siswa', TRUE);

        // Instruktur (Instructor) Table
        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
            'id_pengguna' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
            'nip' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => TRUE],
            'nama_instruktur' => ['type' => 'VARCHAR', 'constraint' => 100],
            'dibuat_pada' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP'],
            'diperbarui_pada' => ['type' => 'TIMESTAMP', 'null' => TRUE]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (id_pengguna) REFERENCES pengguna(id) ON DELETE CASCADE');
        $this->dbforge->create_table('instruktur', TRUE);

        // Surat Table
        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
            'nomor_surat' => ['type' => 'INT', 'constraint' => 11],
            'nama_surat_arab' => ['type' => 'VARCHAR', 'constraint' => 100],
            'nama_surat_latin' => ['type' => 'VARCHAR', 'constraint' => 100],
            'jumlah_ayat' => ['type' => 'INT', 'constraint' => 11],
            'jenis_turun' => ['type' => 'ENUM("Makkiyah","Madaniyah")'],
            'dibuat_pada' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP']
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('surat', TRUE);

        // Penilaian (Evaluation) Table
        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
            'id_siswa' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
            'id_surat' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
            'id_instruktur' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
            'nilai_fashohah' => ['type' => 'DECIMAL', 'constraint' => '5,2'],
            'nilai_tajwid' => ['type' => 'DECIMAL', 'constraint' => '5,2'],
            'nilai_kelancaran' => ['type' => 'DECIMAL', 'constraint' => '5,2'],
            'tanggal_penilaian' => ['type' => 'DATE'],
            'dibuat_pada' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP']
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (id_siswa) REFERENCES siswa(id) ON DELETE CASCADE');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (id_surat) REFERENCES surat(id) ON DELETE CASCADE');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (id_instruktur) REFERENCES instruktur(id) ON DELETE CASCADE');
        $this->dbforge->create_table('penilaian', TRUE);

        // Pencapaian Surat (Surah Achievement) Table
        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE],
            'id_siswa' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
            'id_surat' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
            'ayat_mulai' => ['type' => 'INT', 'constraint' => 11],
            'ayat_selesai' => ['type' => 'INT', 'constraint' => 11],
            'id_instruktur' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
            'tanggal_setor' => ['type' => 'DATE'],
            'dibuat_pada' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP']
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (id_siswa) REFERENCES siswa(id) ON DELETE CASCADE');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (id_surat) REFERENCES surat(id) ON DELETE CASCADE');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (id_instruktur) REFERENCES instruktur(id) ON DELETE CASCADE');
        $this->dbforge->create_table('pencapaian_surat', TRUE);
    }

    private function create_admin() {
        $admin_data = [
            'username' => 'admin',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'peran' => 'admin',
            'nama_lengkap' => 'Administrator',
            'dibuat_pada' => date('Y-m-d H:i:s')
        ];
        
        $this->db->insert('pengguna', $admin_data);
    }
}
