<?php
include "koneksi.php";
session_start();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$email = $_POST['email'] ?? '';
$tipe_user = $_POST['tipe_user'] ?? 'customer'; 

if (empty($username) || empty($password)) {
    $_SESSION['reg_error'] = "Username dan password harus diisi!";
    header("Location: register.php");
    exit;
}


$cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
if (mysqli_num_rows($cek) > 0) {
    $_SESSION['reg_error'] = "Username sudah terdaftar!";
    header("Location: register.php");
    exit;
}


$query = "INSERT INTO users (username, email, password, tipe_user) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $password, $tipe_user);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['reg_success'] = "Registrasi berhasil! Silakan login.";
    header("Location: login.php");
    exit;
} else {
    $_SESSION['reg_error'] = "Terjadi kesalahan saat registrasi.";
    header("Location: register.php");
    exit;
}
?>
