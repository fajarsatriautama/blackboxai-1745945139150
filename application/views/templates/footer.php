</main>

    <!-- Footer -->
    <footer class="bg-white shadow-inner mt-8">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- About Section -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Rapor Tahfizh</h3>
                    <p class="text-gray-600">
                        Sistem informasi manajemen penilaian dan pencatatan hafalan Al-Quran untuk memudahkan proses evaluasi dan monitoring perkembangan siswa.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Menu Cepat</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="<?= base_url() ?>" class="text-gray-600 hover:text-gray-900">Beranda</a>
                        </li>
                        <li>
                            <a href="<?= base_url('home/login') ?>" class="text-gray-600 hover:text-gray-900">Login</a>
                        </li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Kontak</h3>
                    <ul class="space-y-2">
                        <li class="flex items-center text-gray-600">
                            <i class="fas fa-map-marker-alt w-5"></i>
                            <span>Jl. Pendidikan No. 123</span>
                        </li>
                        <li class="flex items-center text-gray-600">
                            <i class="fas fa-phone w-5"></i>
                            <span>+62 123 4567 890</span>
                        </li>
                        <li class="flex items-center text-gray-600">
                            <i class="fas fa-envelope w-5"></i>
                            <span>info@raportahfizh.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="mt-8 pt-8 border-t border-gray-200">
                <p class="text-center text-gray-500">
                    &copy; <?= date('Y') ?> Rapor Tahfizh. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        // Initialize Swiper sliders
        const mainSwiper = new Swiper('.main-slider', {
            loop: true,
            autoplay: {
                delay: 5000,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });

        const instructorSwiper = new Swiper('.instructor-slider', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 3000,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 4,
                },
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    </script>
</body>
</html>
