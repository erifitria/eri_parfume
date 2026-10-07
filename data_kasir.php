<?php
session_start();
include "koneksi.php";

/* CEK LOGIN ADMIN */
if(!isset($_SESSION['login'])){
    header("Location: login_admin.php");
    exit;
}

if($_SESSION['level'] != 'admin'){
    header("Location: dashboard.php");
    exit;
}


/* =========================
   TAMBAH KASIR
========================= */

if(isset($_POST['tambah'])){

    $nama = $_POST['nama_kasir'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    mysqli_query($koneksi, "
        INSERT INTO kasir
        (nama_kasir, username, password, level)
        VALUES
        ('$nama', '$username', '$password', 'kasir')
    ");

    header("Location: data_kasir.php");
    exit;
}


/* =========================
   EDIT KASIR
========================= */

if(isset($_POST['edit'])){

    $id = $_POST['id_kasir'];
    $nama = $_POST['nama_kasir'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    mysqli_query($koneksi, "
        UPDATE kasir SET
        nama_kasir='$nama',
        username='$username',
        password='$password'
        WHERE id_kasir='$id'
        AND level='kasir'
    ");

    header("Location: data_kasir.php");
    exit;
}


/* =========================
   HAPUS KASIR
========================= */

if(isset($_GET['hapus'])){

    $id = $_GET['hapus'];

    mysqli_query($koneksi, "
        DELETE FROM kasir
        WHERE id_kasir='$id'
        AND level='kasir'
    ");

    header("Location: data_kasir.php");
    exit;
}


/* =========================
   AMBIL DATA UNTUK EDIT
========================= */

$edit_data = null;

if(isset($_GET['edit'])){

    $id = $_GET['edit'];

    $ambil = mysqli_query($koneksi, "
        SELECT * FROM kasir
        WHERE id_kasir='$id'
        AND level='kasir'
    ");

    $edit_data = mysqli_fetch_assoc($ambil);
}


/* =========================
   SEARCH KASIR
========================= */

$keyword = "";

if(isset($_GET['cari'])){
    $keyword = $_GET['cari'];
}


/* =========================
   TAMPIL DATA KASIR
========================= */

$data = mysqli_query($koneksi, "
    SELECT * FROM kasir
    WHERE level='kasir'
    AND (
        nama_kasir LIKE '%$keyword%'
        OR username LIKE '%$keyword%'
        OR password LIKE '%$keyword%'
    )
    ORDER BY id_kasir DESC
");

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Data Kasir | ERI Parfume</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

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


<!-- SIDEBAR -->

<div class="sidebar">

<h3>🫧 ERI PARFUME</h3>

<p class="role">ADMIN</p>

<hr>

<a href="produk.php">
📦 Data Produk
</a>

<a href="pelanggan.php">
👥 Data Pelanggan
</a>

<a href="data_kasir.php">
👤 Data Kasir
</a>

<a href="laporan.php">
📊 Laporan
</a>

<a href="login.php">
🏃 Logout
</a>

</div>



<!-- CONTENT -->

<div class="content">

<h2>👤 Data Kasir</h2>

<p class="text-muted">
Kelola akun kasir ERI Parfume.
</p>



<!-- FORM TAMBAH / EDIT -->

<div class="card p-4 mt-4">

<h4>

<?php if($edit_data){ ?>

✏️ Edit Kasir

<?php }else{ ?>

➕ Tambah Kasir

<?php } ?>

</h4>


<form method="POST">


<?php if($edit_data){ ?>

<input
type="hidden"
name="id_kasir"
value="<?php echo $edit_data['id_kasir']; ?>"
>

<?php } ?>



<div class="mb-3">

<label>Nama Kasir</label>

<input
type="text"
name="nama_kasir"
class="form-control"
value="<?php echo $edit_data ? $edit_data['nama_kasir'] : ''; ?>"
required
>

</div>



<div class="mb-3">

<label>Username</label>

<input
type="text"
name="username"
class="form-control"
value="<?php echo $edit_data ? $edit_data['username'] : ''; ?>"
required
>

</div>



<div class="mb-3">

<label>Password</label>

<input
type="text"
name="password"
class="form-control"
value="<?php echo $edit_data ? $edit_data['password'] : ''; ?>"
required
>

</div>



<?php if($edit_data){ ?>

<button
type="submit"
name="edit"
class="btn btn-warning"
>
💾 Simpan Perubahan
</button>


<a
href="data_kasir.php"
class="btn btn-secondary"
>
Batal
</a>


<?php }else{ ?>


<button
type="submit"
name="tambah"
class="btn btn-pink"
>
➕ Tambah Kasir
</button>


<?php } ?>


</form>

</div>



<!-- DATA KASIR -->

<div class="card p-4 mt-4">

<h4 class="mb-3">
📋 Daftar Kasir
</h4>


<!-- SEARCH -->

<form method="GET" class="mb-3">

    <div class="input-group">

        <input
            type="text"
            name="cari"
            class="form-control"
            placeholder="🔍 Cari kasir..."
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

<th>Nama Kasir</th>

<th>Username</th>
<th>Password</th>

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
<?php echo $row['nama_kasir']; ?>
</td>


<td>
<?php echo $row['username']; ?>
</td>

<td><?php echo $row['password']; ?></td>


<td>


<!-- EDIT -->

<a
href="data_kasir.php?edit=<?php echo $row['id_kasir']; ?>"
class="btn btn-warning btn-sm"
>
✏️ Edit
</a>


<!-- HAPUS -->

<a
href="data_kasir.php?hapus=<?php echo $row['id_kasir']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Yakin ingin menghapus kasir ini?')"
>
🗑️ Hapus
</a>


</td>

</tr>


<?php } ?>


<?php if($no == 1){ ?>

<tr>

<td colspan="4" class="text-center">
Belum ada data kasir.
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