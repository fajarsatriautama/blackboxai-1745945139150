<!-- Main Hero Slider -->
<div class="swiper-container main-slider h-[500px] relative">
    <div class="swiper-wrapper">
        <!-- Slide 1 -->
        <div class="swiper-slide relative">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <img src="https://source.unsplash.com/1600x900/?quran" alt="Slider 1" class="w-full h-full object-cover">
            <div class="absolute inset-0 flex items-center justify-center text-center">
                <div class="text-white px-4">
                    <h1 class="text-4xl md:text-6xl font-bold mb-4">Rapor Tahfizh</h1>
                    <p class="text-xl md:text-2xl mb-8">Sistem Informasi Manajemen Penilaian Hafalan Al-Quran</p>
                    <a href="<?= base_url('home/login') ?>" class="bg-green-600 text-white px-8 py-3 rounded-lg hover:bg-green-700 transition duration-300">
                        Mulai Sekarang
                    </a>
                </div>
            </div>
        </div>
        <!-- Slide 2 -->
        <div class="swiper-slide relative">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <img src="https://source.unsplash.com/1600x900/?muslim-education" alt="Slider 2" class="w-full h-full object-cover">
            <div class="absolute inset-0 flex items-center justify-center text-center">
                <div class="text-white px-4">
                    <h2 class="text-4xl md:text-6xl font-bold mb-4">Pantau Perkembangan</h2>
                    <p class="text-xl md:text-2xl">Evaluasi dan monitoring hafalan Al-Quran siswa</p>
                </div>
            </div>
        </div>
    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-next text-white"></div>
    <div class="swiper-button-prev text-white"></div>
</div>

<!-- Login Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Akses Sistem</h2>
            <p class="mt-2 text-gray-600">Silakan login sesuai dengan peran Anda</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Instruktur Login -->
            <div class="text-center p-6 border rounded-lg hover:shadow-lg transition duration-300">
                <i class="fas fa-chalkboard-teacher text-5xl text-green-600 mb-4"></i>
                <h3 class="text-xl font-semibold mb-2">Instruktur</h3>
                <p class="text-gray-600 mb-4">Akses untuk menilai dan mencatat hafalan siswa</p>
                <a href="<?= base_url('auth/login/instruktur') ?>" class="inline-block bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                    Login Instruktur
                </a>
            </div>
            <!-- Siswa Login -->
            <div class="text-center p-6 border rounded-lg hover:shadow-lg transition duration-300">
                <i class="fas fa-user-graduate text-5xl text-blue-600 mb-4"></i>
                <h3 class="text-xl font-semibold mb-2">Siswa</h3>
                <p class="text-gray-600 mb-4">Lihat nilai dan progress hafalan Anda</p>
                <a href="<?= base_url('auth/login/siswa') ?>" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Login Siswa
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Instructor Slider Section -->
<div class="bg-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Instruktur Kami</h2>
            <p class="mt-2 text-gray-600">Tim pengajar yang berpengalaman dalam bidang tahfizh</p>
        </div>
        <div class="swiper-container instructor-slider">
            <div class="swiper-wrapper">
                <!-- Sample Instructor Cards -->
                <?php for($i = 1; $i <= 5; $i++): ?>
                <div class="swiper-slide">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="https://source.unsplash.com/400x400/?portrait" alt="Instructor <?= $i ?>" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="font-semibold text-lg">Ustadz/ah Nama <?= $i ?></h3>
                            <p class="text-gray-600">Pengajar Tahfizh</p>
                        </div>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
            <div class="swiper-pagination mt-4"></div>
        </div>
    </div>
</div>

<!-- Student Achievement Section -->
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Prestasi Siswa</h2>
            <p class="mt-2 text-gray-600">Pencapaian hafalan Al-Quran siswa kami</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Achievement Cards -->
            <?php for($i = 1; $i <= 3; $i++): ?>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="https://source.unsplash.com/400x300/?student" alt="Student <?= $i ?>" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="font-semibold text-lg">Siswa <?= $i ?></h3>
                    <p class="text-gray-600">Hafal <?= rand(5, 30) ?> Juz</p>
                    <p class="mt-2 text-sm text-gray-500">
                        "Alhamdulillah, dengan sistem ini memudahkan dalam menghafal Al-Quran"
                    </p>
                </div>
            </div>
            <?php endfor; ?>
        </div>
    </div>
</div>
