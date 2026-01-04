<?= $this->extend('layouts/member') ?>

<?= $this->section('title') ?>Settings<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<div x-data="settingsManager()">
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-display font-bold text-gray-900">Settings</h1>
    <p class="text-gray-600 mt-1">Manage your account preferences and notifications</p>
</div>

<!-- Settings Grid -->
<div class="max-w-4xl space-y-6">
    <!-- Notification Preferences -->
    <div class="card">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Notification Preferences</h2>
        
        <div class="space-y-4">
            <!-- Email Notifications -->
            <div class="flex items-start gap-4">
                <div class="pt-1">
                    <input 
                        type="checkbox" 
                        id="email_notifications" 
                        x-model="settings.email_notifications"
                        class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-500"
                    >
                </div>
                <div class="flex-1">
                    <label for="email_notifications" class="block font-medium text-gray-900">Email Notifications</label>
                    <p class="text-sm text-gray-600">Receive emails about your borrowed books and due dates</p>
                </div>
            </div>

            <!-- Reminder Notifications -->
            <div class="flex items-start gap-4 pt-4 border-t border-gray-200">
                <div class="pt-1">
                    <input 
                        type="checkbox" 
                        id="reminder_notifications" 
                        x-model="settings.reminder_notifications"
                        class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-500"
                    >
                </div>
                <div class="flex-1">
                    <label for="reminder_notifications" class="block font-medium text-gray-900">Due Date Reminders</label>
                    <p class="text-sm text-gray-600">Get notified 3 days before a book is due</p>
                </div>
            </div>

            <!-- New Books Notification -->
            <div class="flex items-start gap-4 pt-4 border-t border-gray-200">
                <div class="pt-1">
                    <input 
                        type="checkbox" 
                        id="new_books_notifications" 
                        x-model="settings.new_books_notifications"
                        class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-500"
                    >
                </div>
                <div class="flex-1">
                    <label for="new_books_notifications" class="block font-medium text-gray-900">New Books Alert</label>
                    <p class="text-sm text-gray-600">Be informed about newly added books in your favorite categories</p>
                </div>
            </div>

            <!-- Newsletter -->
            <div class="flex items-start gap-4 pt-4 border-t border-gray-200">
                <div class="pt-1">
                    <input 
                        type="checkbox" 
                        id="newsletter" 
                        x-model="settings.newsletter"
                        class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-500"
                    >
                </div>
                <div class="flex-1">
                    <label for="newsletter" class="block font-medium text-gray-900">Weekly Newsletter</label>
                    <p class="text-sm text-gray-600">Get our weekly digest of trending books and library updates</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Privacy Settings -->
    <div class="card">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Privacy Settings</h2>
        
        <div class="space-y-4">
            <!-- Public Profile -->
            <div class="flex items-start gap-4">
                <div class="pt-1">
                    <input 
                        type="checkbox" 
                        id="public_profile" 
                        x-model="settings.public_profile"
                        class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-500"
                    >
                </div>
                <div class="flex-1">
                    <label for="public_profile" class="block font-medium text-gray-900">Public Profile</label>
                    <p class="text-sm text-gray-600">Allow other members to see your reading activity and recommendations</p>
                </div>
            </div>

            <!-- Show Reading History -->
            <div class="flex items-start gap-4 pt-4 border-t border-gray-200">
                <div class="pt-1">
                    <input 
                        type="checkbox" 
                        id="show_history" 
                        x-model="settings.show_history"
                        class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-500"
                    >
                </div>
                <div class="flex-1">
                    <label for="show_history" class="block font-medium text-gray-900">Show Reading History</label>
                    <p class="text-sm text-gray-600">Display your borrowing and reading history on your public profile</p>
                </div>
            </div>

            <!-- Allow Messages -->
            <div class="flex items-start gap-4 pt-4 border-t border-gray-200">
                <div class="pt-1">
                    <input 
                        type="checkbox" 
                        id="allow_messages" 
                        x-model="settings.allow_messages"
                        class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-500"
                    >
                </div>
                <div class="flex-1">
                    <label for="allow_messages" class="block font-medium text-gray-900">Allow Messages</label>
                    <p class="text-sm text-gray-600">Let other members send you book recommendations and messages</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Display Preferences -->
    <div class="card">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Display Preferences</h2>
        
        <div class="space-y-4">
            <!-- Dark Mode -->
            <div class="flex items-start gap-4">
                <div class="pt-1">
                    <input 
                        type="checkbox" 
                        id="dark_mode" 
                        x-model="settings.dark_mode"
                        class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-500"
                    >
                </div>
                <div class="flex-1">
                    <label for="dark_mode" class="block font-medium text-gray-900">Dark Mode</label>
                    <p class="text-sm text-gray-600">Use dark theme for the interface</p>
                </div>
            </div>

            <!-- Books per Page -->
            <div class="pt-4 border-t border-gray-200">
                <label for="books_per_page" class="block font-medium text-gray-900 mb-2">Books Per Page</label>
                <select id="books_per_page" x-model="settings.books_per_page" class="input-field">
                    <option value="10">10 books</option>
                    <option value="20" selected>20 books</option>
                    <option value="50">50 books</option>
                    <option value="100">100 books</option>
                </select>
            </div>

            <!-- Default View -->
            <div class="pt-4 border-t border-gray-200">
                <label for="default_view" class="block font-medium text-gray-900 mb-2">Default Library View</label>
                <select id="default_view" x-model="settings.default_view" class="input-field">
                    <option value="grid" selected>Grid View</option>
                    <option value="list">List View</option>
                    <option value="table">Table View</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Danger Zone -->
    <div class="card border-danger-200 bg-danger-50">
        <h2 class="text-xl font-bold text-danger-600 mb-4">Danger Zone</h2>
        
        <div class="space-y-4">
            <!-- Change Password Button -->
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-medium text-gray-900">Change Password</p>
                    <p class="text-sm text-gray-600">Update your account password</p>
                </div>
                <a href="<?= site_url('member/settings/change-password') ?>" class="btn-outline">
                    Change
                </a>
            </div>

            <!-- Delete Account -->
            <div class="flex items-center justify-between pt-4 border-t border-danger-200">
                <div>
                    <p class="font-medium text-danger-600">Delete Account</p>
                    <p class="text-sm text-gray-600">Permanently delete your account and all data</p>
                </div>
                <button @click="deleteAccount()" :disabled="loading" class="btn-danger">
                    <span x-text="loading ? 'Deleting...' : 'Delete'"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Save Settings Button -->
    <div class="flex gap-3">
        <button @click="saveSettings()" :disabled="loading" class="btn-primary">
            <span x-text="loading ? 'Saving...' : 'Save Settings'"></span>
        </button>
        <a href="<?= site_url('member/dashboard') ?>" class="btn-secondary">
            Cancel
        </a>
    </div>
