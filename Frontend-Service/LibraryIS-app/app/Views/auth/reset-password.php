<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Reset Password<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary-50 to-secondary-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-primary-600 rounded-full mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-display font-bold text-gray-900">LibraryIS</h1>
            <p class="text-gray-600 mt-2">Digital Library Management System</p>
        </div>

        <!-- Reset Password Card -->
        <div class="card" x-data="{ loading: false, showPassword: false, showConfirmPassword: false }">
            <h2 class="text-2xl font-display font-bold text-gray-900 mb-2">Reset Password</h2>
            <p class="text-gray-600 text-sm mb-6">
                Enter your new password below.
            </p>

            <!-- Messages -->
            <?php if (session()->has('success')): ?>
                <div class="mb-4 p-4 bg-success-50 border border-success-200 rounded-lg flex gap-3">
                    <svg class="w-5 h-5 text-success-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="font-medium text-success-800"><?= session('success') ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (session()->has('error')): ?>
                <div class="mb-4 p-4 bg-danger-50 border border-danger-200 rounded-lg flex gap-3">
                    <svg class="w-5 h-5 text-danger-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="font-medium text-danger-800"><?= session('error') ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('auth/reset-password') ?>" method="POST" class="space-y-4" @submit="loading = true">
                <?= csrf_field() ?>

                <!-- Token (hidden) -->
                <input type="hidden" name="token" value="<?= $token ?? '' ?>">

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">New Password</label>
                    <div class="relative">
                        <input 
                            :type="showPassword ? 'text' : 'password'" 
                            id="password" 
                            name="password" 
                            class="input-field <?= session('errors.password') ? 'is-invalid' : '' ?>" 
                            placeholder="Enter new password"
                            required
                        >
                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                        >
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-4.803m5.596-3.856a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.6 17.6a8.973 8.973 0 001.5-2.5m2.5-4.1a10.05 10.05 0 01-1.5 2.5m-21.7-2.4a10.05 10.05 0 002.1-3.3m5.6-3.856a3.375 3.375 0 00-6.75 0"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l22 22"></path>
                            </svg>
                        </button>
                    </div>
                    <?php if (session('errors.password')): ?>
                        <p class="error-text"><?= session('errors.password') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Confirm Password Field -->
                <div>
                    <label for="password_confirm" class="block text-sm font-medium text-gray-700 mb-1.5">Confirm Password</label>
                    <div class="relative">
                        <input 
                            :type="showConfirmPassword ? 'text' : 'password'" 
                            id="password_confirm" 
                            name="password_confirm" 
                            class="input-field <?= session('errors.password_confirm') ? 'is-invalid' : '' ?>" 
                            placeholder="Confirm new password"
                            required
                        >
                        <button
                            type="button"
                            @click="showConfirmPassword = !showConfirmPassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                        >
                            <svg x-show="!showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg x-show="showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-4.803m5.596-3.856a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.6 17.6a8.973 8.973 0 001.5-2.5m2.5-4.1a10.05 10.05 0 01-1.5 2.5m-21.7-2.4a10.05 10.05 0 002.1-3.3m5.6-3.856a3.375 3.375 0 00-6.75 0"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l22 22"></path>
                            </svg>
                        </button>
                    </div>
                    <?php if (session('errors.password_confirm')): ?>
                        <p class="error-text"><?= session('errors.password_confirm') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    :disabled="loading"
                    class="btn-primary w-full"
                >
                    <span x-show="!loading">Reset Password</span>
                    <span x-show="loading" class="flex items-center justify-center gap-2">
                        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Resetting...
                    </span>
                </button>
            </form>

            <!-- Back to Login -->
            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Remember your password?
                    <a href="<?= site_url('auth/login') ?>" class="font-medium text-primary-600 hover:text-primary-700">
                        Sign in
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-sm text-gray-500">
            <p>Digital Library Management System &copy; 2025</p>
            <p class="mt-2">
                <a href="#" class="hover:text-gray-700">Privacy Policy</a>
                <span class="mx-1">•</span>
                <a href="#" class="hover:text-gray-700">Terms of Service</a>
            </p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
