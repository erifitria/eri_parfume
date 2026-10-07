<?php
session_start();

/* LOGOUT ADMIN */
if(isset($_GET['logout'])){
    session_unset();
    session_destroy();

    header("Location: login.php");
    exit;
}

if(!isset($_SESSION['login'])){
    header("Location: login_admin.php");
    exit;
}

if($_SESSION['level'] != 'admin'){
    header("Location: transaksi.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Admin | ERI Parfume</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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

.sidebar p{
    text-align:center;
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

.card{
    border:none;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,.1);
}

.menu-card{
    transition:.2s;
}

.menu-card:hover{
    transform:translateY(-3px);
}

</style>

</head>


<body>


<!-- SIDEBAR -->

<div class="sidebar">

    <h3>🫧 ERI PARFUME</h3>

    <p>ADMIN</p>

    <hr>


    <a href="produk.php">
        📦 Produk
    </a>

    <a href="pelanggan.php">
        👥 Pelanggan
    </a>

    <a href="data_kasir.php">
        👤 Data Kasir
    </a>

    <a href="laporan.php">
        📊 Laporan
    </a>

    <a href="index_admin.php?logout=1">
        🏃 Logout
    </a>

</div>



<!-- CONTENT -->

<div class="content">

    <h2>👋 Selamat Datang, <?php echo $_SESSION['nama_kasir']; ?></h2>

    <p class="text-muted">
        Halaman Admin ERI Parfume
    </p>


    <div class="row mt-4">


        <!-- PRODUK -->

        <div class="col-md-6 mb-4">

            <div class="card menu-card p-4">

                <h4>📦 Data Produk</h4>

                <p>
                    Kelola data produk parfum.
                </p>

                <a href="produk.php" class="btn btn-danger">
                    Kelola Produk
                </a>

            </div>

        </div>


        <!-- PELANGGAN -->

        <div class="col-md-6 mb-4">

            <div class="card menu-card p-4">

                <h4>👥 Data Pelanggan</h4>

                <p>
                    Kelola data pelanggan.
                </p>

                <a href="pelanggan.php" class="btn btn-danger">
                    Kelola Pelanggan
                </a>

            </div>

        </div>


        <!-- KASIR -->

        <div class="col-md-6 mb-4">

            <div class="card menu-card p-4">

                <h4>👤 Data Kasir</h4>

                <p>
                    Tambah, edit dan hapus akun kasir.
                </p>

                <a href="data_kasir.php" class="btn btn-danger">
                    Kelola Kasir
                </a>

            </div>

        </div>


        <!-- LAPORAN -->

        <div class="col-md-6 mb-4">

            <div class="card menu-card p-4">

                <h4>📊 Laporan Penjualan</h4>

                <p>
                    Lihat laporan dan riwayat penjualan.
                </p>

                <a href="laporan.php" class="btn btn-danger">
                    Lihat Laporan
                </a>

            </div>

        </div>


    </div>

</div>


</body>

</html>