</div>

<script>
function settingsManager() {
    return {
        loading: false,
        settings: {
            email_notifications: true,
            reminder_notifications: true,
            new_books_notifications: false,
            newsletter: false,
            public_profile: true,
            show_history: false,
            allow_messages: true,
            dark_mode: false,
            books_per_page: '20',
            default_view: 'grid'
        },

        async saveSettings() {
            this.loading = true;
            try {
                const response = await fetch('<?= site_url('api/settings/update') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(this.settings),
                    credentials: 'include'
                });

                const data = await response.json();
                if (data.success) {
                    alert('Settings saved successfully!');
                } else {
                    alert(data.message || 'Failed to save settings.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while saving settings.');
            } finally {
                this.loading = false;
            }
        },

        async deleteAccount() {
            const password = prompt('Enter your password to confirm account deletion:');
            if (!password) return;

            if (!confirm('Are you absolutely sure? This action CANNOT be undone. All your data will be permanently deleted.')) {
                return;
            }

            this.loading = true;
            try {
                const response = await fetch('<?= site_url('api/account/delete') ?>', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ password: password }),
                    credentials: 'include'
                });

                const data = await response.json();
                if (data.success) {
                    alert('Account deleted successfully. You will be logged out.');
                    setTimeout(() => {
                        window.location.href = '<?= site_url('auth/logout') ?>';
                    }, 1000);
                } else {
                    alert(data.message || 'Failed to delete account. Please try again.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while deleting account.');
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
</div>
<?= $this->endSection() ?>
