<?php
include "koneksi.php";

/* SEARCH PRODUK */
$keyword = "";

if(isset($_GET['cari'])){
    $keyword = $_GET['cari'];
}

$data = mysqli_query($koneksi, "
    SELECT * FROM produk
    WHERE nama_produk LIKE '%$keyword%'
    OR kategori LIKE '%$keyword%'
    OR ukuran LIKE '%$keyword%'
    ORDER BY id_produk DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Produk | ERI Perfume</title>

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

        table{
            background:white;
            border-radius:15px;
            overflow:hidden;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-dark">
    <div class="container">
        <span class="navbar-brand fw-bold">🫧 ERI PARFUME</span>

        <a href="dashboard.php" class="btn btn-light btn-sm">
            ⬅️ Dashboard
        </a>
    </div>
</nav>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h3>📦 Data Produk</h3>

        <a href="tambah_produk.php" class="btn btn-light btn-sm">
            ➕ Tambah Produk
        </a>

    </div>

    <div class="card p-3">

        <!-- SEARCH -->

        <form method="GET" class="mb-3">

            <div class="input-group">

                <input
                    type="text"
                    name="cari"
                    class="form-control"
                    placeholder="🔍 Cari produk..."
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


        <table class="table table-bordered table-hover text-center">

            <thead class="table-danger">

                <tr>
                    <th>No</th>
                    <th>Nama Parfum</th>
                    <th>Kategori</th>
                    <th>Ukuran</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>

            </thead>

            <tbody>

<?php
$no = 1;

while($row = mysqli_fetch_assoc($data)){
?>

<tr>

<td><?= $no++; ?></td>

<td><?= $row['nama_produk']; ?></td>

<td><?= $row['kategori']; ?></td>

<td><?= $row['ukuran']; ?></td>

<td>Rp<?= number_format($row['harga'],0,',','.'); ?></td>

<td><?= $row['stok']; ?></td>

<td>

<a href="edit_produk.php?id=<?php echo $row['id_produk']; ?>"
   class="btn btn-warning btn-sm">
    ✏️ Edit
</a>

<a href="hapus_produk.php?id=<?php echo $row['id_produk']; ?>"
   class="btn btn-danger btn-sm"
   onclick="return confirm('Yakin ingin menghapus produk ini?')">
    🗑️ Hapus
</a>

</td>

</tr>

<?php
}
?>

</tbody>

        </table>

    </div>

</div>

</body>
</html>