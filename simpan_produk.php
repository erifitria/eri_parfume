<?php
include "koneksi.php";

$nama_produk = $_POST['nama_produk'];
$kategori    = $_POST['kategori'];
$ukuran      = $_POST['ukuran'];
$harga       = $_POST['harga'];
$stok        = $_POST['stok'];

$query = mysqli_query($koneksi, "INSERT INTO produk (nama_produk, kategori, ukuran, harga, stok) VALUES ('$nama_produk', '$kategori', '$ukuran', '$harga', '$stok')");

if($query){
    echo "<script>
            alert('🌸 Produk berhasil ditambahkan!');
            window.location='produk.php';
          </script>";
}else{
    echo "<script>
            alert('❌ Produk gagal ditambahkan!');
            window.location='tambah_produk.php';
          </script>";
}
?>