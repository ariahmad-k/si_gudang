<?php
session_start();
include "koneksi.php";

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    $_SESSION['error'] = "Username dan password harus diisi!";
    header("Location: login.php");
    exit;
}


$query = "SELECT * FROM users WHERE username = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);

    
    if ($password === $data['password']) {
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['tipe_user'] = $data['tipe_user'];

        switch ($data['tipe_user']) {
            case 'admin':
                header("Location: backend/admin/index_admin.php");
                break;
            case 'customer':
                header("Location: backend/customer/index_customer.php");
                break;
            case 'suplier':
                header("Location: backend/supplier/index_supplier.php");
                break;
            default:
                $_SESSION['error'] = "Tipe user tidak dikenali!";
                header("Location: login.php");
                break;
        }
        exit;
    } else {
        $_SESSION['error'] = "Username atau password salah!";
        header("Location: login.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Username atau password salah!";
    header("Location: login.php");
    exit;
}
?>
