<?php
session_start();

include "koneksi.php";

/* CEK LOGIN */
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

/* KHUSUS KASIR */
if($_SESSION['level'] != 'kasir'){
    header("Location: index_admin.php");
    exit;
}


/* Hitung jumlah produk */
$data_produk = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS jumlah FROM produk"
);

$produk = mysqli_fetch_assoc($data_produk);


/* Hitung jumlah pelanggan */
$data_pelanggan = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS jumlah FROM pelanggan"
);

$pelanggan = mysqli_fetch_assoc($data_pelanggan);


/* Hitung jumlah transaksi */
$data_transaksi = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS jumlah FROM penjualan"
);

$transaksi = mysqli_fetch_assoc($data_transaksi);

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Dashboard Kasir | ERI Parfume</title>

<link 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" 
    rel="stylesheet"
>

<link 
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" 
    rel="stylesheet"
>

<style>

*{
    font-family:'Poppins',sans-serif;
}

body{
    background:#fff5fa;
}


/* SIDEBAR */

.sidebar{
    width:250px;
    height:100vh;
    background:#ff7aa2;
    position:fixed;
    color:white;
    padding:20px;
}

.sidebar h3{
    text-align:center;
    font-weight:bold;
}

.sidebar .role{
    text-align:center;
    margin-bottom:15px;
}

.sidebar a{
    display:block;
    color:white;
    text-decoration:none;
    padding:12px;
    border-radius:10px;
    margin-top:10px;
}

.sidebar a:hover{
    background:white;
    color:#ff7aa2;
}


/* CONTENT */

.content{
    margin-left:270px;
    padding:30px;
}


/* CARD */

.card-info{
    border:none;
    border-radius:20px;
    box-shadow:0 5px 15px rgba(0,0,0,.1);
    background:white;
}

.welcome{
    background:white;
    padding:30px;
    border-radius:20px;
    box-shadow:0 5px 15px rgba(0,0,0,.1);
    margin-bottom:25px;
}

</style>

</head>


<body>


<!-- SIDEBAR -->

<div class="sidebar">

    <h3>🫧 ERI PARFUME</h3>

    <p class="role">
        KASIR
    </p>

    <hr>


    


    <a href="transaksi.php">
        🛒 Transaksi
    </a>


    <a href="data_transaksi.php">
        📋 Data Transaksi
    </a>


    <a href="data_produk.php">
        📦 Data Produk
    </a>


    <a href="data_pelanggan.php">
        👥 Data Pelanggan
    </a>


    


    <a href="logout.php">
        🏃 Logout
    </a>

</div>



<!-- CONTENT -->

<div class="content">


    <!-- SELAMAT DATANG -->

    <div class="welcome">

        <h2>
            👋 Selamat Datang, 
            <?php echo $_SESSION['nama_kasir']; ?>!
        </h2>

        <p class="text-muted mb-0">
            Selamat datang di Sistem Kasir ERI Parfume ✨
        </p>

    </div>



    <!-- INFORMASI -->

    <h4 class="mb-3">
        📊 Informasi Kasir
    </h4>


    <div class="row">


        <!-- PRODUK -->

        <div class="col-md-4">

            <div class="card card-info p-4">

                <h5>
                    📦 Total Produk
                </h5>

                <h2>
                    <?php echo $produk['jumlah']; ?>
                </h2>

                <p class="text-muted mb-0">
                    Produk tersedia
                </p>

            </div>

        </div>



        <!-- PELANGGAN -->

        <div class="col-md-4">

            <div class="card card-info p-4">

                <h5>
                    👥 Total Pelanggan
                </h5>

                <h2>
                    <?php echo $pelanggan['jumlah']; ?>
                </h2>

                <p class="text-muted mb-0">
                    Pelanggan terdaftar
                </p>

            </div>

        </div>



        <!-- TRANSAKSI -->

        <div class="col-md-4">

            <div class="card card-info p-4">

                <h5>
                    🧾 Total Transaksi
                </h5>

                <h2>
                    <?php echo $transaksi['jumlah']; ?>
                </h2>

                <p class="text-muted mb-0">
                    Transaksi tercatat
                </p>

            </div>

        </div>


    </div>


</div>


</body>

</html>