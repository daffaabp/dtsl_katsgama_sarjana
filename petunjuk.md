# Panduan Deployment Aplikasi Sarjana menggunakan Docker

## Daftar Isi
- [Persyaratan Sistem](#persyaratan-sistem)
- [Struktur Project](#struktur-project)
- [Langkah-langkah Deployment](#langkah-langkah-deployment)
- [Konfigurasi Environment](#konfigurasi-environment)
- [Perintah Docker](#perintah-docker)
- [Monitoring](#monitoring)
- [Troubleshooting](#troubleshooting)

## Persyaratan Sistem

Sebelum melakukan deployment, pastikan server memenuhi persyaratan berikut:

1. Sistem Operasi:
   - Linux (Direkomendasikan: Ubuntu 20.04 LTS atau lebih baru)
   - Minimal RAM: 4GB
   - Minimal CPU: 2 Core

2. Software yang harus terinstall:
   - Docker Engine (versi 20.10.0 atau lebih baru)
   - Docker Compose (versi 2.0.0 atau lebih baru)
   - Git

## Struktur Project

```
sarjana/
├── docker/
│   ├── mysql/
│   │   └── my.cnf
│   ├── nginx/
│   │   └── conf.d/
│   │       └── app.conf
│   └── php/
│       └── local.ini
├── docker-compose.yml
├── Dockerfile
└── ...
```

## Langkah-langkah Deployment

### 1. Persiapan Server

```bash
# Update sistem
sudo apt-get update
sudo apt-get upgrade -y

# Install Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh

# Install Docker Compose
sudo curl -L "https://github.com/docker/compose/releases/download/v2.23.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose

# Tambahkan user ke group docker
sudo usermod -aG docker $USER
```

### 2. Clone Repository

```bash
# Clone repository
git clone [URL_REPOSITORY] sarjana
cd sarjana
```

### 3. Konfigurasi Environment

1. Sesuaikan konfigurasi database di `docker-compose.yml`:
```yaml
MYSQL_DATABASE: katsgamaonline_sarjana
MYSQL_ROOT_PASSWORD: root123
```

2. Sesuaikan konfigurasi PHP di `docker/php/local.ini` jika diperlukan:
```ini
memory_limit = 512M
post_max_size = 40M
upload_max_filesize = 40M
```

3. Sesuaikan konfigurasi MySQL di `docker/mysql/my.cnf` jika diperlukan:
```ini
innodb_buffer_pool_size = 256M
max_connections = 100
```

### 4. Build dan Jalankan Container

```bash
# Build image
docker-compose build --no-cache

# Jalankan container
docker-compose up -d

# Verifikasi container berjalan
docker-compose ps
```

### 5. Setup Database

```bash
# Masuk ke container MySQL
docker-compose exec db mysql -u root -proot123

# Import database (jika ada)
docker-compose exec db mysql -u root -proot123 katsgamaonline_sarjana < backup.sql
```

## Perintah Docker

### Manajemen Container
```bash
# Start container
docker-compose start

# Stop container
docker-compose stop

# Restart container
docker-compose restart

# Hapus container (data tetap tersimpan)
docker-compose down

# Hapus container dan volume (HATI-HATI: data akan terhapus)
docker-compose down -v
```

### Logs dan Monitoring
```bash
# Lihat logs semua container
docker-compose logs

# Lihat logs container tertentu
docker-compose logs app
docker-compose logs db
docker-compose logs webserver

# Monitor resource usage
docker stats
```

### Masuk ke Container
```bash
# Masuk ke container PHP
docker-compose exec app bash

# Masuk ke container MySQL
docker-compose exec db bash

# Masuk ke container Nginx
docker-compose exec webserver sh
```

## Monitoring

### Resource Usage
Monitor penggunaan resource dengan:
```bash
docker stats
```

### Performa Aplikasi
1. PHP-FPM Status:
   - Logs: `docker-compose logs app`
   - Error Logs: Ada di `/var/log/php/error.log` di dalam container

2. MySQL Status:
   - Logs: `docker-compose logs db`
   - Slow Query Log: Dikonfigurasi di `my.cnf`

3. Nginx Status:
   - Logs: `docker-compose logs webserver`
   - Access Log: `/var/log/nginx/access.log`
   - Error Log: `/var/log/nginx/error.log`

## Troubleshooting

### 1. Container Tidak Bisa Start
```bash
# Cek status
docker-compose ps

# Cek logs
docker-compose logs

# Verifikasi port
netstat -tulpn | grep LISTEN
```

### 2. Performa Lambat
1. Cek resource usage:
   ```bash
   docker stats
   ```

2. Optimasi PHP:
   - Sesuaikan `memory_limit`
   - Aktifkan OpCache
   - Sesuaikan `max_execution_time`

3. Optimasi MySQL:
   - Monitor slow query log
   - Sesuaikan `innodb_buffer_pool_size`
   - Optimasi query cache

### 3. Error Database Connection
1. Verifikasi credentials di `docker-compose.yml`
2. Cek status MySQL:
   ```bash
   docker-compose exec db mysqladmin -u root -proot123 status
   ```
3. Cek akses network antar container

### 4. Permission Issues
1. Cek ownership files:
   ```bash
   ls -la
   ```
2. Sesuaikan permissions:
   ```bash
   sudo chown -R www:www .
   ```

## Backup dan Restore

### Backup Database
```bash
# Backup
docker-compose exec db mysqldump -u root -proot123 katsgamaonline_sarjana > backup.sql

# Restore
docker-compose exec db mysql -u root -proot123 katsgamaonline_sarjana < backup.sql
```

### Backup Volume
```bash
# Backup
docker run --rm -v sarjana_dbdata:/source -v $(pwd):/backup alpine tar czf /backup/dbdata.tar.gz -C /source .

# Restore
docker run --rm -v sarjana_dbdata:/source -v $(pwd):/backup alpine sh -c "cd /source && tar xvf /backup/dbdata.tar.gz"
``` 