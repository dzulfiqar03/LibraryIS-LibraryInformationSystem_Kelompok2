<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Forgot Password<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary-50 to-secondary-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-primary-600 rounded-full mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-display font-bold text-gray-900">LibraryIS</h1>
            <p class="text-gray-600 mt-2">Digital Library Management System</p>
        </div>

        <!-- Forgot Password Card -->
        <div class="card" x-data="{ loading: false }">
            <h2 class="text-2xl font-display font-bold text-gray-900 mb-2">Forgot Password?</h2>
            <p class="text-gray-600 text-sm mb-6">
                No problem. Just let us know your email address and we'll send you a link to reset your password.
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

            <form action="<?= site_url('auth/forgot-password') ?>" method="POST" class="space-y-4" @submit="loading = true">
                <?= csrf_field() ?>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="<?= old('email') ?>"
                        class="input-field <?= session('errors.email') ? 'is-invalid' : '' ?>" 
                        placeholder="your@email.com"
                        required
                    >
                    <?php if (session('errors.email')): ?>
                        <p class="error-text"><?= session('errors.email') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    :disabled="loading"
                    class="btn-primary w-full"
                >
                    <span x-show="!loading">Send Reset Link</span>
                    <span x-show="loading" class="flex items-center gap-2">
                        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Sending...
                    </span>
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">Or</span>
                </div>
            </div>

            <!-- Back to Login -->
            <div class="text-center space-y-3">
                <p class="text-gray-600">
                    Remember your password?
                    <a href="<?= site_url('auth/login') ?>" class="font-medium text-primary-600 hover:text-primary-700">
                        Sign in
                    </a>
                </p>
                <p class="text-gray-600">
                    Don't have an account?
                    <a href="<?= site_url('auth/register') ?>" class="font-medium text-primary-600 hover:text-primary-700">
                        Create one
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
