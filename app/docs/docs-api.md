# API Documentation

## Overview
API ini digunakan untuk aplikasi mobile Android Alumni. Base URL untuk semua endpoint adalah:
```
https://sarjana-katsgama.dev.ugm.ac.id/api
```

## Authentication Endpoints

### Sign In
Endpoint untuk login user.

```http
POST https://sarjana-katsgama.dev.ugm.ac.id/api/signin
```

**Request Body:**
```json
{
    "email": "string",
    "password": "string"
}
```

**Response Success:**
```json
{
    "success": true,
    "data": {
        "token": "string",
        "id": "integer",
        "role": "integer",
        "role_name": "string",
        "angkatan": "string",
        "username": "string",
        "nama": "string"
    }
}
```

**Response Error:**
```json
{
    "success": false,
    "error": "string"
}
```

### Change Password
Endpoint untuk mengubah password user.

```http
POST https://sarjana-katsgama.dev.ugm.ac.id/api/password
```

**Request Body:**
```json
{
    "userId": "integer",
    "password": "string",
    "newPassword": "string"
}
```

**Response Success:**
```json
{
    "success": true
}
```

**Response Error:**
```json
{
    "success": false,
    "error": "string"
}
```

### Forgot Password
Endpoint untuk reset password user.

```http
POST https://sarjana-katsgama.dev.ugm.ac.id/api/forgot
```

**Request Body:**
```json
{
    "email": "string"
}
```

**Response Success:**
```json
{
    "success": true
}
```

**Response Error:**
```json
{
    "success": false,
    "error": "string"
}
```

## Alumni Endpoints

### Get All Alumni
Endpoint untuk mendapatkan daftar alumni dengan pagination.

```http
GET https://sarjana-katsgama.dev.ugm.ac.id/api/alumni
```

**Query Parameters:**
- page (optional): nomor halaman
- search (optional): kata kunci pencarian
- prop_id (optional): filter berdasarkan provinsi
- occupation_id (optional): filter berdasarkan bidang kerja
- angkatan (optional): filter berdasarkan angkatan
- prodi (optional): filter berdasarkan program studi

**Response:**
```json
{
    "alumni": [
        {
            "id": "integer",
            "nama": "string",
            "email": "string",
            "notelp": "string",
            "nowa": "string",
            "alamat": "string",
            "photo": "string",
            "instansi": "string",
            "jabatan": "string"
        }
    ],
    "pager": {
        "currentPage": "integer",
        "pageCount": "integer",
        "perPage": "integer",
        "total": "integer"
    }
}
```

### Get Alumni By ID
Endpoint untuk mendapatkan detail alumni berdasarkan ID.

```http
GET https://sarjana-katsgama.dev.ugm.ac.id/api/alumni/{id}
```

**Response:**
```json
{
    "alumni": {
        "id": "integer",
        "nama": "string",
        "email": "string",
        "notelp": "string",
        "nowa": "string",
        "alamat": "string",
        "photo": "string",
        "instansi": "string",
        "jabatan": "string"
    },
    "S1": {
        "universitas": "string",
        "tmasuk": "string",
        "tlulus": "string",
        "prodi": "string"
    },
    "S2": {
        "universitas": "string",
        "tmasuk": "string",
        "tlulus": "string",
        "prodi": "string"
    },
    "S3": {
        "universitas": "string",
        "tmasuk": "string",
        "tlulus": "string",
        "prodi": "string"
    }
}
```

### Get Alumni By User ID
Endpoint untuk mendapatkan detail alumni berdasarkan User ID.

```http
GET https://sarjana-katsgama.dev.ugm.ac.id/api/profile/{userId}
```

