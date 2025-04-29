<?php $this->load->view('templates/instruktur_sidebar'); ?>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Total Penilaian -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-star text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-gray-500 text-sm">Total Penilaian</h3>
                <p class="text-2xl font-semibold text-gray-700"><?= $total_penilaian ?></p>
            </div>
        </div>
    </div>

    <!-- Total Siswa -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-user-graduate text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-gray-500 text-sm">Total Siswa</h3>
                <p class="text-2xl font-semibold text-gray-700"><?= $total_siswa ?></p>
            </div>
        </div>
    </div>

    <!-- Penilaian Hari Ini -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <i class="fas fa-clipboard-check text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-gray-500 text-sm">Penilaian Hari Ini</h3>
                <p class="text-2xl font-semibold text-gray-700">
                    <?php 
                    $today_evaluations = array_filter($recent_penilaian, function($item) {
                        return date('Y-m-d', strtotime($item['tanggal_penilaian'])) == date('Y-m-d');
                    });
                    echo count($today_evaluations);
                    ?>
                </p>
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
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mt-4 text-center">
                    <a href="<?= base_url('instruktur/penilaian') ?>" class="text-blue-600 hover:text-blue-700 text-sm">
                        Lihat Semua Penilaian <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            <?php else: ?>
                <p class="text-gray-500 text-center">Belum ada penilaian terbaru</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="space-y-6">
        <!-- Action Cards -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Aksi Cepat</h2>
            <div class="grid grid-cols-2 gap-4">
                <a href="<?= base_url('instruktur/penilaian/add') ?>" 
                   class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition duration-200">
                    <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-plus"></i>
                    </div>
                    <span class="ml-3 text-sm font-medium text-gray-700">Input Nilai</span>
                </a>
                <a href="<?= base_url('instruktur/pencapaian/add') ?>" 
                   class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition duration-200">
                    <div class="p-2 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <span class="ml-3 text-sm font-medium text-gray-700">Catat Pencapaian</span>
                </a>
                <a href="<?= base_url('instruktur/laporan') ?>" 
                   class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition duration-200">
                    <div class="p-2 rounded-full bg-purple-100 text-purple-600">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <span class="ml-3 text-sm font-medium text-gray-700">Cetak Rapor</span>
                </a>
                <a href="<?= base_url('instruktur/siswa') ?>" 
                   class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition duration-200">
                    <div class="p-2 rounded-full bg-yellow-100 text-yellow-600">
                        <i class="fas fa-users"></i>
                    </div>
                    <span class="ml-3 text-sm font-medium text-gray-700">Lihat Siswa</span>
                </a>
            </div>
        </div>

        <!-- Calendar -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Kalender Penilaian</h2>
            <div class="text-sm text-gray-600">
                <p class="mb-2">
                    <i class="fas fa-calendar-check text-blue-600"></i>
                    Hari ini: <?= date('d M Y') ?>
                </p>
                <p>
                    <i class="fas fa-clock text-green-600"></i>
                    Waktu: <?= date('H:i') ?> WIB
                </p>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?>
