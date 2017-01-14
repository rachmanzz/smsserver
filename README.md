# smsserver
sms server dengan gammu  versi 1.33.0

instalasi :
pastikan configurasi gamu sudah benar ( gammurc, dan smsdrc ) database pakai native_mysql
inport mysql.sql ke database

lalu :
    composer update
    
configurasi file .env

lalu :

    php artisan migrate
    php artisan db:seed
    
jalankan gammu smsdrc 



