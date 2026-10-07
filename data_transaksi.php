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


/* SEARCH TRANSAKSI */

$keyword = "";

if(isset($_GET['cari'])){
    $keyword = $_GET['cari'];
}


/* AMBIL DATA TRANSAKSI */
$data = mysqli_query($koneksi, "
    SELECT 
        penjualan.id_penjualan,
        penjualan.tanggal,
        pelanggan.nama_pelanggan,
        penjualan.total_bayar,
        penjualan.metode_pembayaran
    FROM penjualan
    LEFT JOIN pelanggan
        ON penjualan.id_pelanggan = pelanggan.id_pelanggan
    WHERE pelanggan.nama_pelanggan LIKE '%$keyword%'
        OR penjualan.tanggal LIKE '%$keyword%'
        OR penjualan.metode_pembayaran LIKE '%$keyword%'
    ORDER BY penjualan.id_penjualan DESC
");

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Data Transaksi | ERI Parfume</title>

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

.card{
    border:none;
    border-radius:20px;
    box-shadow:0 5px 15px rgba(0,0,0,.1);
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

    <h2>📋 Data Transaksi</h2>

    <p class="text-muted">
        Riwayat transaksi penjualan ERI Parfume.
    </p>


    <div class="card p-4 mt-4">


        <!-- SEARCH -->

        <form method="GET" class="mb-4">

            <div class="input-group">

                <input
                    type="text"
                    name="cari"
                    class="form-control"
                    placeholder="🔍 Cari transaksi..."
                    value="<?php echo $keyword; ?>"
                >

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Cari
                </button>

            </div>

        </form>


        <div class="table-responsive">

            <table class="table table-bordered table-striped">

                <thead class="table-danger">

                    <tr>

                        <th>No</th>

                        <th>Tanggal</th>

                        <th>Pelanggan</th>

                        <th>Total Bayar</th>

                        <th>Metode</th>

                        <th>Aksi</th>

                    </tr>

                </thead>


                <tbody>

                <?php

                $no = 1;

                while($row = mysqli_fetch_assoc($data)){

                ?>

                    <tr>

                        <td>
                            <?php echo $no++; ?>
                        </td>


                        <td>
                            <?php echo $row['tanggal']; ?>
                        </td>


                        <td>
                            <?php echo $row['nama_pelanggan']; ?>
                        </td>


                        <td>
                            Rp<?php echo number_format(
                                $row['total_bayar'],
                                0,
                                ',',
                                '.'
                            ); ?>
                        </td>


                        <td>
                            <?php echo strtoupper($row['metode_pembayaran']); ?>
                        </td>


                        <td>

                            <a 
                                href="cetak_struk_ulang.php?id=<?php echo $row['id_penjualan']; ?>"
                                class="btn btn-success btn-sm"
                            >
                                🖨️ Cetak Struk
                            </a>

                        </td>

                    </tr>

                <?php } ?>


                <?php if($no == 1){ ?>

                    <tr>

                        <td colspan="6" class="text-center">
                            Data transaksi tidak ditemukan.
                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>


</body>

</html>