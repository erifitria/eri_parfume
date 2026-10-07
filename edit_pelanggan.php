<?php
include "koneksi.php";

$id = $_GET['id'];

$data = mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE id_pelanggan='$id'");
$row = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {

    $nama   = $_POST['nama_pelanggan'];
    $no_hp  = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    mysqli_query($koneksi, "UPDATE pelanggan SET
        nama_pelanggan='$nama',
        no_hp='$no_hp',
        alamat='$alamat'
        WHERE id_pelanggan='$id'
    ");

    echo "<script>
        alert('Data pelanggan berhasil diubah!');
        window.location='pelanggan.php';
    </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pelanggan</title>

    <style>
        body {
            font-family: Arial;
            background: #fff5fa;
        }

        .box {
            width: 400px;
            margin: 50px auto;
            background: white;
            padding: 25px;
            border-radius: 15px;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 8px 0 15px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #e75480;
            color: white;
            border: none;
            border-radius: 8px;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>

<body>

<div class="box">

    <h2>✏️ Edit Pelanggan</h2>

    <form method="POST">

        <label>👤 Nama Pelanggan</label>
        <input type="text" name="nama_pelanggan"
               value="<?php echo $row['nama_pelanggan']; ?>" required>

        <label>📱 No HP</label>
        <input type="text" name="no_hp"
               value="<?php echo $row['no_hp']; ?>" required>

        <label>🏠 Alamat</label>
        <textarea name="alamat" required><?php echo $row['alamat']; ?></textarea>

        <button type="submit" name="update">
            💾 Simpan Perubahan
        </button>

    </form>

    <a href="pelanggan.php">⬅️ Kembali</a>

</div>

</body>
</html>