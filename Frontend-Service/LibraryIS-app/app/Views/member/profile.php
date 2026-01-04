<?= $this->extend('layouts/member') ?>

<?= $this->section('title') ?>My Profile<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-display font-bold text-gray-900">My Profile</h1>
    <p class="text-gray-600 mt-1">Manage your personal information and preferences</p>
</div>

<!-- Tabs -->
<div class="flex gap-4 mb-6 border-b border-gray-200">
    <button class="px-4 py-3 border-b-2 border-primary-600 text-primary-600 font-medium">
        Personal Info
    </button>
    <button class="px-4 py-3 border-b-2 border-transparent text-gray-600 hover:text-gray-900 font-medium">
        Change Password
    </button>
    <button class="px-4 py-3 border-b-2 border-transparent text-gray-600 hover:text-gray-900 font-medium">
        Preferences
    </button>
</div>

<!-- Personal Information Form -->
<div class="max-w-2xl">
    <div class="card">
        <!-- Success Message -->
        <?php if (session()->has('success')): ?>
            <div class="mb-6 p-4 bg-success-50 border border-success-200 rounded-lg flex gap-3">
                <svg class="w-5 h-5 text-success-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <p class="font-medium text-success-800"><?= session('success') ?></p>
                </div>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('member/profile') ?>" method="POST" x-data="{ loading: false }" @submit="loading = true" class="space-y-6">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">

            <!-- Full Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Full Name</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="<?= old('name') ?? ($user['name'] ?? '') ?>"
                    class="input-field w-full <?= session('errors.name') ? 'is-invalid' : '' ?>" 
                    required
                >
                <?php if (session('errors.name')): ?>
                    <p class="error-text"><?= session('errors.name') ?></p>
                <?php endif; ?>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email Address</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="<?= old('email') ?? ($user['email'] ?? '') ?>"
                    class="input-field w-full <?= session('errors.email') ? 'is-invalid' : '' ?>" 
                    required
                >
                <?php if (session('errors.email')): ?>
                    <p class="error-text"><?= session('errors.email') ?></p>
                <?php endif; ?>
                <p class="text-xs text-gray-500 mt-1">Your email is used for account recovery</p>
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1.5">Phone Number</label>
                <input 
                    type="tel" 
                    id="phone" 
                    name="phone" 
                    value="<?= old('phone') ?? ($user['phone'] ?? '') ?>"
                    class="input-field w-full <?= session('errors.phone') ? 'is-invalid' : '' ?>" 
                >
                <?php if (session('errors.phone')): ?>
                    <p class="error-text"><?= session('errors.phone') ?></p>
                <?php endif; ?>
            </div>

            <!-- Address -->
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1.5">Address</label>
                <textarea 
                    id="address" 
                    name="address" 
                    rows="3"
                    class="input-field w-full <?= session('errors.address') ? 'is-invalid' : '' ?>" 
                ><?= old('address') ?? ($user['address'] ?? '') ?></textarea>
                <?php if (session('errors.address')): ?>
                    <p class="error-text"><?= session('errors.address') ?></p>
                <?php endif; ?>
            </div>

            <!-- Member ID (Read-only) -->
            <div>
                <label for="member_id" class="block text-sm font-medium text-gray-700 mb-1.5">Member ID</label>
                <input 
                    type="text" 
                    id="member_id" 
                    value="<?= $user['id'] ?? 'N/A' ?>"
                    class="input-field w-full bg-gray-100" 
                    disabled
                >
            </div>

            <!-- Submit Button -->
            <div class="flex gap-3 pt-6 border-t border-gray-200">
                <button 
                    type="submit" 
                    :disabled="loading"
                    class="btn-primary"
                >
                    <span x-show="!loading">Save Changes</span>
                    <span x-show="loading" class="flex items-center gap-2">
                        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Saving...
                    </span>
                </button>
                <a href="<?= site_url('member/dashboard') ?>" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
