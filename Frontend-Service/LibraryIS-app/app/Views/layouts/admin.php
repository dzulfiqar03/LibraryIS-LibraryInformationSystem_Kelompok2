<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-gray-50" x-data="{ sidebarOpen: false }">
    <!-- Mobile Header -->
    <div class="lg:hidden bg-white shadow sticky top-0 z-40">
        <div class="px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-danger-600 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold text-sm">A</span>
                </div>
                <span class="font-display font-bold text-gray-900">LibraryIS Admin</span>
            </div>
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 hover:bg-gray-100 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </div>

    <div class="flex">
        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed lg:static inset-y-0 left-0 w-64 bg-white border-r border-gray-200 z-30 transition-transform duration-300 lg:translate-x-0">
            <!-- Logo -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-danger-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-display font-bold text-gray-900">LibraryIS</h2>
                        <p class="text-xs text-gray-500">Admin Portal</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="p-4 space-y-2">
                <a href="<?= site_url('admin/dashboard') ?>" class="nav-link <?= current_url(true)->getPath() === '/admin/dashboard' ? 'active' : '' ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l4-4m0 0l4 4m-4-4v4"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="<?= site_url('admin/books') ?>" class="nav-link <?= strpos(current_url(true)->getPath(), '/admin/books') === 0 ? 'active' : '' ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                    </svg>
                    <span>Book Management</span>
                </a>

                <hr class="my-4 border-gray-200">

                <a href="<?= site_url('member/dashboard') ?>" class="nav-link">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Member Portal</span>
                </a>

                <a href="<?= site_url('auth/logout') ?>" class="nav-link text-danger-600 hover:bg-danger-50 hover:text-danger-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Logout</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Top Bar -->
            <div class="bg-white border-b border-gray-200 sticky top-0 z-20">
                <div class="px-6 py-4 flex items-center justify-between">
                    <h1 class="text-xl font-bold text-gray-900"><?= $this->renderSection('title') ?? 'Page' ?></h1>
                    
                    <!-- User Menu -->
                    <div class="hidden md:flex items-center gap-4">
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900"><?= esc($user['name'] ?? 'Administrator') ?></p>
                            <p class="text-xs text-gray-500">Admin</p>
                        </div>
                        <button class="p-2 hover:bg-gray-100 rounded-lg">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="p-6">
                <!-- Flash Messages -->
                <?php if (session()->has('success')): ?>
                    <div class="mb-6 p-4 bg-success-50 border border-success-200 rounded-lg flex items-center gap-3">
                        <svg class="w-5 h-5 text-success-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-success-800"><?= session('success') ?></p>
                    </div>
                <?php endif; ?>

                <?php if (session()->has('error')): ?>
                    <div class="mb-6 p-4 bg-danger-50 border border-danger-200 rounded-lg flex items-center gap-3">
                        <svg class="w-5 h-5 text-danger-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-danger-800"><?= session('error') ?></p>
                    </div>
                <?php endif; ?>

                <?= $this->renderSection('page_content') ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
