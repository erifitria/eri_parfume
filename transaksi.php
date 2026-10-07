<?php
session_start();
include "koneksi.php";


/* TAMBAH PELANGGAN BARU */

if(isset($_POST['tambah_pelanggan'])){

    $nama_pelanggan = $_POST['nama_pelanggan'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];

    mysqli_query($koneksi, "
        INSERT INTO pelanggan
        (nama_pelanggan, no_hp, alamat, email)
        VALUES
        ('$nama_pelanggan', '$no_hp', '$alamat', '$email')
    ");

    echo "<script>
            alert('Pelanggan berhasil ditambahkan!');
            window.location='transaksi.php';
          </script>";

    exit;
}


/* Ambil data pelanggan */
$pelanggan = mysqli_query($koneksi, "SELECT * FROM pelanggan");

/* Ambil data produk */
$produk = mysqli_query($koneksi, "SELECT * FROM produk");
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Transaksi | ERI Parfume</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>

        *{
            font-family:'Poppins',sans-serif;
        }

        body{
            background:#fff5fa;
        }

        .navbar{
            background:#ff7aa2;
        }

        .card{
            border:none;
            border-radius:18px;
            box-shadow:0 8px 20px rgba(0,0,0,.1);
        }

        .btn-pink{
            background:#ff7aa2;
            color:white;
        }

        .btn-pink:hover{
            background:#ff5a92;
            color:white;
        }

    </style>

</head>

<body>

<!-- NAVBAR -->

<nav class="navbar navbar-dark">

    <div class="container">

        <span class="navbar-brand fw-bold">
           🫧 ERI PARFUME
        </span>

        <a href="dashboard.php" class="btn btn-light btn-sm">
            ⬅️ Dashboard
        </a>

    </div>

</nav>


<!-- ISI -->

<div class="container mt-4">

    <h3 class="mb-4">
        🛒 Transaksi Penjualan
    </h3>


    <!-- TAMBAH PELANGGAN BARU -->

    <div class="card p-4 mb-4">

        <h5 class="mb-3">
            ➕ Tambah Pelanggan Baru
        </h5>

        <form method="POST">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="mb-2">
                        👤 Nama Pelanggan
                    </label>

                    <input
                        type="text"
                        name="nama_pelanggan"
                        class="form-control"
                        required
                    >

                </div>


                <div class="col-md-6 mb-3">

                    <label class="mb-2">
                        📱 No HP
                    </label>

                    <input
                        type="text"
                        name="no_hp"
                        class="form-control"
                        required
                    >

                </div>


                <div class="col-md-6 mb-3">

                    <label class="mb-2">
                        🏠 Alamat
                    </label>

                    <input
                        type="text"
                        name="alamat"
                        class="form-control"
                        required
                    >

                </div>


                <div class="col-md-6 mb-3">

                    <label class="mb-2">
                        📧 Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        required
                    >

                </div>

            </div>


            <button
                type="submit"
                name="tambah_pelanggan"
                class="btn btn-pink"
            >
                💾 Simpan Pelanggan
            </button>

        </form>

    </div>



    <!-- TRANSAKSI -->

    <div class="card p-4">

        <form action="simpan_transaksi.php" method="POST">


        <!-- KASIR YANG MELAYANI -->

<div class="mb-3">

    <label class="mb-2">
        👩‍💼 Kasir yang Melayani
    </label>

    <input
        type="text"
        class="form-control"
        value="<?php echo $_SESSION['nama_kasir']; ?>"
        readonly
    >

</div>
            <!-- PELANGGAN -->

            <div class="mb-3">

                <label class="mb-2">
                    👤 Pelanggan
                </label>

                <select name="id_pelanggan" class="form-select" required>

                    <option value="">
                        -- Pilih Pelanggan --
                    </option>

                    <?php while($p = mysqli_fetch_assoc($pelanggan)){ ?>

                        <option value="<?php echo $p['id_pelanggan']; ?>">
                            <?php echo $p['nama_pelanggan']; ?>
                        </option>

                    <?php } ?>

                </select>

            </div>


            <!-- PRODUK -->

            <div class="row">

                <div class="col-md-5 mb-3">

                    <label class="mb-2">
                        🧴 Produk
                    </label>

                    <select id="produk" class="form-select">

                        <option value="">
                            -- Pilih Produk --
                        </option>

                        <?php while($pr = mysqli_fetch_assoc($produk)){ ?>

                            <option
                                value="<?php echo $pr['id_produk']; ?>"
                                data-nama="<?php echo $pr['nama_produk']; ?>"
                                data-ukuran="<?php echo $pr['ukuran']; ?>"
                                data-harga="<?php echo $pr['harga']; ?>"
                            >

                                <?php echo $pr['nama_produk']; ?>
                                -
                                <?php echo $pr['ukuran']; ?>

                            </option>

                        <?php } ?>

                    </select>

                </div>


                <!-- JUMLAH -->

                <div class="col-md-3 mb-3">

                    <label class="mb-2">
                        📦 Jumlah
                    </label>

                    <input
                        type="number"
                        id="jumlah"
                        class="form-control"
                        value="1"
                        min="1"
                    >

                </div>


                <!-- TOMBOL TAMBAH -->

                <div class="col-md-4 mb-3 d-flex align-items-end">

                    <button
                        type="button"
                        class="btn btn-pink w-100"
                        onclick="tambahProduk()"
                    >
                        ➕ Tambah Produk
                    </button>

                </div>

            </div>


            <!-- DAFTAR BELANJA -->

            <div class="mt-3">

                <h5>
                    🛍️ Daftar Belanja
                </h5>

                <table class="table table-bordered text-center">

                    <thead class="table-danger">

                        <tr>

                            <th>No</th>

                            <th>Produk</th>

                            <th>Jumlah</th>

                            <th>Harga</th>

                            <th>Subtotal</th>

                            <th>Aksi</th>

                        </tr>

                    </thead>

                    <tbody id="daftarProduk">

                    </tbody>

                </table>

            </div>


            <!-- TOTAL -->

            <div class="text-end mt-3">

                <h4>
                    Total :
                    <span id="totalTampilan">Rp0</span>
                </h4>

            </div>


            <!-- METODE PEMBAYARAN -->

            <div class="row mt-3">

                <div class="col-md-6">

                    <label class="mb-2">
                        💳 Metode Pembayaran
                    </label>

                    <select
                        name="metode"
                        class="form-select"
                        required
                    >

                        <option value="Tunai">
                            Tunai
                        </option>

                        <option value="QRIS">
                            QRIS
                        </option>

                    </select>

                </div>

            </div>


            <!-- UANG BAYAR DAN KEMBALIAN -->

            <div class="row mt-3">

                <div class="col-md-6">

                    <label class="mb-2">
                        💵 Uang Bayar
                    </label>

                    <input
                        type="text"
                        name="bayar"
                        id="bayar"
                        class="form-control"
                        placeholder="Contoh: 1.000.000"
                        oninput="hitungKembalian()"
                        required
                    >

                </div>


                <div class="col-md-6">

                    <label class="mb-2">
                        💰 Kembalian
                    </label>

                    <input
                        type="text"
                        id="kembalianTampilan"
                        class="form-control"
                        value="Rp0"
                        readonly
                    >

                    <input
                        type="hidden"
                        name="kembalian"
                        id="kembalian"
                        value="0"
                    >

                </div>

            </div>


            <!-- TOMBOL -->

            <div class="text-end mt-4">

                <button
                    type="submit"
                    class="btn btn-pink"
                >
                    💾 Simpan Transaksi
                </button>

            </div>

        </form>

    </div>

</div>


<!-- JAVASCRIPT -->

<script>

var nomor = 1;

var total = 0;


function tambahProduk(){

    var produk = document.getElementById("produk");

    var jumlah = document.getElementById("jumlah");

    var pilihan = produk.options[produk.selectedIndex];


    if(pilihan.value == ""){

        alert("Silakan pilih produk!");

        return;

    }


    var id_produk = pilihan.value;

    var nama_produk = pilihan.getAttribute("data-nama");

    var ukuran = pilihan.getAttribute("data-ukuran");

    var harga = Number(pilihan.getAttribute("data-harga"));

    var qty = Number(jumlah.value);


    var subtotal = harga * qty;


    var tabel = document.getElementById("daftarProduk");


    var baris = tabel.insertRow();


    baris.innerHTML =

        "<td>" + nomor + "</td>" +

        "<td>" + nama_produk + " - " + ukuran +

        "<input type='hidden' name='id_produk[]' value='" + id_produk + "'>" +

        "</td>" +

        "<td>" + qty +

        "<input type='hidden' name='jumlah[]' value='" + qty + "'>" +

        "</td>" +

        "<td>Rp" + harga.toLocaleString("id-ID") + "</td>" +

        "<td>Rp" + subtotal.toLocaleString("id-ID") + "</td>" +

        "<td>" +

        "<button type='button' class='btn btn-danger btn-sm' onclick='hapusProduk(this," + subtotal + ")'>" +

        "🗑️ Hapus" +

        "</button>" +

        "</td>";


    total = total + subtotal;


    document.getElementById("totalTampilan").innerHTML =

        "Rp" + total.toLocaleString("id-ID");


    nomor++;

    hitungKembalian();

}


function hapusProduk(tombol, subtotal){

    tombol.parentElement.parentElement.remove();


    total = total - subtotal;


    document.getElementById("totalTampilan").innerHTML =

        "Rp" + total.toLocaleString("id-ID");


    hitungKembalian();

}


function hitungKembalian(){

    var inputBayar = document.getElementById("bayar");

    var angkaBayar = inputBayar.value.replace(/[^0-9]/g, "");

    var bayar = Number(angkaBayar);


    if(angkaBayar != ""){

        inputBayar.value = bayar.toLocaleString("id-ID");

    }


    var kembalian = bayar - total;


    if(kembalian < 0){

        kembalian = 0;

    }


    document.getElementById("kembalian").value = kembalian;


    document.getElementById("kembalianTampilan").value =

        "Rp" + kembalian.toLocaleString("id-ID");

}

</script>


</body>

</html>