<?php
include "koneksi.php";

$id = $_GET['id'];

$query = mysqli_query($koneksi, "DELETE FROM produk WHERE id_produk='$id'");

if($query){
    echo "<script>
            alert('🗑️ Produk berhasil dihapus!');
            window.location='produk.php';
          </script>";
}else{
    echo "<script>
            alert('❌ Produk gagal dihapus!');
            window.location='produk.php';
          </script>";
}
?>