Folder project terdapat dalam folder e-ticket. Silakan download semua file dan folder e-ticket pindahkan ke dalam folder di web server pada laptop kalian. Misal pada XAMPP, letakkan pada folder htdocs. Silakan ikuti langkah-langkah berikut untuk dapat mengoperasikan program ini :

  1. Pada folder e-ticket, terdapat file onero_db.sql, silakan import file tersebut ke dalam database kalian. Buatlah database terlebih dahulu, nama database disarankan menggunakan nama onero_db, Jika mau menggunakan nama lain, silakan disesuaikan pada settingan database pada step kedua.
  2. Masuk ke folder application/config dan cari file database.php. Silakan sesuaikan settingan database kalian pada bagian :
  ![settingan-db](https://user-images.githubusercontent.com/71543528/93705620-dcde6180-fb48-11ea-8b0b-e8f4b5efd62c.PNG)
  3. Jika di folder kalian di dalam web server masih menggunakan e-ticket, silakan buka browsernya dengan memanggil folder tersebut. Misal secara default saya jalankan **localhost/e-ticket** untuk mengakses halaman member. Dan **localhost/e-ticket/auth/** untuk mengakses halaman admin. Untuk akun admin adalah :

  * username : admin
  * password : 123
  
  Lalu klik button login
