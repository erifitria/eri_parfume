<?php

include "koneksi.php";


$tanggal_awal = "";

$tanggal_akhir = "";

$keyword = "";


/* SEARCH */

if(isset($_GET['cari'])){
    $keyword = $_GET['cari'];
}



/* =========================
   QUERY LAPORAN
========================= */

$query = "SELECT 
            penjualan.id_penjualan,
            penjualan.tanggal,
            pelanggan.nama_pelanggan,
            kasir.nama_kasir,
            produk.nama_produk,
            detail_penjualan.jumlah,
            detail_penjualan.subtotal,
            penjualan.total_bayar,
            penjualan.metode_pembayaran,
            penjualan.bayar,
            penjualan.kembalian
          FROM penjualan
          LEFT JOIN pelanggan 
          ON penjualan.id_pelanggan = pelanggan.id_pelanggan
          LEFT JOIN kasir
          ON penjualan.id_kasir = kasir.id_kasir
          LEFT JOIN detail_penjualan
          ON penjualan.id_penjualan = detail_penjualan.id_penjualan
          LEFT JOIN produk
          ON detail_penjualan.id_produk = produk.id_produk";



/* =========================
   FILTER TANGGAL
========================= */

if(isset($_GET['tampilkan'])){

    $tanggal_awal = $_GET['tanggal_awal'];

    $tanggal_akhir = $_GET['tanggal_akhir'];


    if($tanggal_awal != "" && $tanggal_akhir != ""){

        $query .= " WHERE DATE(penjualan.tanggal)
                    BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
    }
}



/* =========================
   SEARCH LAPORAN
========================= */

if($keyword != ""){

    if(strpos($query, "WHERE") !== false){

        $query .= " AND (
            pelanggan.nama_pelanggan LIKE '%$keyword%'
            OR kasir.nama_kasir LIKE '%$keyword%'
            OR produk.nama_produk LIKE '%$keyword%'
            OR penjualan.metode_pembayaran LIKE '%$keyword%'
            OR penjualan.tanggal LIKE '%$keyword%'
        )";

    }else{

        $query .= " WHERE (
            pelanggan.nama_pelanggan LIKE '%$keyword%'
            OR kasir.nama_kasir LIKE '%$keyword%'
            OR produk.nama_produk LIKE '%$keyword%'
            OR penjualan.metode_pembayaran LIKE '%$keyword%'
            OR penjualan.tanggal LIKE '%$keyword%'
        )";
    }
}



/* =========================
   URUTKAN DATA
========================= */

$query .= " ORDER BY penjualan.tanggal DESC";


$data = mysqli_query($koneksi, $query);

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Laporan | ERI Perfume</title>

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


/* CETAK */

@media print{

    .sidebar,
    form,
    .btn{
        display:none !important;
    }

    .content{
        margin-left:0;
        padding:10px;
    }

    body{
        background:white;
    }

    .card{
        box-shadow:none;
    }

}

</style>

</head>


<body>


<!-- SIDEBAR -->

<div class="sidebar">

    <h3>🫧 ERI PARFUME</h3>

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

    <a href="logout.php">
        🏃 Logout
    </a>

</div>



<!-- CONTENT -->

