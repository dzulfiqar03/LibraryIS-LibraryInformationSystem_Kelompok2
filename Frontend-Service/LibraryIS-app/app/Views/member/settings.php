<?= $this->extend('layouts/member') ?>

<?= $this->section('title') ?>Settings<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
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
                        class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-500"
                        checked
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
                        class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-500"
                        checked
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
                        class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-500"
                        checked
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
                        class="w-4 h-4 border-gray-300 rounded text-primary-600 focus:ring-primary-500"
                        checked
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
                <select id="books_per_page" class="input-field">
                    <option value="10">10 books</option>
                    <option value="20" selected>20 books</option>
                    <option value="50">50 books</option>
                    <option value="100">100 books</option>
                </select>
            </div>

            <!-- Default View -->
            <div class="pt-4 border-t border-gray-200">
                <label for="default_view" class="block font-medium text-gray-900 mb-2">Default Library View</label>
                <select id="default_view" class="input-field">
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
                <button onclick="alert('Are you sure? This action cannot be undone.')" class="btn-danger">
                    Delete
                </button>
            </div>
        </div>
    </div>

    <!-- Save Settings Button -->
    <div class="flex gap-3">
        <button class="btn-primary">
            Save Settings
        </button>
        <a href="<?= site_url('member/dashboard') ?>" class="btn-secondary">
            Cancel
        </a>
    </div>
</div>
<?= $this->endSection() ?>
