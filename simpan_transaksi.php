<?php

session_start();
include "koneksi.php";

$id_kasir = $_SESSION['id_kasir'];
$id_pelanggan = $_POST['id_pelanggan'];
$id_produk = $_POST['id_produk'];
$jumlah = $_POST['jumlah'];
$metode = $_POST['metode'];

/* TAMBAHAN UANG BAYAR */
$bayar = preg_replace('/[^0-9]/', '', $_POST['bayar']);

$tanggal = date('Y-m-d');

$total = 0;


/* Hitung total semua produk */

for($i = 0; $i < count($id_produk); $i++){

    $produk_id = $id_produk[$i];
    $qty = $jumlah[$i];

    $data_produk = mysqli_query(
        $koneksi,
        "SELECT * FROM produk WHERE id_produk='$produk_id'"
    );

    $produk = mysqli_fetch_assoc($data_produk);

    $harga = $produk['harga'];

    $subtotal = $harga * $qty;

    $total = $total + $subtotal;
}


/* HITUNG KEMBALIAN */

if($metode == "Tunai"){

    $kembalian = $bayar - $total;

    /* Kalau uang kurang */
    if($kembalian < 0){

        echo "<script>
            alert('Uang pembayaran kurang!');
            window.location='transaksi.php';
        </script>";

        exit;
    }

}else{

    /* Kalau QRIS */
    $bayar = $total;
    $kembalian = 0;

}


/* Simpan transaksi */

$query = mysqli_query(
    $koneksi,
    "INSERT INTO penjualan
    (id_kasir, id_pelanggan, tanggal, total_bayar, metode_pembayaran, bayar, kembalian)
    VALUES
    ('$id_kasir', '$id_pelanggan', '$tanggal', '$total', '$metode', '$bayar', '$kembalian')"
);


if($query){

    $id_penjualan = mysqli_insert_id($koneksi);


    /* Simpan detail produk */

    for($i = 0; $i < count($id_produk); $i++){

        $produk_id = $id_produk[$i];
        $qty = $jumlah[$i];

        $data_produk = mysqli_query(
            $koneksi,
            "SELECT * FROM produk WHERE id_produk='$produk_id'"
        );

        $produk = mysqli_fetch_assoc($data_produk);

        $harga = $produk['harga'];

        $subtotal = $harga * $qty;


        mysqli_query(
            $koneksi,
            "INSERT INTO detail_penjualan
            (id_penjualan, id_produk, jumlah, harga, subtotal)
            VALUES
            ('$id_penjualan', '$produk_id', '$qty', '$harga', '$subtotal')"
        );


        /* Kurangi stok */

        mysqli_query(
            $koneksi,
            "UPDATE produk
             SET stok = stok - $qty
             WHERE id_produk='$produk_id'"
        );

    }


    header("Location: cetak_struk.php?id=$id_penjualan");
    exit;


}else{

    echo "<script>
        alert('Transaksi gagal disimpan!');
        window.location='transaksi.php';
    </script>";

}

?>