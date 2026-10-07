<?php
include "koneksi.php";

$id = $_GET['id'];

$data = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$id'");
$row = mysqli_fetch_assoc($data);

if(isset($_POST['update'])){

    $nama_produk = $_POST['nama_produk'];
    $kategori    = $_POST['kategori'];
    $aroma       = $_POST['aroma'];
    $ukuran      = $_POST['ukuran'];
    $harga = str_replace('.', '', $_POST['harga']);
    $stok        = $_POST['stok'];

    $query = mysqli_query($koneksi, "UPDATE produk SET
        nama_produk='$nama_produk',
        kategori='$kategori',
        aroma='$aroma',
        ukuran='$ukuran',
        harga='$harga',
        stok='$stok'
        WHERE id_produk='$id'
    ");

    if($query){
        echo "<script>
                alert('🌸 Produk berhasil diubah!');
                window.location='produk.php';
              </script>";
    }else{
        echo "<script>
                alert('❌ Produk gagal diubah!');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk | ERI Perfume</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        *{
            font-family:'Poppins',sans-serif;
        }

        body{
            background:#fff5fa;
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

<div class="container mt-5">

    <div class="col-md-6 mx-auto">

        <div class="card p-4">

            <h3 class="text-center mb-4">
                ✏️ Edit Produk
            </h3>

            <form method="POST">

                <div class="mb-3">
                    <label>🌸 Nama Produk</label>
                    <input type="text"
                           name="nama_produk"
                           class="form-control"
                           value="<?php echo $row['nama_produk']; ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label>📂 Kategori</label>
                    <input type="text"
                           name="kategori"
                           class="form-control"
                           value="<?php echo $row['kategori']; ?>"
                           required>
                </div>


                <div class="mb-3">
                    <label>🧴 Ukuran</label>
                    <input type="text"
                           name="ukuran"
                           class="form-control"
                           value="<?php echo $row['ukuran']; ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label>💰 Harga</label>
                    <input type="text"
                           name="harga"
                           class="form-control"
                           value="<?php echo $row['harga']; ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label>📦 Stok</label>
                    <input type="number"
                           name="stok"
                           class="form-control"
                           value="<?php echo $row['stok']; ?>"
                           required>
                </div>

                <button type="submit"
                        name="update"
                        class="btn btn-pink w-100">
                    💾 Simpan Perubahan
                </button>

                <a href="produk.php"
                   class="btn btn-secondary w-100 mt-2">
                    ⬅️ Kembali
                </a>

            </form>

        </div>

    </div>

</div>

</body>
</html>