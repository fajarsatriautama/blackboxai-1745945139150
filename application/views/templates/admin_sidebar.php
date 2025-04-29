<div class="min-h-screen flex">
    <!-- Sidebar -->
    <div class="bg-gray-800 text-white w-64 space-y-6 py-7 px-2 absolute inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition duration-200 ease-in-out">
        <!-- Logo -->
        <div class="flex items-center space-x-2 px-4">
            <i class="fas fa-quran text-2xl"></i>
            <span class="text-lg font-semibold">Rapor Tahfizh</span>
        </div>

        <!-- Navigation -->
        <nav class="space-y-2">
            <a href="<?= base_url('admin/dashboard') ?>" 
               class="block py-2.5 px-4 rounded transition duration-200 <?= $this->uri->segment(2) == 'dashboard' ? 'bg-gray-700' : 'hover:bg-gray-700' ?>">
                <i class="fas fa-home w-6"></i>
                Dashboard
            </a>

            <!-- User Management -->
            <div class="space-y-2">
                <div class="px-4 py-2 text-xs uppercase tracking-wide text-gray-400">
                    Manajemen Pengguna
                </div>
                <a href="<?= base_url('admin/users/siswa') ?>" 
                   class="block py-2.5 px-4 rounded transition duration-200 <?= ($this->uri->segment(2) == 'users' && $this->uri->segment(3) == 'siswa') ? 'bg-gray-700' : 'hover:bg-gray-700' ?>">
                    <i class="fas fa-user-graduate w-6"></i>
                    Siswa
                </a>
                <a href="<?= base_url('admin/users/instruktur') ?>" 
                   class="block py-2.5 px-4 rounded transition duration-200 <?= ($this->uri->segment(2) == 'users' && $this->uri->segment(3) == 'instruktur') ? 'bg-gray-700' : 'hover:bg-gray-700' ?>">
                    <i class="fas fa-chalkboard-teacher w-6"></i>
                    Instruktur
                </a>
            </div>

            <!-- Class Management -->
            <div class="space-y-2">
                <div class="px-4 py-2 text-xs uppercase tracking-wide text-gray-400">
                    Manajemen Kelas
                </div>
                <a href="<?= base_url('admin/kelas') ?>" 
                   class="block py-2.5 px-4 rounded transition duration-200 <?= $this->uri->segment(2) == 'kelas' ? 'bg-gray-700' : 'hover:bg-gray-700' ?>">
                    <i class="fas fa-school w-6"></i>
                    Data Kelas
                </a>
            </div>

            <!-- Reports -->
            <div class="space-y-2">
                <div class="px-4 py-2 text-xs uppercase tracking-wide text-gray-400">
                    Laporan
                </div>
                <a href="<?= base_url('admin/laporan/kelas') ?>" 
                   class="block py-2.5 px-4 rounded transition duration-200 <?= ($this->uri->segment(2) == 'laporan' && $this->uri->segment(3) == 'kelas') ? 'bg-gray-700' : 'hover:bg-gray-700' ?>">
                    <i class="fas fa-file-alt w-6"></i>
                    Laporan Kelas
                </a>
                <a href="<?= base_url('admin/laporan/siswa') ?>" 
                   class="block py-2.5 px-4 rounded transition duration-200 <?= ($this->uri->segment(2) == 'laporan' && $this->uri->segment(3) == 'siswa') ? 'bg-gray-700' : 'hover:bg-gray-700' ?>">
                    <i class="fas fa-user-chart w-6"></i>
                    Laporan Siswa
                </a>
            </div>

            <!-- Settings -->
            <div class="space-y-2">
                <div class="px-4 py-2 text-xs uppercase tracking-wide text-gray-400">
                    Pengaturan
                </div>
                <a href="<?= base_url('admin/profile') ?>" 
                   class="block py-2.5 px-4 rounded transition duration-200 <?= $this->uri->segment(2) == 'profile' ? 'bg-gray-700' : 'hover:bg-gray-700' ?>">
                    <i class="fas fa-user-cog w-6"></i>
                    Profil
                </a>
                <a href="<?= base_url('admin/pengaturan') ?>" 
                   class="block py-2.5 px-4 rounded transition duration-200 <?= $this->uri->segment(2) == 'pengaturan' ? 'bg-gray-700' : 'hover:bg-gray-700' ?>">
                    <i class="fas fa-cog w-6"></i>
                    Pengaturan
                </a>
            </div>
        </nav>
    </div>

    <!-- Content -->
    <div class="flex-1 flex flex-col">
        <!-- Top Navigation -->
        <div class="bg-white shadow-sm">
            <div class="flex justify-between items-center py-4 px-6">
                <!-- Mobile Menu Button -->
                <button class="md:hidden" id="mobile-menu-button">
                    <i class="fas fa-bars text-gray-600 text-2xl"></i>
                </button>

                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700"><?= $this->session->userdata('nama_lengkap') ?></span>
                    <a href="<?= base_url('auth/logout') ?>" class="text-red-600 hover:text-red-700">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 bg-gray-100 p-6">