**Response:**
```json
{
    "alumni": {
        "id": "integer",
        "nama": "string",
        "email": "string",
        "notelp": "string",
        "nowa": "string",
        "alamat": "string",
        "photo": "string",
        "instansi": "string",
        "jabatan": "string"
    },
    "S1": {
        "universitas": "string",
        "tmasuk": "string",
        "tlulus": "string",
        "prodi": "string"
    },
    "S2": {
        "universitas": "string",
        "tmasuk": "string",
        "tlulus": "string",
        "prodi": "string"
    },
    "S3": {
        "universitas": "string",
        "tmasuk": "string",
        "tlulus": "string",
        "prodi": "string"
    }
}
```

### Edit Profile
Endpoint untuk mengubah data profil alumni.

```http
POST https://sarjana-katsgama.dev.ugm.ac.id/api/profile/{userId}
```

**Request Body:**
```json
{
    "nama": "string",
    "email": "string",
    "notelp": "string",
    "nowa": "string",
    "alamat": "string",
    "prop_id": "integer",
    "instansi": "string",
    "jabatan": "string",
    "occupation_id": "integer",
    "s1_universitas": "string",
    "s1_tmasuk": "string",
    "s1_tlulus": "string",
    "s1_prodi": "string",
    "s2_universitas": "string",
    "s2_tmasuk": "string",
    "s2_tlulus": "string",
    "s2_prodi": "string",
    "s3_universitas": "string",
    "s3_tmasuk": "string",
    "s3_tlulus": "string",
    "s3_prodi": "string"
}
```

**Response Success:**
```json
{
    "success": true
}
```

**Response Error:**
```json
{
    "success": false,
    "errCode": "string",
    "error": "string"
}
```

### Upload Avatar
Endpoint untuk mengupload foto profil alumni.

```http
POST https://sarjana-katsgama.dev.ugm.ac.id/api/avatar/{userId}
```

**Request Body:**
- Form-data dengan key "file"
- File harus berupa image (jpg/jpeg/png)
- Maksimal ukuran 5MB

**Response Success:**
```json
{
    "success": true,
    "msg": "string"
}
```

**Response Error:**
```json
{
    "success": false,
    "error": "string"
}
```

### Get Filters
Endpoint untuk mendapatkan data filter.

```http
GET https://sarjana-katsgama.dev.ugm.ac.id/api/filters
```

**Response:**
```json
{
    "provinces": [
        {
            "label": "string",
            "value": "integer"
        }
    ],
    "prodis": [
        {
            "label": "string",
            "value": "string"
        }
    ],
    "angkatan": [
        {
            "label": "string",
            "value": "string"
        }
    ],
    "occupations": [
        {
            "label": "string",
            "value": "integer"
        }
    ]
}
```

## Content Endpoints

### News
```http
GET https://sarjana-katsgama.dev.ugm.ac.id/api/news
GET https://sarjana-katsgama.dev.ugm.ac.id/api/news/{id}
```

### Job Vacancies
```http
GET https://sarjana-katsgama.dev.ugm.ac.id/api/lowongan
GET https://sarjana-katsgama.dev.ugm.ac.id/api/lowongan/{id}
```

### Advertisement
```http
GET https://sarjana-katsgama.dev.ugm.ac.id/api/advertisement
GET https://sarjana-katsgama.dev.ugm.ac.id/api/advertisement/{id}
```

### Agenda
```http
GET https://sarjana-katsgama.dev.ugm.ac.id/api/agenda
GET https://sarjana-katsgama.dev.ugm.ac.id/api/agenda/{id}
```

### Management
```http
GET https://sarjana-katsgama.dev.ugm.ac.id/api/pengurus
```

## Error Codes

| Error Code | Description |
|------------|-------------|
| USER_ERROR | User tidak ditemukan atau tidak valid |
| VALIDATION_ERROR | Input tidak valid atau tidak lengkap |
| SYSTEM_ERROR | Terjadi kesalahan pada sistem |

## Notes
- Semua response menggunakan status code 200
- Format tanggal menggunakan string
- File foto disimpan di folder `/photos/`
- Ukuran foto akan diresize menjadi 150x150 pixel