<div class="content">


    <h2>📊 Laporan Penjualan</h2>

    <p>
        Berikut adalah laporan transaksi penjualan ERI Parfume.
    </p>



    <!-- FILTER TANGGAL -->

    <div class="card p-4 mb-4">

        <form method="GET">

            <div class="row">

                <div class="col-md-4">

                    <label>
                        Tanggal Awal
                    </label>

                    <input
                        type="date"
                        name="tanggal_awal"
                        class="form-control"
                        value="<?php echo $tanggal_awal; ?>"
                    >

                </div>


                <div class="col-md-4">

                    <label>
                        Tanggal Akhir
                    </label>

                    <input
                        type="date"
                        name="tanggal_akhir"
                        class="form-control"
                        value="<?php echo $tanggal_akhir; ?>"
                    >

                </div>


                <div class="col-md-4 d-flex align-items-end">

                    <button
                        type="submit"
                        name="tampilkan"
                        class="btn btn-primary"
                    >
                        🔍 Tampilkan
                    </button>

                </div>

            </div>

        </form>


        <!-- SEARCH LAPORAN -->

        <form method="GET" class="mt-3">

            <div class="input-group">

                <input
                    type="text"
                    name="cari"
                    class="form-control"
                    placeholder="🔍 Cari laporan..."
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


    </div>



    <!-- TABEL LAPORAN -->

    <div class="card p-4">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <h4>
                📋 Data Penjualan
            </h4>

            <a
                href="cetak_laporan.php"
                class="btn btn-success"
            >
                🖨️ Cetak Laporan
            </a>

        </div>



        <div class="table-responsive">

            <table class="table table-bordered table-striped">

                <thead class="table-danger">

                    <tr>

                        <th>No</th>

                        <th>Tanggal</th>

                        <th>Produk</th>

                        <th>Jumlah</th>

                        <th>Pelanggan</th>

                        <th>Kasir</th>

                        <th>Subtotal</th>

                        <th>Metode</th>

                        <th>Uang Bayar</th>

                        <th>Kembalian</th>

                        <th>Aksi</th>

                    </tr>

                </thead>


                <tbody>

                <?php

                $no = 1;

                $total_semua = 0;


                while($row = mysqli_fetch_assoc($data)){

                    $total_semua += $row['subtotal'];

                ?>

                    <tr>

                        <td>
                            <?php echo $no++; ?>
                        </td>


                        <td>

                            <?php

                            echo date(
                                'd-m-Y',
                                strtotime($row['tanggal'])
                            );

                            ?>

                        </td>


                        <td>

                            <?php

                            echo $row['nama_produk']
                                ? $row['nama_produk']
                                : '-';

                            ?>

                        </td>


                        <td>

                            <?php echo $row['jumlah']; ?>

                        </td>


                        <td>

                            <?php

                            echo $row['nama_pelanggan']
                                ? $row['nama_pelanggan']
                                : '-';

                            ?>

                        </td>


                        <td>

                            <?php

                            echo $row['nama_kasir']
                                ? $row['nama_kasir']
                                : '-';

                            ?>

                        </td>


                        <td>

                            Rp<?php

                            echo number_format(
                                $row['subtotal'],
                                0,
                                ',',
                                '.'
                            );

                            ?>

                        </td>


                        <td>

                            <?php

                            echo $row['metode_pembayaran'];

                            ?>

                        </td>


                        <td>

                            Rp<?php

                            echo number_format(
                                $row['bayar'],
                                0,
                                ',',
                                '.'
                            );

                            ?>

                        </td>


                        <td>

                            Rp<?php

                            echo number_format(
                                $row['kembalian'],
                                0,
                                ',',
                                '.'
                            );

                            ?>

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

                        <td colspan="11" class="text-center">

                            Belum ada data penjualan.

                        </td>

                    </tr>

                <?php } ?>


                </tbody>



                <tfoot>

                    <tr>

                        <th colspan="6" class="text-end">

                            Total Penjualan

                        </th>

                        <th colspan="5">

                            Rp<?php

                            echo number_format(
                                $total_semua,
                                0,
                                ',',
                                '.'
                            );

                            ?>

                        </th>

                    </tr>

                </tfoot>

            </table>

        </div>



        <!-- STOK PRODUK -->

        <div class="mt-4">

            <h4>
                📦 Stok Produk
            </h4>


            <table class="table table-bordered table-striped">

                <thead class="table-danger">

                    <tr>

                        <th>No</th>

                        <th>Produk</th>

                        <th>Stok Sekarang</th>

                        <th>Keterangan</th>

                    </tr>

                </thead>


                <tbody>

                <?php

                $data_stok = mysqli_query(
                    $koneksi,
                    "SELECT * FROM produk ORDER BY nama_produk ASC"
                );

                $no_stok = 1;


                while($stok = mysqli_fetch_assoc($data_stok)){

                ?>

                    <tr>

                        <td>

                            <?php echo $no_stok++; ?>

                        </td>


                        <td>

                            <?php echo $stok['nama_produk']; ?>

                        </td>


                        <td>

                            <?php echo $stok['stok']; ?>

                        </td>


                        <td>

                            <?php if($stok['stok'] <= 5){ ?>

                                <span class="text-danger">

                                    ⚠️ Stok Menipis

                                </span>

                            <?php }else{ ?>

                                <span class="text-success">

                                    ✅ Stok Aman

                                </span>

                            <?php } ?>

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