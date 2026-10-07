<?php
include "koneksi.php";

/* SEARCH PELANGGAN */
$keyword = "";

if(isset($_GET['cari'])){
    $keyword = $_GET['cari'];
}

$data = mysqli_query($koneksi, "
    SELECT * FROM pelanggan
    WHERE nama_pelanggan LIKE '%$keyword%'
    OR no_hp LIKE '%$keyword%'
    OR alamat LIKE '%$keyword%'
    OR email LIKE '%$keyword%'
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pelanggan | ERI Parfume</title>

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

        <span class="navbar-brand fw-bold">
            🫧 ERI PARFUME
        </span>

        <a href="dashboard.php" class="btn btn-light btn-sm">
            ⬅️ Dashboard
        </a>

    </div>

</nav>


<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h3>👥 Data Pelanggan</h3>

        <a href="tambah_pelanggan.php" class="btn btn-pink">
            ➕ Tambah Pelanggan
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
                    placeholder="🔍 Cari pelanggan..."
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
                    <th>Nama</th>
                    <th>No HP</th>
                    <th>Alamat</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>

            </thead>


            <tbody>

                <?php
                $no = 1;

                while($row = mysqli_fetch_assoc($data)){
                ?>

                <tr>

                    <td><?php echo $no++; ?></td>

                    <td><?php echo $row['nama_pelanggan']; ?></td>

                    <td><?php echo $row['no_hp']; ?></td>

                    <td><?php echo $row['alamat']; ?></td>

                    <td><?php echo $row['email']; ?></td>

                    <td>

                        <a href="edit_pelanggan.php?id=<?php echo $row['id_pelanggan']; ?>"
                           class="btn btn-warning btn-sm">
                            ✏️ Edit
                        </a>

                        <a href="hapus_pelanggan.php?id=<?php echo $row['id_pelanggan']; ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Yakin ingin menghapus pelanggan ini?')">
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