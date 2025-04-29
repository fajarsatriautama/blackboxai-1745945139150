<div class="min-h-screen flex">
    <!-- Sidebar -->
    <div class="bg-blue-800 text-white w-64 space-y-6 py-7 px-2 absolute inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition duration-200 ease-in-out">
        <!-- Logo -->
        <div class="flex items-center space-x-2 px-4">
            <i class="fas fa-quran text-2xl"></i>
            <span class="text-lg font-semibold">Rapor Tahfizh</span>
        </div>

        <!-- Navigation -->
        <nav class="space-y-2">
            <a href="<?= base_url('instruktur/dashboard') ?>" 
               class="block py-2.5 px-4 rounded transition duration-200 <?= $this->uri->segment(2) == 'dashboard' ? 'bg-blue-700' : 'hover:bg-blue-700' ?>">
                <i class="fas fa-home w-6"></i>
                Dashboard
            </a>

            <!-- Student Management -->
            <div class="space-y-2">
                <div class="px-4 py-2 text-xs uppercase tracking-wide text-blue-300">
                    Manajemen Siswa
                </div>
                <a href="<?= base_url('instruktur/siswa') ?>" 
                   class="block py-2.5 px-4 rounded transition duration-200 <?= $this->uri->segment(2) == 'siswa' ? 'bg-blue-700' : 'hover:bg-blue-700' ?>">
                    <i class="fas fa-user-graduate w-6"></i>
                    Daftar Siswa
                </a>
            </div>

            <!-- Evaluation -->
            <div class="space-y-2">
                <div class="px-4 py-2 text-xs uppercase tracking-wide text-blue-300">
                    Penilaian
                </div>
                <a href="<?= base_url('instruktur/penilaian') ?>" 
                   class="block py-2.5 px-4 rounded transition duration-200 <?= $this->uri->segment(2) == 'penilaian' ? 'bg-blue-700' : 'hover:bg-blue-700' ?>">
                    <i class="fas fa-star w-6"></i>
                    Input Nilai
                </a>
                <a href="<?= base_url('instruktur/pencapaian') ?>" 
                   class="block py-2.5 px-4 rounded transition duration-200 <?= $this->uri->segment(2) == 'pencapaian' ? 'bg-blue-700' : 'hover:bg-blue-700' ?>">
                    <i class="fas fa-tasks w-6"></i>
                    Catat Pencapaian
                </a>
            </div>

            <!-- Reports -->
            <div class="space-y-2">
                <div class="px-4 py-2 text-xs uppercase tracking-wide text-blue-300">
                    Laporan
                </div>
                <a href="<?= base_url('instruktur/laporan') ?>" 
                   class="block py-2.5 px-4 rounded transition duration-200 <?= $this->uri->segment(2) == 'laporan' ? 'bg-blue-700' : 'hover:bg-blue-700' ?>">
                    <i class="fas fa-file-alt w-6"></i>
                    Cetak Rapor
                </a>
            </div>

            <!-- Profile -->
            <div class="space-y-2">
                <div class="px-4 py-2 text-xs uppercase tracking-wide text-blue-300">
                    Pengaturan
                </div>
                <a href="<?= base_url('instruktur/profile') ?>" 
                   class="block py-2.5 px-4 rounded transition duration-200 <?= $this->uri->segment(2) == 'profile' ? 'bg-blue-700' : 'hover:bg-blue-700' ?>">
                    <i class="fas fa-user-cog w-6"></i>
                    Profil
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
