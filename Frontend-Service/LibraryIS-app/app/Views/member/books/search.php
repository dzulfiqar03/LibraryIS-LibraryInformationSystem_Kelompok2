<?= $this->extend('layouts/member') ?>

<?= $this->section('title') ?>Search Books<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<div x-data="bookSearch()" x-init="loadBooks()">
    <div class="mb-10">
        <h1 class="text-4xl font-display font-extrabold text-gray-900 tracking-tight">Cari Koleksi Buku</h1>
        <p class="text-gray-500 mt-2 text-lg">Temukan literatur terbaik dari ribuan koleksi perpustakaan kami.</p>
    </div>

    <div class="mb-10">
        <div class="bg-white rounded-3xl shadow-xl shadow-gray-100 border border-gray-100 p-8">
            <form @submit.prevent="searchBooks()" class="space-y-6">
                <div class="relative group">
                    <input 
                        type="text" 
                        x-model="searchQuery" 
                        @keyup.enter="searchBooks()"
                        placeholder="Masukkan judul buku, nama penulis, atau kata kunci..." 
                        class="w-full pl-14 pr-4 py-4 bg-gray-50 border-transparent focus:bg-white focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 rounded-2xl text-lg transition-all duration-300"
                    >
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <svg class="w-6 h-6 text-gray-400 group-focus-within:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Kategori</label>
                        <select x-model="selectedCategory" @change="searchBooks()" class="w-full px-4 py-3 bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-primary-500/20 rounded-xl text-sm font-semibold transition-all">
                            <option value="">Semua Kategori</option>
                            <option value="fiction">Fiction</option>
                            <option value="non-fiction">Non-Fiction</option>
                            <option value="mystery">Mystery</option>
                            <option value="science">Science</option>
                            <option value="history">History</option>
                            <option value="biography">Biography</option>
                        </select>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Ketersediaan</label>
                        <select x-model="availabilityFilter" @change="searchBooks()" class="w-full px-4 py-3 bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-primary-500/20 rounded-xl text-sm font-semibold transition-all">
                            <option value="">Semua Status</option>
                            <option value="available">Hanya Tersedia</option>
                            <option value="borrowed">Sedang Dipinjam</option>
                        </select>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Urutkan</label>
                        <select x-model="sortBy" @change="searchBooks()" class="w-full px-4 py-3 bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-primary-500/20 rounded-xl text-sm font-semibold transition-all">
                            <option value="title">Judul (A-Z)</option>
                            <option value="author">Penulis</option>
                            <option value="year">Tahun Terbit</option>
                            <option value="popularity">Paling Populer</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="px-8 py-3.5 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl shadow-lg shadow-primary-200 transition-all flex items-center gap-2" :disabled="loading">
                        <template x-if="!loading">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                Terapkan Pencarian
                            </span>
                        </template>
                        <template x-if="loading">
                            <span class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Mencari...
                            </span>
                        </template>
                    </button>
                    <button type="button" @click="clearFilters()" class="px-6 py-3.5 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold rounded-xl transition-all">
                        Reset Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="relative">
        <div x-show="!loading && books.length > 0" class="flex items-center justify-between mb-8 px-2">
            <h3 class="text-gray-500 font-medium">Ditemukan <span class="text-gray-900 font-bold" x-text="totalResults"></span> koleksi buku</h3>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <template x-for="book in books" :key="book.id">
                <div 
                    @click="viewBook(book.id)"
                    class="group bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 overflow-hidden cursor-pointer"
                >
                    <div class="relative aspect-[3/4] overflow-hidden bg-gray-100">
                        <template x-if="book.url_cover">
                            <img :src="book.url_cover" :alt="book.title" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        </template>
                        <template x-if="!book.url_cover">
                            <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-gray-50 to-gray-200">
                                <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path></svg>
                                <span class="text-[10px] uppercase font-bold text-gray-400 mt-2 tracking-widest">No Cover</span>
                            </div>
                        </template>
                        
                        <div class="absolute top-4 right-4">
                            <span 
                                :class="book.quantity > 0 ? 'bg-emerald-500' : 'bg-rose-500'" 
                                class="px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest text-white shadow-lg shadow-black/10"
                                x-text="book.quantity > 0 ? 'Tersedia' : 'Kosong'"
                            ></span>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="mb-4">
                            <p class="text-[10px] font-black uppercase tracking-tighter text-primary-600 mb-1" x-text="book.category"></p>
                            <h4 class="text-gray-900 font-display font-bold text-lg leading-tight line-clamp-2 h-14 group-hover:text-primary-600 transition-colors" x-text="book.title"></h4>
                            <p class="text-gray-500 text-sm mt-2 font-medium" x-text="book.author"></p>
                        </div>

                        <div class="flex items-center gap-2 pt-2 border-t border-gray-50">
                            <button 
                                @click.stop="book.quantity > 0 ? borrowBook(book.id) : reserveBook(book.id)" 
                                :class="book.quantity > 0 ? 'bg-primary-600 hover:bg-primary-700 text-white' : 'bg-gray-900 hover:bg-gray-800 text-white'"
                                class="flex-1 py-3 rounded-xl font-bold text-xs transition-all active:scale-95"
                                x-text="book.quantity > 0 ? 'Pinjam Sekarang' : 'Reservasi'"
                            ></button>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <div x-show="!loading && books.length === 0" class="flex flex-col items-center justify-center py-20 px-4">
            <div class="w-32 h-32 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-1">Buku tidak ditemukan</h3>
            <p class="text-gray-500 text-center max-w-xs">Kami tidak dapat menemukan hasil untuk kata kunci tersebut. Coba cari dengan istilah lain.</p>
            <button @click="clearFilters()" class="mt-6 text-primary-600 font-bold hover:underline">Lihat Semua Koleksi</button>
        </div>

        <div x-show="loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <template x-for="i in 8" :key="i">
                <div class="animate-pulse bg-white rounded-3xl p-4 border border-gray-100">
                    <div class="bg-gray-200 aspect-[3/4] rounded-2xl mb-4"></div>
                    <div class="h-4 bg-gray-200 rounded w-1/3 mb-4"></div>
                    <div class="h-6 bg-gray-200 rounded w-full mb-2"></div>
                    <div class="h-6 bg-gray-200 rounded w-2/3"></div>
                </div>
            </template>
        </div>
    </div>
