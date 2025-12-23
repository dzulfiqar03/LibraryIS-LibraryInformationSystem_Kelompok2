#!/bin/bash

# 1. Ambil waktu sekarang (Format: 2025-12-23 14:45:00)
current_time=$(date "+%Y-%m-%d %H:%M:%S")

jq ".last_updated = \"$current_time\"" config.json > temp.json && mv temp.json config.json

echo "Log: File config.json telah diperbarui pada $current_time"

# Navigasi ke direktori proyek

# Mendefinisikan list service dengan format "Nama|Path|Port"
services=(
    "GraphQL-Integration|Backend-Service/GraphQL-Integration/|8000"
    "User-Service|Backend-Service/member-service/|8001"
    "Book-Service|Backend-Service/book-service/|8002"
    "Transaction-Service|Backend-Service/transaction-service/|8003"
)

for service in "${services[@]}"; do
    # Memecah string berdasarkan karakter "|"
    IFS="|" read -r name path port <<< "$service"

    echo "Menjalankan $name di port $port..."
    
    # Menjalankan command di background
    (cd "$path" && php artisan serve --port="$port") &
done

echo "--- 1. Memulai Container RabbitMQ ---"
# Cek apakah container sudah ada, jika belum buat baru
if [ ! "$(docker ps -q -f name=rabbitmq)" ]; then
    if [ "$(docker ps -aq -f status=exited -f name=rabbitmq)" ]; then
        docker start rabbitmq
    else
        docker run -d --name rabbitmq -p 5672:5672 -p 15672:15672 rabbitmq:3-management
    fi
fi

echo "Menunggu RabbitMQ siap (5 detik)..."
sleep 5
echo "--- RabbitMQ siap ---"


# --- KONFIGURASI WORKER ---
# Format: "Nama_Worker|Path_Project|Command_Exec"
workers=(
    # Job Service - Transaction Queue
    "Transaction-Worker-1|Backend-Service/transaction-service/|php artisan queue:work --queue=transaction.book"
    "Transaction-Worker-2|Backend-Service/transaction-service/|php artisan queue:work --queue=snapshot.book"
    
    # Consumer Service
    "Book-Update-Consumer|Backend-Service/book-service/|php artisan queue:work --queue=book.update"
    "Snapshot-Update-Consumer|Backend-Service/transaction-service/|php artisan queue:work --queue=snapshot.book.update"
)

echo "---------------------------------------------------"
echo " Menjalankan RabbitMQ Workers (Laravel Queue)      "
echo "---------------------------------------------------"

for item in "${workers[@]}"; do
    IFS="|" read -r name path exec <<< "$item"
    
    echo "[STARTING] $name..."

    (cd "$path" && $exec) > /dev/null 2>&1 &
    
    echo "[OK] $name sedang berjalan di background."
done

echo "---------------------------------------------------"
echo "Semua worker aktif. Gunakan 'pkill -f queue:work' untuk stop."
echo "---------------------------------------------------" 


# Jalankan Project Frontend Service
(cd Frontend-Service/LibraryIS-app && php spark serve) > /dev/null 2>&1 &

echo "Menjalankan Frontend Service di http://localhost:8080 ..."
# Selesai menjalankan semua layanan
echo "Semua layanan telah dijalankan."

echo "---------------------------------------------------"
echo " SELAMAT DATANG DI LIBRARYIS SYSTEM "
echo "1. Tekan 1 untuk menghentikan semua layanan"
echo "2. Tekan 2 untuk Push perubahan ke repository git"
echo "---------------------------------------------------"

# Pilih untuk menghentikan layanan
input="Masukkan pilihan Anda: "
echo $input
read -r input
# gateway to read
if [ "$input" = 1 ]; then
    sh ./stop.sh
elif [ "$input" = 2 ]; then
    sh ./git_exec.sh
else
    echo "Pilihan tidak valid. Keluar dari script."
    sh ./stop.sh
    exit 1
fi

echo "Menghentikan semua layanan..."

# Tunggu hingga semua proses selesai
wait



