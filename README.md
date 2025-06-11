# 📦 Laravel Project Clone Tutorial

Repositori ini berisi panduan sederhana untuk mengkloning dan menjalankan proyek Laravel secara lokal.

---

## 🚀 Langkah-langkah Clone dan Setup

Ikuti langkah-langkah berikut untuk menjalankan proyek Laravel ini di mesin lokal Anda.

### 1. Clone Repository
Buka terminal (bash, CMD, PowerShell)

untuk clone project
```bash
git clone https://github.com/Senadara/Collabora.git
```
setelah clone berhasil masuk kedalam directori
```bash
cd Collabora
```
setelah memasuki direktori Collabora buka IDE (VsCode)
```bash
code .
```
buka terminal pada vs code (ctrl+shift+`) lalu install composer
```bash
composer install
```
setelah composer terinstall tambahkan file .env lalu isi dengan kode berikut
```bash
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:zLVVGrvKTIDFcZGXGGltEVO+kGK/FXB3+5SLVLx2h0g=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=(ganti dengan db local mu)
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```
gunakan shortcut ctrl+shift+` lalu ketikan
```bash
php artisan migrate:fresh
```

setelah database sudah dibuat jalankan aplikasi
```bash
php artisan serve
```



