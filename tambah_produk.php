<?php
include "koneksi.php";

if(isset($_POST['simpan'])){

    $nama = $_POST['nama_produk'];
    $kategori = $_POST['kategori'];
    $aroma = $_POST['aroma'];
    $ukuran = $_POST['ukuran'];
    $harga = str_replace('.', '', $_POST['harga']);
    $stok = $_POST['stok'];

    mysqli_query($koneksi, "INSERT INTO produk 
    (nama_produk, kategori, aroma, ukuran, harga, stok) 
    VALUES 
    ('$nama', '$kategori', '$aroma', '$ukuran', '$harga', '$stok')");

    echo "<script>
            alert('Produk berhasil ditambahkan!');
            window.location='produk.php';
          </script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">

<title>Tambah Produk</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    font-family:'Poppins',sans-serif;
}

body{
    background:#fff5fa;
}

.card{
    border:none;
    border-radius:20px;
    box-shadow:0 8px 20px rgba(0,0,0,.1);
}

.btn-pink{
    background:#ff7aa2;
    color:white;
}

.btn-pink:hover{
    background:#ff5a92;
    color:white;
}

</style>

</head>

<body>

<div class="container mt-5">

<div class="col-md-6 mx-auto">

<div class="card p-4">

<h3 class="text-center mb-4">
🌸 Tambah Produk
</h3>

<form method="POST">


<div class="mb-3">

<label>🌸 Nama Produk</label>

<input
type="text"
name="nama_produk"
class="form-control"
required>

</div>


<div class="mb-3">

<label>🏷️ Kategori</label>

<select
name="kategori"
class="form-select"
required>

<option value="Pria">Pria</option>
<option value="Wanita">Wanita</option>
<option value="Unisex">Unisex</option>

</select>

</div>



<div class="mb-3">

<label>🧴 Ukuran</label>

<input
type="text"
name="ukuran"
class="form-control"
placeholder="Contoh: 50 ml"
required>

</div>


<div class="mb-3">

<label>💰 Harga</label>

<input
type="text"
name="harga"
class="form-control"
placeholder="Contoh: 1750000"
min="0"
required>

</div>


<div class="mb-3">

<label>📦 Stok</label>

<input
type="number"
name="stok"
class="form-control"
min="0"
required>

</div>


<button
type="submit"
name="simpan"
class="btn btn-pink w-100">

💾 Simpan Produk

</button>

<br><br>

<a href="produk.php"
class="btn btn-secondary w-100">

⬅️ Kembali

</a>

</form>

</div>

</div>

</div>

</body>
</html>