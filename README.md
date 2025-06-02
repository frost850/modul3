# modul3 API Dokumentasi penerima dan distribusi

## Deskripsi

API ini memungkinkan pengguna untuk mengelola distribusi hasil donasi yang didapat dari modul 2. API ini menyediakan endpoint untuk membuat, melihat, mengubah, dan menghapus data penerima donasi, serta ditribusi dimana bisa mebdistribusikan hasil donasi kepenira donasi dan bisa melihat hasil distribusi seperti berapa jumlah donasi yang didistribusikan dan siapa penerima donasi.

## Base URL

```text
https://kuliah2025.my.id/modul.3_distributions/
```
## Text Header
Header disini perlu mengambil token dari login admin atau volunter dari kelompok 1.
berikut cara dokumentasi untuk mengambil token admin dan volunter dari proses login yang di gunakan sebagai header. 
akses link yang telah di sediakan sebagai berikut https://github.com/Rieko00/DonationAPI-Auth.
Header ini menggunakan authorization bearer "token" .


## ERD 
![Diagram Tanpa Judul drawio (1)](https://github.com/user-attachments/assets/b2a140e0-1019-481e-9019-79360cfaca56)

Dari Gamabar ERD di atas dokumentasi penerima dan distribusi 
 - tabel donasi yang dimana akan menyimpan data pemberi donasi
 - tabel distribusi : menampilkan jumlah donasi yang akan di terima, banyak nilai satuan ( rupiah, kilogram,dll), status ditribusi, dan pencatatan distribusi
 - penerima donasi : menampilkan data penerima baik individu, lembaga, atau komunitas 


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

- **Method:** GET
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

- **Method:** PUT
- **Path:** `/distributions.php`

##### Reequest Body
```json
{
  "distribution_id": 7,
  "status": "diterima" 
}
```
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
## status code 

| Status Code | Description                                  |
|-------------|----------------------------------------------|
| 200         | OK - Permintaan berhasil                     |
| 201         | Created - Data berhasil dibuat               |
| 400         | Bad Request - Parameter tidak valid/tidak lengkap |
| 401         | Unauthorized - Autentikasi diperlukan        |
| 403         | Forbidden - Tidak memiliki izin mengakses resource |
| 404         | Not Found - Resource tidak ditemukan         |
| 500         | Internal Server Error - Kesalahan pada server|

##### Struktur Database
TABEL: recipients

| Field     | Type         | Description                          |
|-----------|--------------|--------------------------------------|
| id        | int(11)      | ID unik penerima (Primary Key)       |
| nama      | varchar(255) | Nama lengkap penerima                |
| alamat    | text         | Alamat lengkap penerima              |
| is_active | tinyint(1)   | Status aktif (1=aktif, 0=nonaktif)   |

TABEL: distributions
| Field           | Type                          | Description                          |
|-----------------|-------------------------------|--------------------------------------|
| id              | int(11)                        | ID unik distribusi (Primary Key)     |
| donasi_id       | int(11)                        | ID donasi terkait (Foreign Key)      |
| recipient_id    | int(11)                        | ID penerima (Foreign Key)            |
| amount_received | decimal(15,2)                  | Jumlah yang diterima                 |
| unit            | varchar(10)                    | Satuan (rupiah/kg/liter/dll)         |
| status          | enum('diproses','diterima')    | Status distribusi                    |
| created_at      | timestamp                      | Waktu pencatatan distribusi          |

TABEL: donations
| Field           | Type           | Description                              |
|-----------------|----------------|------------------------------------------|
| id              | int(11)        | ID unik donasi (Primary Key)             |
| jumlah          | decimal(15,2)  | Nilai donasi                             |
| donor_name      | varchar(255)   | Nama pendonor                            |
| tanggal_donasi  | timestamp      | Waktu donasi dilakukan                   |
