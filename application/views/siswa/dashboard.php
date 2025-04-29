<?php $this->load->view('templates/siswa_sidebar'); ?>

<!-- Student Profile Card -->
<div class="bg-white rounded-lg shadow-sm p-6 mb-6">
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <?php if($siswa['foto_profil']): ?>
                <img src="<?= base_url('assets/uploads/profile/'.$siswa['foto_profil']) ?>" 
                     alt="<?= $siswa['nama_siswa'] ?>" 
                     class="h-20 w-20 rounded-full object-cover">
            <?php else: ?>
                <div class="h-20 w-20 rounded-full bg-green-100 flex items-center justify-center">
                    <i class="fas fa-user text-3xl text-green-600"></i>
                </div>
            <?php endif; ?>
        </div>
        <div class="ml-6">
            <h1 class="text-2xl font-bold text-gray-900"><?= $siswa['nama_siswa'] ?></h1>
            <p class="text-gray-600">NISN: <?= $siswa['nisn'] ?></p>
            <p class="text-gray-600">Kelas: <?= $siswa['nama_kelas'] ?></p>
        </div>
    </div>
</div>

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
                <p class="text-2xl font-semibold text-gray-700"><?= $statistik['total_penilaian'] ?></p>
            </div>
        </div>
    </div>

    <!-- Total Pencapaian -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-tasks text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-gray-500 text-sm">Total Pencapaian</h3>
                <p class="text-2xl font-semibold text-gray-700"><?= $statistik['total_pencapaian'] ?></p>
            </div>
        </div>
    </div>

    <!-- Rata-rata Nilai -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                <i class="fas fa-chart-line text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-gray-500 text-sm">Rata-rata Nilai</h3>
                <p class="text-2xl font-semibold text-gray-700">
                    <?php
                    $avg = 0;
                    if(!empty($penilaian_terbaru)) {
                        $total = 0;
                        foreach($penilaian_terbaru as $nilai) {
                            $total += ($nilai['nilai_fashohah'] + $nilai['nilai_tajwid'] + $nilai['nilai_kelancaran']) / 3;
                        }
                        $avg = number_format($total / count($penilaian_terbaru), 1);
                    }
                    echo $avg;
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
            <?php if(!empty($penilaian_terbaru)): ?>
                <div class="space-y-4">
                    <?php foreach($penilaian_terbaru as $penilaian): ?>
                        <div class="flex items-start">
                            <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">
                                    <?= $penilaian['nama_surat_latin'] ?>
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
                    <a href="<?= base_url('siswa/nilai') ?>" class="text-blue-600 hover:text-blue-700 text-sm">
                        Lihat Semua Nilai <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            <?php else: ?>
                <p class="text-gray-500 text-center">Belum ada penilaian</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recent Achievements -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold text-gray-700">Pencapaian Terbaru</h2>
        </div>
        <div class="p-6">
            <?php if(!empty($pencapaian)): ?>
                <div class="space-y-4">
                    <?php foreach(array_slice($pencapaian, 0, 5) as $capaian): ?>
                        <div class="flex items-start">
                            <div class="p-2 rounded-full bg-green-100 text-green-600">
                                <i class="fas fa-bookmark"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">
                                    <?= $capaian['nama_surat_latin'] ?>
                                </p>
                                <p class="text-sm text-gray-500">
                                    Ayat <?= $capaian['ayat_mulai'] ?> - <?= $capaian['ayat_selesai'] ?>
                                </p>
                                <p class="text-xs text-gray-400">
                                    <?= date('d M Y', strtotime($capaian['tanggal_setor'])) ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mt-4 text-center">
                    <a href="<?= base_url('siswa/pencapaian') ?>" class="text-green-600 hover:text-green-700 text-sm">
                        Lihat Semua Pencapaian <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            <?php else: ?>
                <p class="text-gray-500 text-center">Belum ada pencapaian</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-6">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Aksi Cepat</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="<?= base_url('siswa/nilai') ?>" class="p-4 border rounded-lg text-center hover:bg-gray-50">
                <i class="fas fa-star text-2xl text-blue-600 mb-2"></i>
                <p class="text-sm text-gray-600">Lihat Nilai</p>
            </a>
            <a href="<?= base_url('siswa/pencapaian') ?>" class="p-4 border rounded-lg text-center hover:bg-gray-50">
                <i class="fas fa-tasks text-2xl text-green-600 mb-2"></i>
                <p class="text-sm text-gray-600">Lihat Pencapaian</p>
            </a>
            <a href="<?= base_url('siswa/rapor') ?>" class="p-4 border rounded-lg text-center hover:bg-gray-50">
                <i class="fas fa-file-alt text-2xl text-yellow-600 mb-2"></i>
                <p class="text-sm text-gray-600">Lihat Rapor</p>
            </a>
            <a href="<?= base_url('siswa/profile') ?>" class="p-4 border rounded-lg text-center hover:bg-gray-50">
                <i class="fas fa-user-cog text-2xl text-gray-600 mb-2"></i>
                <p class="text-sm text-gray-600">Edit Profil</p>
            </a>
        </div>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?>
