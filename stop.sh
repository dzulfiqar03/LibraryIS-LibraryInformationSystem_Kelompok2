
#!/bin/bash

#mematikan semua layanan ketika script dihentikan
trap "pkill -f 'php artisan serve'; pkill -f 'php artisan queue:work'; pkill -f 'php spark serve'" EXIT

echo "--- Menghentikan Container RabbitMQ ---"
# Berhenti berdasarkan nama
docker stop rabbitmq

echo "--- Semua layanan telah dihentikan ---"
exit 0