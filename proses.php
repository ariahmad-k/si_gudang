<?php
include("koneksi.php");
$action = $_GET['action'];

if ($action == "login") {
    // Login proses untuk tiga jenis pengguna: Admin, Customer, dan Supplier
    session_start();
    $username = $_POST['username'];
    $password = $_POST['password'];

    $data = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' AND password='$password'");
    $data2 = mysqli_query($koneksi, "SELECT * FROM tb_customer WHERE email_customer='$username' AND pass_customer='$password'");
    $data3 = mysqli_query($koneksi, "SELECT * FROM tb_supplier WHERE email_supplier='$username' AND pass_supplier='$password'");

    $cek = mysqli_num_rows($data);
    $cek2 = mysqli_num_rows($data2);
    $cek3 = mysqli_num_rows($data3);

    if ($cek > 0) {
        $_SESSION['username'] = $username;
        $_SESSION['tipe_user'] = "Administratior";
        echo "<script>alert('Login Berhasil Selamat Datang - Administrator');window.location='backend/admin/index_admin.php';</script>";
    } else if ($cek2 > 0) {
        $_SESSION['username'] = $username;
        $_SESSION['tipe_user'] = "Customer";
        echo "<script>alert('Login Berhasil Selamat Datang - Customer');window.location='backend/admin/index_customer.php';</script>";
    } else if ($cek3 > 0) {
        $_SESSION['username'] = $username;
        $_SESSION['tipe_user'] = "Supplier";
        echo "<script>alert('Login Berhasil Selamat Datang - Supplier');window.location='backend/admin/index_supplier.php';</script>";
    } else {
        echo "<script>alert('Login Gagal Username atau Password Tidak Sesuai');window.location='login.php';</script>";
    }

} else if ($action == "logout") {
    // Logout pengguna
    session_start();
    unset($_SESSION["username"]);
    session_unset();
    session_destroy();
    echo "<script>alert('Anda berhasil logout. Terimakasih');window.location='index.php';</script>";

} else if ($action == "register") {
    // Proses registrasi user
    $username = $_POST['username'];
    $password = $_POST['password'];

    mysqli_query($koneksi, "INSERT INTO user (id_user, username, password) VALUES(null, '$username', '$password')");
    echo "<script>alert('Registrasi berhasil silahkan login');window.location='login.php';</script>";

} else if ($action == "add_barang") {
    // Proses tambah barang baru dengan/atau tanpa gambar
    $kd_barang = mysqli_real_escape_string($koneksi, $_POST["kd_barang"]);
    $kode_jenis = mysqli_real_escape_string($koneksi, $_POST["kode_jenis"]);
    $nama_barang = mysqli_real_escape_string($koneksi, $_POST["nama_barang"]);
    $stok = (int) $_POST["stok"];
    $harga_jual = (int) $_POST["harga_jual"];
    $harga_beli = (int) $_POST["harga_beli"];
    $gambar_produk = $_FILES["gambar_produk"]["name"];

    if (!empty($gambar_produk)) {
        $ekstensi_diperbolehkan = ['jpg', 'png', 'jpeg'];
        $x = explode('.', $gambar_produk);
        $ekstensi = strtolower(end($x));
        $file_tmp = $_FILES['gambar_produk']['tmp_name'];
        $angka_acak = rand(1, 999);
        $nama_gambar_baru = $angka_acak . '-' . $gambar_produk;

        if (in_array($ekstensi, $ekstensi_diperbolehkan)) {
            if (move_uploaded_file($file_tmp, 'backend/admin/gambar/' . $nama_gambar_baru)) {
                $query = "INSERT INTO tb_barang (kd_barang, kode_jenis, nama_barang, stok, harga_beli, harga_jual, gambar_produk)
                          VALUES ('$kd_barang', '$kode_jenis', '$nama_barang', '$stok', '$harga_beli', '$harga_jual', '$nama_gambar_baru')";
                 $result= mysqli_query($koneksi, $query);
                if (!$result) die("Query gagal dijalankan: " . mysqli_error($koneksi));
                echo "<script>alert('Data berhasil ditambah.');window.location='backend/admin/data_barang.php';</script>";
            } else {
                die("Upload file gagal.");
            }
        } else {
            die("Ekstensi file tidak diperbolehkan.");
        }
    } else {
        $query = "INSERT INTO tb_barang (kd_barang, kode_jenis, nama_barang, stok, harga_beli, harga_jual, gambar_produk)
                  VALUES ('$kd_barang', '$kode_jenis', '$nama_barang', '$stok', '$harga_beli', '$harga_jual', null)";
        $result = mysqli_query($koneksi, $query);
        if (!$result) die("Query gagal dijalankan: " . mysqli_error($koneksi));
        echo "<script>alert('Data berhasil ditambah.');window.location='backend/admin/data_barang.php';</script>";
    }

} else if ($action == "edit") {
    // Edit data barang (dengan/atau tanpa gambar baru)
    $kd_barang = $_POST["kd_barang"];
    $kode_jenis = $_POST["kode_jenis"];
    $nama_barang = $_POST["nama_barang"];
    $stok = $_POST["stok"];
    $harga_beli = $_POST["harga_beli"];
    $harga_jual = $_POST["harga_jual"];

    if ($_FILES['gambar_produk']['name'] != '') {
        $gambar_produk = $_FILES["gambar_produk"]["name"];
        $x = explode('.', $gambar_produk);
        $ekstensi = strtolower(end($x));
        $file_tmp = $_FILES['gambar_produk']['tmp_name'];
        $angka_acak = rand(1, 999);
        $nama_gambar_baru = $angka_acak . '-' . $gambar_produk;

        $ekstensi_diperbolehkan = ['jpg', 'png', 'jpeg'];
        if (in_array($ekstensi, $ekstensi_diperbolehkan)) {
            move_uploaded_file($file_tmp, 'backend/admin/gambar/' . $nama_gambar_baru);
            $query = "UPDATE tb_barang SET kode_jenis='$kode_jenis', nama_barang='$nama_barang', stok='$stok',
                      harga_beli='$harga_beli', harga_jual='$harga_jual', gambar_produk='$nama_gambar_baru'
                      WHERE kd_barang='$kd_barang'";
        }
    } else {
        $query = "UPDATE tb_barang SET kode_jenis='$kode_jenis', nama_barang='$nama_barang', stok='$stok',
                  harga_beli='$harga_beli', harga_jual='$harga_jual' WHERE kd_barang='$kd_barang'";
    }

    $result = mysqli_query($koneksi, $query);
    if (!$result) die("Query gagal dijalankan: " . mysqli_error($koneksi));
    echo "<script>alert('Data berhasil diperbarui.');window.location='backend/admin/data_barang.php';</script>";

} else if ($action == "delete_barang") {
    // Hapus data barang
    $kd_barang = $_GET['kd_barang'];
    $query = "DELETE FROM tb_barang WHERE kd_barang = '$kd_barang'";
    mysqli_query($koneksi, $query);
    echo "<script>alert('Data berhasil dihapus.');window.location='backend/admin/data_barang.php';</script>";

} else if ($action == "tambah_pembelian") {
    $no_pembelian = $_POST['no_pembelian'];
    $tanggal_pembelian = $_POST['tanggal_pembelian'];
    $id_supplier = $_POST['id_supplier'];
    $total_barangall = 0; // inisialisasi default
    $total_hargaall = 0;  // inisialisasi default

    try {
        $query = "INSERT INTO tb_pembelian (no_pembelian, tanggal_pembelian, id_supplier, total_barangall, total_hargaall)
                  VALUES ('$no_pembelian', '$tanggal_pembelian', '$id_supplier', $total_barangall, $total_hargaall)";
        $result = mysqli_query($koneksi, $query);
        if (!$result) throw new Exception("Query error: " . mysqli_error($koneksi));
        
        echo "<script>alert('Data transaksi pembelian berhasil ditambah.');window.location='backend/admin/transaksi_pembelian.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Data transaksi pembelian gagal: " . $e->getMessage() . "');window.location='backend/admin/transaksi_pembelian.php';</script>";
    }
}
else if ($action == "tambah_detail_pembelian") {
    // Tambah detail pembelian dan update stok serta total pembelian
    $no_pembelian = $_POST['no_pembelian'];
    $kd_barang = $_POST['kd_barang'];
    $kode_jenis = $_POST['kode_jenis'];
    $jumlah_barang = $_POST['jumlah_barang'];
    $harga_barang = $_POST['harga_barang'];

    try {
        $stok = 0;
        $total_harga = 0;
        $total_barang = 0;

        $stok_barang = mysqli_query($koneksi, "SELECT stok FROM tb_barang WHERE kd_barang = '$kd_barang'");
        while ($d = mysqli_fetch_array($stok_barang)) {
            $stok = $d['stok'];
        }

        $stok_terkini = $jumlah_barang + $stok;
        $total_harga_satuan = $jumlah_barang * $harga_barang;

        mysqli_query($koneksi, "INSERT INTO detail_pembelian (no_pembelian, kd_barang, kode_jenis, jumlah_barang, harga_barang, total_harga)
                                VALUES ('$no_pembelian', '$kd_barang', '$kode_jenis', '$jumlah_barang', '$harga_barang', '$total_harga_satuan')");

        mysqli_query($koneksi, "UPDATE tb_barang SET stok = '$stok_terkini' WHERE kd_barang = '$kd_barang'");

        $result = mysqli_query($koneksi, "SELECT SUM(jumlah_barang) AS jumlah_barangall, SUM(total_harga) AS jumlah_hargaall FROM detail_pembelian WHERE no_pembelian = '$no_pembelian'");
        $data = mysqli_fetch_assoc($result);
        $total_barang = $data['jumlah_barangall'];
        $total_harga = $data['jumlah_hargaall'];

        mysqli_query($koneksi, "UPDATE tb_pembelian SET total_barangall = '$total_barang', total_hargaall = '$total_harga' WHERE no_pembelian = '$no_pembelian'");

        echo "<script>alert('Transaksi pembelian berhasil.');window.location='backend/admin/t_detail_pembelian.php?no_pembelian=$no_pembelian';</script>";
    } catch (mysqli_sql_exception $e) {
        echo "<script>alert('Transaksi pembelian gagal.');window.location='backend/admin/t_detail_pembelian.php?no_pembelian=$no_pembelian';</script>";
    }
}
?>