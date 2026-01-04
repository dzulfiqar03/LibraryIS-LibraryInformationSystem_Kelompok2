<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-gray-50" x-data="{ sidebarOpen: false }">
    <!-- Mobile Header -->
    <div class="lg:hidden bg-white shadow sticky top-0 z-40">
        <div class="px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-primary-600 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold text-sm">L</span>
                </div>
                <span class="font-display font-bold text-gray-900">LibraryIS</span>
            </div>
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 hover:bg-gray-100 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </div>

    <div class="flex min-h-screen bg-gray-50/50" x-data="{ sidebarOpen: false }">
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-40 lg:hidden">
    </div>

    <aside 
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed lg:static inset-y-0 left-0 w-72 bg-white border-r border-gray-200/60 z-50 transition-all duration-300 ease-in-out lg:translate-x-0 shadow-sm"
    >
        <div class="p-8">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 bg-gradient-to-tr from-primary-600 to-primary-500 rounded-xl flex items-center justify-center shadow-lg shadow-primary-200 ring-4 ring-primary-50">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="font-display font-extrabold text-xl tracking-tight text-gray-900 leading-none">Library<span class="text-primary-600">IS</span></h2>
                    <p class="text-[10px] uppercase tracking-widest font-bold text-gray-400 mt-1">Member Portal</p>
                </div>
            </div>
        </div>

        <nav class="px-4 py-2 space-y-1.5">
            <p class="px-4 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-4">Main Menu</p>
            
            <a href="<?= site_url('member/dashboard') ?>" 
               class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?= current_url(true)->getPath() === '/member/dashboard' ? 'bg-primary-50 text-primary-700 shadow-sm shadow-primary-100/50' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' ?>">
                <svg class="w-5 h-5 <?= current_url(true)->getPath() === '/member/dashboard' ? 'text-primary-600' : 'text-gray-400 group-hover:text-gray-600' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l4-4m0 0l4 4m-4-4v4"></path>
                </svg>
                <span class="font-semibold text-sm">Dashboard</span>
            </a>

            <a href="<?= site_url('member/books/search') ?>" 
               class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-gray-500 hover:bg-gray-50 hover:text-gray-900">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <span class="font-semibold text-sm">Search Books</span>
            </a>

            <a href="<?= site_url('member/borrowings') ?>" 
               class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-gray-500 hover:bg-gray-50 hover:text-gray-900">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                </svg>
                <span class="font-semibold text-sm">My Borrowings</span>
            </a>

            <a href="<?= site_url('fines-recommendations') ?>" 
               class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-gray-500 hover:bg-gray-50 hover:text-gray-900">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-semibold text-sm text-left">Denda & Rekomendasi</span>
            </a>

            <div class="pt-6 pb-2 px-4">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Account</p>
            </div>

            <a href="<?= site_url('member/profile') ?>" class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-gray-500 hover:bg-gray-50 hover:text-gray-900">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="font-semibold text-sm">Profile</span>
            </a>

            <a href="<?= site_url('auth/logout') ?>" class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-danger-500 hover:bg-danger-50">
                <svg class="w-5 h-5 text-danger-400 group-hover:text-danger-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span class="font-semibold text-sm">Logout</span>
            </a>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <header class="bg-white/80 backdrop-blur-md border-b border-gray-200/60 sticky top-0 z-40">
            <div class="px-4 lg:px-8 h-20 flex items-center justify-between">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>

                <div class="hidden md:flex items-center flex-1 max-w-xl pr-8">
                    <div class="relative w-full group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400 group-focus-within:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" placeholder="Search for books, authors, or ISBN..." 
                               class="block w-full pl-11 pr-4 py-2.5 bg-gray-100/50 border-transparent focus:bg-white focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 rounded-2xl text-sm transition-all duration-200">
                    </div>
                </div>

                <div class="flex items-center gap-2 lg:gap-5">
                    <button class="relative p-2.5 text-gray-500 hover:bg-gray-100 hover:text-primary-600 rounded-xl transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span class="absolute top-2.5 right-2.5 w-2.5 h-2.5 bg-danger-500 border-2 border-white rounded-full"></span>
                    </button>

                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" 
                                class="flex items-center gap-3 pl-1 pr-3 py-1 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-2xl transition-all duration-200">
                            <div class="w-9 h-9 bg-gradient-to-tr from-primary-600 to-indigo-600 rounded-xl flex items-center justify-center text-white shadow-md shadow-primary-200">
                                <span class="text-sm font-bold tracking-tighter">JD</span>
                            </div>
                            <div class="hidden lg:block text-left mr-1">
                                <p class="text-xs font-bold text-gray-900 leading-none">Jane Doe</p>
                                <p class="text-[10px] text-primary-600 font-bold mt-1 uppercase tracking-tighter">Premium Member</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             @click.outside="open = false"
                             class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 py-2.5 z-50 overflow-hidden"
                        >
                            <div class="px-4 py-2 border-b border-gray-50 mb-2">
                                <p class="text-xs text-gray-400 font-medium">Signed in as</p>
                                <p class="text-sm font-bold text-gray-800 truncate">jane.doe@example.com</p>
                            </div>
                            <a href="<?= site_url('member/profile') ?>" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-primary-50 hover:text-primary-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                My Profile
                            </a>
                            <a href="<?= site_url('member/settings') ?>" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-primary-50 hover:text-primary-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                                Account Settings
                            </a>
                            <div class="h-px bg-gray-50 my-2"></div>
                            <a href="<?= site_url('auth/logout') ?>" class="flex items-center gap-3 px-4 py-2.5 text-sm text-danger-600 hover:bg-danger-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Sign Out
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto overflow-x-hidden">
            <div class="max-w-[1600px] mx-auto p-6 lg:p-10">
                <?= $this->renderSection('page_content') ?>
            </div>
        </main>
    </div>
</div>
</div>

<style>
    .nav-link {
        @apply flex items-center gap-3 px-4 py-2.5 text-gray-700 rounded-lg transition-all duration-200 hover:bg-primary-50 hover:text-primary-600;
    }

    .nav-link.active {
        @apply bg-primary-100 text-primary-600 font-medium;
    }
</style>
<?= $this->endSection() ?>
