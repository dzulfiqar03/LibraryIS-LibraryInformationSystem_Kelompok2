#📚 **LibraryIS Backend Service – Microservices & GraphQL API**
Library Information System Backend built with Microservices Architecture & GraphQL Integration

🎉 Backend Overview
LibraryIS Backend dikembangkan menggunakan arsitektur microservices yang terpisah berdasarkan domain bisnis utama, serta didukung oleh GraphQL Integration Layer sebagai unified API gateway untuk frontend.

## 🖥️ Backend Services (Localhost)

Backend LibraryIS dibangun menggunakan arsitektur **microservices**, di mana setiap service berjalan pada alamat **localhost** yang berbeda dan memiliki tanggung jawab khusus sesuai domain bisnisnya.

---

### 1️⃣ Member Service (Localhost)

Member Service merupakan server yang bertanggung jawab untuk menangani seluruh data **identitas dan keanggotaan pengguna**. Layanan ini mengelola informasi anggota, status aktif, serta perhitungan denda yang dimiliki oleh setiap anggota perpustakaan.

Proses pengecekan denda dan status keanggotaan dilakukan pada service ini. Ketika frontend atau GraphQL memanggil fungsi **`fineMember`**, permintaan akan diarahkan ke alamat **localhost Member Service** untuk mengambil data langsung dari tabel anggota yang tersimpan di database.

**Tanggung jawab utama:**
- Autentikasi dan identitas anggota
- Penyimpanan data keanggotaan
- Perhitungan dan pengambilan data denda anggota
- Validasi status aktif atau tidak aktif anggota

**Contoh tabel terkait:**
- `tb_members`
- `tb_member_fines`

---

### 2️⃣ Book Service (Localhost)

Book Service merupakan server yang secara khusus menangani **pengelolaan inventaris buku**. Seluruh aktivitas yang berkaitan dengan data buku, seperti penambahan buku baru maupun pembaruan informasi buku, diproses melalui service ini.

Ketika fungsi **`createBook`** atau **`updateBook`** dipanggil melalui GraphQL, request akan diteruskan ke **localhost Book Service**. Server ini terhubung langsung dengan tabel detail buku untuk memastikan informasi seperti judul, penulis, ISBN, dan stok selalu akurat dan konsisten.

**Tanggung jawab utama:**
- Manajemen data buku (CRUD)
- Pengelolaan kategori buku
- Pemeliharaan stok dan ketersediaan buku
- Penyediaan data buku untuk layanan lain

**Contoh tabel terkait:**
- `tb_books`
- `tb_book_details`
- `tb_categories`

---

### 3️⃣ Transaction Service (Localhost)

Transaction Service merupakan pusat **logika bisnis peminjaman buku**. Service ini bertanggung jawab untuk mencatat setiap transaksi peminjaman dan pengembalian buku yang dilakukan oleh anggota.

Saat sebuah transaksi dibuat melalui fungsi **`createTransaction`**, server pada **localhost Transaction Service** akan menyimpan data transaksi ke tabel transaksi. Selain itu, service ini juga mengirimkan instruksi ke layanan lain melalui **Message Broker** untuk memperbarui stok buku serta status anggota secara otomatis, sehingga konsistensi data antar service tetap terjaga.

**Tanggung jawab utama:**
- Pencatatan transaksi peminjaman dan pengembalian
- Perhitungan jatuh tempo dan keterlambatan
- Pengelolaan status transaksi
- Koordinasi antar service melalui Message Broker

**Contoh tabel terkait:**
- `tb_transactions`
- `tb_transaction_details`
- `tb_fines`

---

### 🔗 Ringkasan Alur Komunikasi

Frontend
↓
GraphQL Integration
↓
┌───────────────┬────────────────┬──────────────────┐
│ Member Service│ Book Service │ Transaction Service│
│ (Keanggotaan) │ (Inventaris) │ (Peminjaman) │
└───────────────┴────────────────┴──────────────────┘

Setiap service berjalan secara independen di localhost dan saling berkomunikasi melalui GraphQL dan Message Broker untuk menjaga konsistensi data dan kelancaran proses bisnis sistem perpustakaan.

---

✅ Services Implemented
┌─────────────────────────────────────────────────────────────┐
│                                                             │
│  1️⃣  MEMBER SERVICE                                        │
│     ├─ User registration & authentication                  │
│     ├─ Role management (Admin / Librarian / Member)        │
│     ├─ Profile management                                  │
│     └─ JWT-based security                                  │
│                                                             │
│  2️⃣  BOOK SERVICE                                          │
│     ├─ Book CRUD                                            │
│     ├─ Book search & filter                                 │
│     ├─ Category management                                  │
│     ├─ Stock & availability                                 │
│     └─ Book detail endpoint                                 │
│                                                             │
│  3️⃣  TRANSACTION SERVICE                                   │
│     ├─ Borrow book                                          │
│     ├─ Return book                                          │
│     ├─ Borrowing history                                    │
│     ├─ Due date & overdue logic                              │
│     └─ Transaction validation                               │
│                                                             │
│  4️⃣  GRAPHQL INTEGRATION                                   │
│     ├─ Unified GraphQL endpoint                              │
│     ├─ Aggregation across services                           │
│     ├─ Single entry point for frontend                      │
│     └─ Schema-based API design                               │
│                                                             │
└─────────────────────────────────────────────────────────────┘

🏗️ Architecture Overview
Frontend (CodeIgniter 4)
        │
        ▼
 GraphQL Integration Layer
        │
 ┌──────┼─────────┬─────────┐
 │      │         │         │
 ▼      ▼         ▼         ▼
