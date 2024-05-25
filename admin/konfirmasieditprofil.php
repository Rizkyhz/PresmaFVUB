<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pastikan pengguna memiliki sesi yang aktif
    if (!isset($_SESSION['id_user'])) {
        header("Location: index.php");
        exit();
    }

    // Tangkap data yang dikirimkan dari formulir
    $newUsername = $_POST['username'];
    $newEmail = $_POST['email'];

    // Validasi data jika diperlukan

    // Lanjutkan dengan pembaruan data profil ke database
    include('koneksi/koneksi.php');
    $id_user = $_SESSION['id_user'];

    $updateQuery = "UPDATE `user` SET `username`='$newUsername', `email`='$newEmail' WHERE `id_user`=$id_user";

    if (mysqli_query($koneksi, $updateQuery)) {
        // Jika pembaruan berhasil, arahkan kembali ke halaman profil dengan notifikasi
        header("Location: profil.php?notif=editberhasil");
        exit();
    } else {
        // Jika terjadi kesalahan, arahkan kembali ke halaman profil dengan notifikasi error
        header("Location: profil.php?notif=editgagal");
        exit();
    }
} else {
    // Jika halaman diakses langsung tanpa menggunakan metode POST, arahkan ke halaman lain atau tampilkan pesan kesalahan
    header("Location: index.php");
    exit();
}
?>
