<?php
include '_parsials/_template/header.php';
include "koneksi.php";

// Cek apakah pengguna sudah login dan memiliki role admin (role_id = 2)
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    // Jika belum login atau bukan admin, redirect ke halaman login
    header("Location: index.php?page=login");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="././css/style.css"> <!-- Sesuaikan dengan file CSS Anda -->
</head>
<body>
    <div class="container">
        <h1>Selamat Datang, user <?php echo $_SESSION['fullname']; ?> !</h1>
        <p>Ini adalah halaman user dashboard.</p>
    </div>
</body>
</html>