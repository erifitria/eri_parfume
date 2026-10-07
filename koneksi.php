<?php
$koneksi = mysqli_connect("localhost", "root", "", "db_kasir_eri_perfume");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>