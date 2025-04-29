<div class="min-h-screen flex">
    <!-- Sidebar -->
    <div class="bg-green-800 text-white w-64 space-y-6 py-7 px-2 absolute inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition duration-200 ease-in-out">
        <!-- Logo -->
        <div class="flex items-center space-x-2 px-4">
            <i class="fas fa-quran text-2xl"></i>
            <span class="text-lg font-semibold">Rapor Tahfizh</span>
        </div>

        <!-- Navigation -->
        <nav class="space-y-2">
            <a href="<?= base_url('siswa/dashboard') ?>" 
               class="block py-2.5 px-4 rounded transition duration-200 <?= $this->uri->segment(2) == 'dashboard' ? 'bg-green-700' : 'hover:bg-green-700' ?>">
                <i class="fas fa-home w-6"></i>
                Dashboard
            </a>

            <!-- Evaluations -->
            <div class="space-y-2">
                <div class="px-4 py-2 text-xs uppercase tracking-wide text-green-300">
                    Penilaian
                </div>
                <a href="<?= base_url('siswa/nilai') ?>" 
                   class="block py-2.5 px-4 rounded transition duration-200 <?= $this->uri->segment(2) == 'nilai' ? 'bg-green-700' : 'hover:bg-green-700' ?>">
                    <i class="fas fa-star w-6"></i>
                    Nilai Saya
                </a>
                <a href="<?= base_url('siswa/pencapaian') ?>" 
                   class="block py-2.5 px-4 rounded transition duration-200 <?= $this->uri->segment(2) == 'pencapaian' ? 'bg-green-700' : 'hover:bg-green-700' ?>">
                    <i class="fas fa-tasks w-6"></i>
                    Pencapaian Hafalan
                </a>
            </div>

            <!-- Report -->
            <div class="space-y-2">
                <div class="px-4 py-2 text-xs uppercase tracking-wide text-green-300">
                    Rapor
                </div>
                <a href="<?= base_url('siswa/rapor') ?>" 
                   class="block py-2.5 px-4 rounded transition duration-200 <?= $this->uri->segment(2) == 'rapor' ? 'bg-green-700' : 'hover:bg-green-700' ?>">
                    <i class="fas fa-file-alt w-6"></i>
                    Lihat Rapor
                </a>
            </div>

            <!-- Profile -->
            <div class="space-y-2">
                <div class="px-4 py-2 text-xs uppercase tracking-wide text-green-300">
                    Pengaturan
                </div>
                <a href="<?= base_url('siswa/profile') ?>" 
                   class="block py-2.5 px-4 rounded transition duration-200 <?= $this->uri->segment(2) == 'profile' ? 'bg-green-700' : 'hover:bg-green-700' ?>">
                    <i class="fas fa-user-cog w-6"></i>
                    Profil Saya
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
                    <div class="text-right">
                        <p class="text-gray-900 font-medium"><?= $siswa['nama_siswa'] ?></p>
                        <p class="text-sm text-gray-600"><?= $siswa['nama_kelas'] ?></p>
                    </div>
                    <a href="<?= base_url('auth/logout') ?>" class="text-red-600 hover:text-red-700">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 bg-gray-100 p-6">