Member  Book   Transaction  (Future Services)
Service Service   Service
Benefits:
Loose coupling antar service
Mudah dikembangkan secara terpisah
Skalabel & maintainable
Frontend hanya berkomunikasi ke 1 endpoint (GraphQL)
📁 Project Structure
Backend-Service/
├── GraphQL-Integration/
│   ├── schema.graphql
│   ├── resolvers/
│   ├── datasources/
│   └── server.js / index.php
│
├── member-service/
│   ├── Controllers/
│   ├── Models/
│   ├── Routes/
│   └── Auth & Profile logic
│
├── book-service/
│   ├── Controllers/
│   ├── Models/
│   ├── Routes/
│   └── Book & Category logic
│
├── transaction-service/
│   ├── Controllers/
│   ├── Models/
│   ├── Routes/
│   └── Borrow & Return logic
│
└── README.md


🔧 Technology Stack
Backend Framework   : Laravel / Node.js (per service)
API Style           : REST (Internal) + GraphQL (Gateway)
Authentication      : JWT
Database            : MySQL / MariaDB
ORM                 : Eloquent / Sequelize
Architecture        : Microservices
Communication       : HTTP / JSON


🚀 Running the Backend

1️⃣ Install Dependencies (Each Service)
cd member-service
composer install
cd book-service
composer install
cd transaction-service
composer install
cd GraphQL-Integration
npm install

2️⃣ Environment Setup
Set .env di masing-masing service:
DB_DATABASE=libraryis_member
DB_USERNAME=root
DB_PASSWORD=
JWT_SECRET=your_secret_key

3️⃣ Run Services
php artisan serve --port=8001   # member-service
php artisan serve --port=8002   # book-service
php artisan serve --port=8003   # transaction-service
GraphQL:
npm run dev

GraphQL endpoint:
http://localhost:3000/graphql
📡 API Communication Flow
Frontend
   ↓
GraphQL Query / Mutation
   ↓
GraphQL Resolver
   ↓
REST Call to Microservice
   ↓
Service Response
   ↓
GraphQL Response to Frontend
🧾 Sample GraphQL Query
query {
  books {
    id
    title
    author
    available
  }
}

💾 Database Schema (ERD)
Sistem menggunakan relasi data yang terbagi menjadi dua kelompok besar:

1. Catalog & Inventory
tb_books              : Menyimpan judul buku.
tb_book_details       : Menyimpan detail teknis (ISBN, Penulis) dan stok (quantity).
2. Transaction & Fines
tb_transactions: Header transaksi peminjaman.
tb_transaction_details: Rincian buku yang dipinjam dan harga.
tb_fines_payments     : Catatan pembayaran denda anggota.

## 🌐 Service Endpoints (Local Development)

Untuk menjalankan sistem ini secara lokal, pastikan setiap service berjalan pada port berikut:

1. **Gateway**: [http://localhost:8000/graphql](http://localhost:8000/graphql) (Gunakan ini untuk testing di Postman/Altair)
2. **Member Service**: [http://localhost:8001/graphql](http://localhost:8001/graphql)
3. **Book Service**: [http://localhost:8002/graphql](http://localhost:8002/graphql)
4. **Transaction Service**: [http://localhost:8003/graphql](http://localhost:8003/graphql)

## 🚀 API Endpoints (GraphQL)

GraphQL digunakan sebagai **single entry point** untuk frontend. Seluruh query dan mutation akan diteruskan ke microservices terkait (`member-service`, `book-service`, `transaction-service`).

---

### A. Queries (Pengambilan Data)

| Service | Endpoint | Deskripsi |
|-------|---------|----------|
| Transaction | `transactions` | Mengambil seluruh riwayat transaksi peminjaman beserta status denda. |
| Transaction | `transaction(id: ID!)` | Mengambil detail satu transaksi berdasarkan ID. |
| Member | `fineMember(id: ID!)` | Mengecek total denda dan status aktif seorang anggota. |
| Transaction | `fines` | Mengambil daftar seluruh denda yang tercatat di sistem. |

---

### B. Mutations (Perubahan Data)

| Service | Endpoint | Input Utama | Deskripsi |
|-------|---------|------------|----------|
| Transaction | `createTransaction` | `CreateTransactionInput` | Membuat transaksi peminjaman buku baru dan memicu otomatisasi (stok, status, denda). |
| Book | `createBook` | `CreateBookInput` | Menambahkan judul buku baru beserta detail dan stok awal. |
| Book | `updateBook` | `CreateBookInput` | Memperbarui informasi buku atau jumlah stok yang tersedia. |

---


🔐 Authentication & Security
✅ JWT Authentication
✅ Role-based access control
✅ Service isolation
✅ Request validation
✅ Secure password hashing

📊 Service Responsibility
Service	Responsibility
member-service	Auth, users, roles, profiles
book-service	Books, categories, availability
transaction-service	Borrow, return, transactions
GraphQL-Integration	Aggregation & unified API
🔌 Frontend Integration
Frontend LibraryIS (CodeIgniter 4) hanya perlu mengakses:
POST /graphql
Semua logic backend sudah ditangani oleh GraphQL layer.

🛣️ Roadmap
Short Term
 Pagination GraphQL
 Centralized error handling
 Logging service
Mid Term
 Notification service
 Fine & penalty service
 Redis caching
Long Term
 API Gateway auth
 Service discovery
 Docker & Kubernetes

📜 License
Educational project – Library Information System.
🎉 Status
Backend Architecture: ✅ Microservices
GraphQL Integration: ✅ Implemented
Frontend Ready: ✅ Yes

Version: 1.0.0
Last Updated: January 2026
