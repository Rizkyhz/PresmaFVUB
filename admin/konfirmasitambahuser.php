<?php
session_start();
include('koneksi/koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirim melalui form
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $id_role = $_POST["id_role"];

    // Query untuk menambahkan user ke tabel user
    $queryTambahUser = "INSERT INTO user (username, email, password, id_role) VALUES ('$username', '$email', '$password', '$id_role')";

    // Eksekusi query
    $resultTambahUser = mysqli_query($koneksi, $queryTambahUser);

    if ($resultTambahUser) {
        // Jika tambah user berhasil, redirect ke halaman data user
        header("Location: user.php");
        exit();
    } else {
        // Jika terjadi kesalahan, tampilkan pesan error
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>