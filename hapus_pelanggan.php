<?php
include "koneksi.php";

$id = $_GET['id'];

mysqli_query($koneksi, "DELETE FROM pelanggan WHERE id_pelanggan='$id'");

echo "<script>
    alert('Data pelanggan berhasil dihapus!');
    window.location='pelanggan.php';
</script>";
?>