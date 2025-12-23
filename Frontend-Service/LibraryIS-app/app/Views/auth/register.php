<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Register<?= $this->endSection() ?>

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

        <!-- Register Card -->
        <div class="card" x-data="{ loading: false, showPassword: false, showConfirmPassword: false }">
            <h2 class="text-2xl font-display font-bold text-gray-900 mb-6">Create Account</h2>

            <!-- Messages -->
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

            <form action="<?= site_url('auth/register') ?>" method="POST" class="space-y-4" @submit="loading = true">
                <?= csrf_field() ?>

                <!-- Full Name Field -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Full Name</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="<?= old('name') ?>"
                        class="input-field <?= session('errors.name') ? 'is-invalid' : '' ?>" 
                        placeholder="John Doe"
                        required
                    >
                    <?php if (session('errors.name')): ?>
                        <p class="error-text"><?= session('errors.name') ?></p>
                    <?php endif; ?>
                </div>

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

                <!-- Phone Field -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1.5">Phone Number</label>
                    <input 
                        type="tel" 
                        id="phone" 
                        name="phone" 
                        value="<?= old('phone') ?>"
                        class="input-field <?= session('errors.phone') ? 'is-invalid' : '' ?>" 
                        placeholder="08123456789"
                    >
                    <?php if (session('errors.phone')): ?>
                        <p class="error-text"><?= session('errors.phone') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Address Field -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1.5">Address</label>
                    <textarea 
                        id="address" 
                        name="address" 
                        class="input-field resize-none <?= session('errors.address') ? 'is-invalid' : '' ?>" 
                        placeholder="Your home address"
                        rows="2"
                    ><?= old('address') ?></textarea>
                    <?php if (session('errors.address')): ?>
                        <p class="error-text"><?= session('errors.address') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <div class="relative">
                        <input 
                            :type="showPassword ? 'text' : 'password'" 
                            id="password" 
                            name="password" 
                            class="input-field w-full pr-10 <?= session('errors.password') ? 'is-invalid' : '' ?>" 
                            placeholder="At least 8 characters"
                            required
                        >
                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
                        >
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-4.803m5.596-3.856a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
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
                            class="input-field w-full pr-10 <?= session('errors.password_confirm') ? 'is-invalid' : '' ?>" 
                            placeholder="Confirm your password"
                            required
                        >
                        <button
                            type="button"
                            @click="showConfirmPassword = !showConfirmPassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
                        >
                            <svg x-show="!showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg x-show="showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-4.803m5.596-3.856a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </button>
                    </div>
                    <?php if (session('errors.password_confirm')): ?>
                        <p class="error-text"><?= session('errors.password_confirm') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Terms & Conditions -->
                <div class="flex items-start gap-2">
                    <input 
                        type="checkbox" 
                        id="terms" 
                        name="terms" 
                        class="mt-1 rounded border-gray-300 text-primary-600 focus:ring-primary-500"
                        required
                    >
                    <label for="terms" class="text-sm text-gray-600">
                        I agree to the
                        <a href="#" class="text-primary-600 hover:text-primary-700 font-medium">Terms of Service</a>
                        and
                        <a href="#" class="text-primary-600 hover:text-primary-700 font-medium">Privacy Policy</a>
                    </label>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    :disabled="loading"
                    class="btn-primary w-full"
                >
                    <span x-show="!loading">Create Account</span>
                    <span x-show="loading" class="flex items-center gap-2">
                        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Creating account...
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

            <!-- Login Link -->
            <p class="text-center text-gray-600">
                Already have an account?
                <a href="<?= site_url('auth/login') ?>" class="font-medium text-primary-600 hover:text-primary-700">
                    Sign in
                </a>
            </p>
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
