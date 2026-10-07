<?php
session_start();
include "koneksi.php";

if(isset($_POST['login_admin'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    // KHUSUS AKUN ADMIN
    $cek = mysqli_query($koneksi, "SELECT * FROM kasir 
            WHERE username='$username' 
            AND password='$password'
            AND level='admin'");

    if(mysqli_num_rows($cek) > 0){

        $data = mysqli_fetch_assoc($cek);

        $_SESSION['login'] = true;
        $_SESSION['id_kasir'] = $data['id_kasir'];
        $_SESSION['nama_kasir'] = $data['nama_kasir'];
        $_SESSION['level'] = $data['level'];

        header("Location: index_admin.php");
        exit;

    }else{

        echo "<script>alert('Username atau Password Admin Salah!');</script>";

    }

}
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Login Admin | ERI Parfume</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    font-family:'Poppins',sans-serif;
}

body{

    background:linear-gradient(135deg,#ffd6e7,#fff5fa);

    height:100vh;

    display:flex;

    justify-content:center;

    align-items:center;

}

.card{

    border:none;

    border-radius:20px;

    box-shadow:0 10px 30px rgba(0,0,0,.15);

    padding:20px;

}

.btn-login{

    background:#ff6fa5;

    color:white;

    border-radius:12px;

}

.btn-login:hover{

    background:#ff4f90;

    color:white;

}

.kembali{

    color:#ff6fa5;

    text-decoration:none;

    font-weight:500;

}

.kembali:hover{

    color:#ff4f90;

    text-decoration:underline;

}

</style>

</head>

<body>

<div class="col-md-4">

<div class="card">

<h2 class="text-center">
🫧 ERI PARFUME
</h2>

<p class="text-center text-muted">
🔐 Login Admin
</p>


<form method="POST">

<div class="mb-3">

<label>👤 Username Admin</label>

<input 
    type="text" 
    name="username" 
    class="form-control" 
    required
>

</div>


<div class="mb-3">

<label>🔒 Password Admin</label>

<input 
    type="password" 
    name="password" 
    class="form-control" 
    required
>

</div>


<button 
    type="submit" 
    name="login_admin" 
    class="btn btn-login w-100"
>
<a href="index_admin.php"></a>
    🔐 Login Admin
</button>


<div class="text-center mt-3">

    <a href="transaksi.php" class="kembali">
        ⬅️ Kembali ke Kasir
    </a>

</div>

</form>

</div>

</div>

</body>

</html>