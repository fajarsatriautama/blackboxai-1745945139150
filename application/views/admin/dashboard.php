<?php $this->load->view('templates/admin_sidebar'); ?>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Siswa -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-user-graduate text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-gray-500 text-sm">Total Siswa</h3>
                <p class="text-2xl font-semibold text-gray-700"><?= $total_siswa ?></p>
            </div>
        </div>
    </div>

    <!-- Total Instruktur -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-chalkboard-teacher text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-gray-500 text-sm">Total Instruktur</h3>
                <p class="text-2xl font-semibold text-gray-700"><?= $total_instruktur ?></p>
            </div>
        </div>
    </div>

    <!-- Total Kelas -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                <i class="fas fa-school text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-gray-500 text-sm">Total Kelas</h3>
                <p class="text-2xl font-semibold text-gray-700"><?= $total_kelas ?></p>
            </div>
        </div>
    </div>

    <!-- Total Penilaian -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <i class="fas fa-star text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-gray-500 text-sm">Penilaian Bulan Ini</h3>
                <p class="text-2xl font-semibold text-gray-700"><?= count($recent_penilaian) ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Evaluations -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold text-gray-700">Penilaian Terbaru</h2>
        </div>
        <div class="p-6">
            <?php if(!empty($recent_penilaian)): ?>
                <div class="space-y-4">
                    <?php foreach($recent_penilaian as $penilaian): ?>
                        <div class="flex items-start">
                            <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">
                                    <?= $penilaian['nama_siswa'] ?> - <?= $penilaian['nama_surat_latin'] ?>
                                </p>
                                <p class="text-sm text-gray-500">
                                    Nilai: Fashohah (<?= $penilaian['nilai_fashohah'] ?>), 
                                    Tajwid (<?= $penilaian['nilai_tajwid'] ?>), 
                                    Kelancaran (<?= $penilaian['nilai_kelancaran'] ?>)
                                </p>
                                <p class="text-xs text-gray-400">
                                    <?= date('d M Y', strtotime($penilaian['tanggal_penilaian'])) ?> 
                                    oleh <?= $penilaian['nama_instruktur'] ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-gray-500 text-center">Belum ada penilaian terbaru</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold text-gray-700">Pengguna Terbaru</h2>
        </div>
        <div class="p-6">
            <?php if(!empty($recent_users)): ?>
                <div class="space-y-4">
                    <?php foreach($recent_users as $user): ?>
                        <div class="flex items-start">
                            <div class="p-2 rounded-full <?= $user['peran'] == 'siswa' ? 'bg-green-100 text-green-600' : 'bg-blue-100 text-blue-600' ?>">
                                <i class="fas <?= $user['peran'] == 'siswa' ? 'fa-user-graduate' : 'fa-chalkboard-teacher' ?>"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">
                                    <?= $user['nama_lengkap'] ?>
                                </p>
                                <p class="text-sm text-gray-500">
                                    <?= ucfirst($user['peran']) ?>
                                </p>
                                <p class="text-xs text-gray-400">
                                    Bergabung: <?= date('d M Y', strtotime($user['dibuat_pada'])) ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-gray-500 text-center">Belum ada pengguna terbaru</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-6">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Aksi Cepat</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="<?= base_url('admin/users/add') ?>" class="p-4 border rounded-lg text-center hover:bg-gray-50">
                <i class="fas fa-user-plus text-2xl text-blue-600 mb-2"></i>
                <p class="text-sm text-gray-600">Tambah Pengguna</p>
            </a>
            <a href="<?= base_url('admin/kelas/add') ?>" class="p-4 border rounded-lg text-center hover:bg-gray-50">
                <i class="fas fa-plus-circle text-2xl text-green-600 mb-2"></i>
                <p class="text-sm text-gray-600">Tambah Kelas</p>
            </a>
            <a href="<?= base_url('admin/laporan/generate') ?>" class="p-4 border rounded-lg text-center hover:bg-gray-50">
                <i class="fas fa-file-pdf text-2xl text-red-600 mb-2"></i>
                <p class="text-sm text-gray-600">Buat Laporan</p>
            </a>
            <a href="<?= base_url('admin/pengaturan') ?>" class="p-4 border rounded-lg text-center hover:bg-gray-50">
                <i class="fas fa-cog text-2xl text-gray-600 mb-2"></i>
                <p class="text-sm text-gray-600">Pengaturan</p>
            </a>
        </div>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?>