</div>

<script>
function bookSearch() {
    return {
        books: [],
        totalResults: 0,
        loading: false,
        error: null,
        searchQuery: '',
        selectedCategory: '',
        availabilityFilter: '',
        sortBy: 'title',
        currentPage: 1,
        totalPages: 1,

        async loadBooks() {
            this.loading = true;
            try {
                const token = <?= json_encode(session()->get('jwt_token') ?? '') ?>;
                const params = new URLSearchParams({
                    page: this.currentPage,
                    search: this.searchQuery,
                    category: this.selectedCategory,
                    availability: this.availabilityFilter,
                    sort: this.sortBy
                });

                const response = await fetch(`<?= site_url('api/books') ?>?${params}`, {
                    headers: { 
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                const res = await response.json();
                if (res.success) {
                    this.books = res.data || res.books;
                    this.totalResults = res.pagination?.total_items || this.books.length;
                    this.totalPages = res.pagination?.total_pages || 1;
                }
            } catch (e) {
                console.error("Search failed", e);
            } finally {
                this.loading = false;
            }
        },

        searchBooks() {
            this.currentPage = 1;
            this.loadBooks();
        },

        clearFilters() {
            this.searchQuery = '';
            this.selectedCategory = '';
            this.availabilityFilter = '';
            this.sortBy = 'title';
            this.loadBooks();
        },

        viewBook(id) {
            // Mengarah ke detail screen (Pastikan route ini ada di CI4)
            window.location.href = `<?= site_url('member/books/detail') ?>/${id}`;
        },

        async borrowBook(id) {
            // Logic API pinjam
            alert('Proses meminjam buku ID: ' + id);
        },

        async reserveBook(id) {
            // Logic API reservasi
            alert('Proses reservasi buku ID: ' + id);
        }
    }
}
</script>
<?= $this->endSection() ?>