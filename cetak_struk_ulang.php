<?php
include "koneksi.php";

$id = $_GET['id'];


/* Ambil data transaksi */
$data = mysqli_query($koneksi, "
    SELECT penjualan.*, pelanggan.nama_pelanggan, kasir.nama_kasir
    FROM penjualan
    LEFT JOIN pelanggan
    ON penjualan.id_pelanggan = pelanggan.id_pelanggan
    LEFT JOIN kasir
    ON penjualan.id_kasir = kasir.id_kasir
    WHERE penjualan.id_penjualan='$id'
");

$transaksi = mysqli_fetch_assoc($data);


/* Ambil detail produk */
$detail = mysqli_query($koneksi, "
    SELECT detail_penjualan.*, produk.nama_produk
    FROM detail_penjualan
    LEFT JOIN produk
    ON detail_penjualan.id_produk = produk.id_produk
    WHERE detail_penjualan.id_penjualan='$id'
");
?>


<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Cetak Struk Ulang | ERI Perfume</title>

    <style>

        body{
            font-family:Arial, sans-serif;
            background:#f5f5f5;
        }

        .struk{
            width:350px;
            margin:30px auto;
            background:white;
            padding:20px;
            box-sizing:border-box;
        }

        h2{
            text-align:center;
            margin:0;
        }

        .tengah{
            text-align:center;
        }

        hr{
            border:none;
            border-top:1px dashed #555;
            margin:15px 0;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        td{
            padding:5px 0;
            vertical-align:top;
        }

        .kanan{
            text-align:right;
        }

        .total{
            font-weight:bold;
            font-size:17px;
        }

        .tombol{
            text-align:center;
            margin-top:20px;
        }

        button{
            padding:10px 15px;
            border:none;
            border-radius:6px;
            cursor:pointer;
            margin:3px;
        }

        .cetak{
            background:#28a745;
            color:white;
        }

        .kembali{
            background:#6c757d;
            color:white;
        }


        @media print{

            body{
                background:white;
            }

            .struk{
                margin:0 auto;
            }

            .tombol{
                display:none;
            }

        }

    </style>

</head>


<body>


<div class="struk">

    <h2>🌸 ERI PERFUME</h2>

    <p class="tengah">
        Struk Pembelian
    </p>

    <p class="tengah">
        Dicetak:
        <span id="tanggalCetak"></span>
    </p>


    <hr>


    <p>
        No Transaksi :
        <?php echo $transaksi['id_penjualan']; ?>
    </p>

    <p>
        Tanggal :
        <?php echo $transaksi['tanggal']; ?>
    </p>

    <p>
        Pelanggan :
        <?php echo $transaksi['nama_pelanggan']; ?>
    </p>

    <p>
        Kasir :
        <?php echo $transaksi['nama_kasir']; ?>
    </p>


    <hr>


    <table>

        <?php while($d = mysqli_fetch_assoc($detail)){ ?>

        <tr>

            <td>

                <?php echo $d['nama_produk']; ?>

                <br>

                <?php echo $d['jumlah']; ?>
                x
                Rp<?php echo number_format($d['harga'],0,',','.'); ?>

            </td>


            <td class="kanan">

                Rp<?php echo number_format($d['subtotal'],0,',','.'); ?>

            </td>

        </tr>

        <?php } ?>

    </table>


    <hr>


    <p>
    Metode Pembayaran :
    <?php echo $transaksi['metode_pembayaran']; ?>
</p>


<p class="total">

    Total :
    Rp<?php echo number_format($transaksi['total_bayar'],0,',','.'); ?>

</p>


<p>

    Uang Bayar :
    Rp<?php echo number_format($transaksi['bayar'],0,',','.'); ?>

</p>


<p>

    Kembalian :
    Rp<?php echo number_format($transaksi['kembalian'],0,',','.'); ?>

</p>


<hr>


    <hr>


    <p class="tengah">

        Terima kasih sudah berbelanja 💗

    </p>


</div>



<div class="tombol">

    <button
        class="cetak"
        onclick="window.print()"
    >
        🖨️ Cetak Struk
    </button>


    <button
        class="kembali"
        onclick="window.location='data_transaksi.php'"
    >
        ⬅️ Kembali ke Data Transaksi
    </button>

</div>



<script>

let sekarang = new Date();

let tanggal = sekarang.toLocaleDateString('id-ID');

let jam = sekarang.toLocaleTimeString('id-ID');

document.getElementById('tanggalCetak').innerHTML =
    tanggal + ' ' + jam;

</script>


</body>

</html>