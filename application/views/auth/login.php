<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Login <?= ucfirst($role) ?>
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Silakan masuk dengan akun Anda
            </p>
        </div>

        <!-- Flash Message -->
        <?php if($this->session->flashdata('message')): ?>
            <?= $this->session->flashdata('message') ?>
        <?php endif; ?>

        <!-- Validation Errors -->
        <?php if(validation_errors()): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <?= validation_errors() ?>
            </div>
        <?php endif; ?>

        <form class="mt-8 space-y-6" action="<?= base_url('auth/login/'.$role) ?>" method="POST">
            <input type="hidden" name="role" value="<?= $role ?>">
            
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="username" class="sr-only">Username</label>
                    <input id="username" name="username" type="text" required 
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm" 
                        placeholder="Username">
                </div>
                <div>
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" name="password" type="password" required 
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm" 
                        placeholder="Password">
                </div>
            </div>

            <div>
                <button type="submit" 
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-sign-in-alt"></i>
                    </span>
                    Login
                </button>
            </div>

            <div class="flex items-center justify-center">
                <div class="text-sm">
                    <a href="<?= base_url() ?>" class="font-medium text-green-600 hover:text-green-500">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </form>

        <!-- Role Selection -->
        <div class="mt-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-gray-50 text-gray-500">
                        Login sebagai
                    </span>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-3 gap-3">
                <a href="<?= base_url('auth/login/admin') ?>" 
                    class="<?= $role == 'admin' ? 'bg-green-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' ?> w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Admin
                </a>
                <a href="<?= base_url('auth/login/instruktur') ?>" 
                    class="<?= $role == 'instruktur' ? 'bg-green-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' ?> w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Instruktur
                </a>
                <a href="<?= base_url('auth/login/siswa') ?>" 
                    class="<?= $role == 'siswa' ? 'bg-green-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' ?> w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Siswa
                </a>
            </div>
        </div>
    </div>
</div>
