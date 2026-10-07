<?php
include "koneksi.php";

if(isset($_POST['simpan'])){

    $nama   = $_POST['nama_pelanggan'];
    $no_hp  = $_POST['no_hp'];
    $alamat = $_POST['alamat'];
    $email  = $_POST['email'];

    $query = mysqli_query($koneksi, "INSERT INTO pelanggan
    (nama_pelanggan, no_hp, alamat, email)
    VALUES
    ('$nama', '$no_hp', '$alamat', '$email')");

    if($query){
        echo "<script>
                alert('👥 Pelanggan berhasil ditambahkan!');
                window.location='pelanggan.php';
              </script>";
    }else{
        echo "<script>
                alert('❌ Pelanggan gagal ditambahkan!');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pelanggan | ERI Perfume</title>

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
                👥 Tambah Pelanggan
            </h3>

            <form method="POST">

                <div class="mb-3">
                    <label>👤 Nama Pelanggan</label>
                    <input type="text"
                           name="nama_pelanggan"
                           class="form-control"
                           placeholder="Masukkan nama pelanggan"
                           required>
                </div>

                <div class="mb-3">
                    <label>📱 No HP</label>
                    <input type="text"
                           name="no_hp"
                           class="form-control"
                           placeholder="Masukkan nomor HP"
                           required>
                </div>

                <div class="mb-3">
                    <label>🏠 Alamat</label>
                    <textarea name="alamat"
                              class="form-control"
                              placeholder="Masukkan alamat"
                              required></textarea>
                </div>

                <div class="mb-3">
                    <label>📧 Email</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           placeholder="Masukkan email"
                           required>
                </div>

                <button type="submit"
                        name="simpan"
                        class="btn btn-pink w-100">
                    💾 Simpan Pelanggan
                </button>

                <a href="pelanggan.php"
                   class="btn btn-secondary w-100 mt-2">
                    ⬅️ Kembali
                </a>

            </form>

        </div>

    </div>

</div>

</body>
</html>