<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Rapor Tahfizh' ?></title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Swiper CSS for sliders -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .swiper-container {
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="<?= base_url() ?>" class="text-xl font-bold text-gray-800">
                            Rapor Tahfizh
                        </a>
                    </div>
                </div>
                <div class="flex items-center">
                    <?php if(!$this->session->userdata('logged_in')): ?>
                        <a href="<?= base_url('home/login') ?>" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                            Login
                        </a>
                    <?php else: ?>
                        <div class="ml-3 relative">
                            <div class="flex items-center">
                                <span class="mr-3 text-gray-700">
                                    <?= $this->session->userdata('nama_lengkap') ?>
                                </span>
                                <a href="<?= base_url('auth/logout') ?>" class="text-red-600 hover:text-red-700">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-8">
