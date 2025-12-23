
#!/bin/bash

#mematikan semua layanan ketika script dihentikan
trap "pkill -f 'php artisan serve'; pkill -f 'php artisan queue:work'; pkill -f 'php spark serve'" EXIT

echo "--- Menghentikan Container RabbitMQ ---"
# Berhenti berdasarkan nama
docker stop rabbitmq

<<<<<<< HEAD
echo "--- Semua layanan telah dihentikan ---"
exit 0
=======
echo "--- Semua layanan telah dihentikan ---"
>>>>>>> 0f9422a8cbd64cb9551f2932ca7fdf1e6094cffc
