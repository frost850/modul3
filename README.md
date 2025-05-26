# API Dokumentasi Distribusi 
## Deskripsi 
modul layanan penerima dan distribusi bantuan pada sistem donasi berbasis API. Modul ini memungkinkan admin atau volunteer untuk mengelola data penerima bantuan serta mencatat status distribusi bantuan berupa uang atau barang.
## EndPoins
### penerima bantuan 
1. penerima donasi
   - method : Post
   - Path : /recipients
   - content-type : application/json
2. Ambil data Penerima Donasi 
   - method : Get 
   - Path : /recipients
   -       /recipients?recipients_id={id}
   - content-type : application/json
3. Update data penerima
   - method : Put  
   - Path : //recipients?recipients_id={id}
   - content-type : application/json
4. Hapus data penerima 
   - method : delete 
   - Path : /recipients?recipients_id={id}
   - content-type : application/json
     
### Distribusi Bantuan 
1. tambah bantuan 
   - method : Post
   - Path : /distributions
   - content-type : application/json
2. melihat data distribusi bantuan
   - method : get
   - Path : /distributions
   -       /distributions?distributions_id={id}
   - content-type : application/json
3. update status distribusi 
   - method : Put 
   - Path : /distributions?distributions_id={id}/status
   - content-type : application/json
     
