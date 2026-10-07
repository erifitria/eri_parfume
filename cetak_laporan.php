<?php
include "koneksi.php";

$query = "SELECT 
            penjualan.tanggal,
            pelanggan.nama_pelanggan,
            penjualan.total_bayar,
            penjualan.metode_pembayaran,
            penjualan.bayar,
            penjualan.kembalian
          FROM penjualan
          LEFT JOIN pelanggan 
          ON penjualan.id_pelanggan = pelanggan.id_pelanggan
          ORDER BY penjualan.tanggal DESC";

$data = mysqli_query($koneksi, $query);

$total_semua = 0;
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Cetak Laporan Penjualan</title>

<style>

body{
    font-family:Arial,sans-serif;
    padding:30px;
}

h2{
    text-align:center;
    margin-bottom:5px;
}

p{
    text-align:center;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:25px;
}

th,td{
    border:1px solid #000;
    padding:8px;
}

th{
    text-align:center;
}

.total{
    font-weight:bold;
}

.tombol{
    margin-bottom:20px;
}

@media print{

    .tombol{
        display:none;
    }

}

</style>

</head>

<body>

<div class="tombol">

    <button onclick="window.print()">
        🖨️ Cetak
    </button>

    <a href="laporan.php">
        Kembali
    </a>

</div>


<h2>ERI PERFUME</h2>

<p>Laporan Penjualan</p>

<!-- TANGGAL DAN JAM CETAK -->

<p>
    Tanggal Cetak:
    <span id="tanggalCetak"></span>
</p>


<table>

    <thead>

        <tr>

            <th>No</th>

            <th>Tanggal</th>

            <th>Pelanggan</th>

            <th>Total Bayar</th>

            <th>Metode Pembayaran</th>

            <th>Uang Bayar</th>

            <th>Kembalian</th>

        </tr>

    </thead>


    <tbody>

    <?php

    $no = 1;

    while($row = mysqli_fetch_assoc($data)){

        $total_semua += $row['total_bayar'];

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
                echo $row['nama_pelanggan']
                    ? $row['nama_pelanggan']
                    : '-';
                ?>
            </td>

            <td>
                Rp<?php 
                echo number_format(
                    $row['total_bayar'],
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

        </tr>

    <?php } ?>


    <tr class="total">

        <td colspan="3" style="text-align:right;">
            Total Penjualan
        </td>

        <td colspan="4">

            Rp<?php 
            echo number_format(
                $total_semua,
                0,
                ',',
                '.'
            ); 
            ?>

        </td>

    </tr>

    </tbody>

</table>


<script>

/* Menampilkan tanggal dan jam saat laporan dicetak */

let sekarang = new Date();

let tanggal = sekarang.toLocaleDateString('id-ID');

let jam = sekarang.toLocaleTimeString('id-ID');

document.getElementById('tanggalCetak').innerHTML =
    tanggal + ' ' + jam;


/* Membuka halaman print */

window.print();

</script>

</body>

</html>