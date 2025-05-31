# modul3 API Dokumentasi penerima dan distribusi

## Deskripsi

API ini memungkinkan pengguna untuk mengelola distribusi hasil donasi yang didapat dari modul 2. API ini menyediakan endpoint untuk membuat, melihat, mengubah, dan menghapus data penerima donasi, serta ditribusi dimana bisa mebdistribusikan hasil donasi kepenira donasi dan bisa melihat hasil distribusi seperti berapa jumlah donasi yang didistribusikan dan siapa penerima donasi.

## Base URL

```text
https://kuliah2025.my.id/modul.3_distributions/
```

## Endpoints

### Manajemen Donasi

#### 1. Mendaftarkan penerima donasi

- **Method:** POST
- **Path:** `/recipients.php`
- **Content-Type:** application/json

##### Request Body

```json
{
  "nama": "Budi",
  "alamat": "Jl. Merdeka No. 1"
}
```

##### Response Success

- **Status Code:** 200 Ok
- **Content-Type:** application/json

```json
{
  "id": "1"
}
```

##### Response Error

- **Status Code:** 400 Bad Request
- **Content-Type:** application/json

```json
{
  "error": "Nama dan alamat wajib diisi",
  "status": "failed"
}
```

#### 2. Mendapatkan Daftar penerima donasi

- **Method:** GET
- **Path:** `/recipients.php`/`/recipients.php?id=id`

##### Response Success

- **Status Code:** 200 OK
- **Content-Type:** application/json

```json
[
  {
    "id": 1,
    "nama": "Budi",
    "alamat": "Jl. Merdeka No. 1",
    "is_active": 1
  },
  {
    "id": 2,
    "nama": "dani",
    "alamat": "Jl. Anggrek No. 1",
    "is_active": 1
  },
  {
    "id": 3,
    "nama": "dhimas",
    "alamat": "Jl. Melati No. 3",
    "is_active": 1
  },
  {
    "id": 4,
    "nama": "Bintang",
    "alamat": "Jl. Arjuna No. 4",
    "is_active": 1
  },
  {
    "id": 5,
    "nama": "alfa",
    "alamat": "Jl. Kenanga No. 5",
    "is_active": 1
  }
]
```

#### 3. Mengupdate daftar penerima donasi

- **Method:** PUT
- **Path:** `/recipients.php?id=id`

##### Request Body

```json
{
  "nama": "alfin",
  "alamat": "Jl. Kenanga No. 5"
}
```

##### Response Success

- **Status Code:** 200 OK
- **Content-Type:** application/json

```json
{
  "message": "Data updated"
}
```

##### Response Error

- **Status Code:** 400 Bad Request
- **Content-Type:** application/json

```json
{
  "error": "ID dan data update wajib diisi",
  "status": "failed"
}
```

#### 4. Menonaktifkan penerima donasi

- **Method:** DELETE
- **Path:** `/recipients.php?id=id`

##### Response Success

- **Status Code:** 200 OK
- **Content-Type:** application/json

```json
{
  "message": "Penerima dinonaktifkan"
}
```

#### 5. Mengaktifkan kembali penerima donasi

- **Method:** PATCH
- **Path:** `/recipients.php?id=id`

##### Response Success

- **Status Code:** 200 OK
- **Content-Type:** application/json

```json
{
  "message": "Penerima diaktifkan kembali"
}
```

#### 6. Mendistribusikan Donasi

- **Method:** POST
- **Path:** `/distributions.php`

##### Request Body

```json
{
  "donasi_id": 50,
  "recipients": [
    { "id": 1, "amount": 15 },
    { "id": 5, "amount": 8 }
  ]
}
```

##### Response Success

- **Status Code:** 200 OK
- **Content-Type:** application/json

```json
{
  "donasi_id": 50,
  "total_donasi": 59,
  "total_distributed": 23,
  "remaining": 36
}
```

##### Response Error

- **Status Code:** 400 Bad Request
- **Content-Type:** application/json

```json
{
  "error": "donasi_id dan recipients wajib diisi"
}
```

#### 7. Mengambil Daftar Distribusi

- **Method:**
- **Path:** `/distributions.php?donasi_id=50`

##### Response Success

- **Status Code:** 200 OK
- **Content-Type:** application/json

```json
{
  "donasi_id": 50,
  "total_donasi": 59,
  "total_distributed": 23,
  "remaining": 36,
  "distributions": [
    {
      "distribution_id": 4,
      "recipient_id": 1,
      "nama": "Budi",
      "alamat": "Jl. Merdeka No. 1",
      "amount_received": "15.00",
      "unit": "kotak",
      "status": "diproses"
    },
    {
      "distribution_id": 5,
      "recipient_id": 5,
      "nama": "alfin",
      "alamat": "Jl. Kenanga No. 5",
      "amount_received": "8.00",
      "unit": "kotak",
      "status": "diproses"
    }
  ]
}
```

#### 8. Mengupdate Status Distribusi

- **Method:**
- **Path:** `/distributions.php`

##### Response Success

- **Status Code:** 200 OK
- **Content-Type:** application/json

```json
{
  "message": "Status distribusi berhasil diubah"
}
```

##### Response Error

- **Status Code:** 400 Bad Request
- **Content-Type:** application/json

```json
{
  "error": "distribution_id dan status wajib diisi"
}
```
