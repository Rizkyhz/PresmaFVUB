<?php
session_start();
include('koneksi/koneksi.php');

$id = $_SESSION['id_user'];

// Ambil ID berita dari parameter URL
if (isset($_GET['id_galeri'])) {
    $id_galeri = $_GET['id_galeri'];

    // Query untuk mendapatkan data berita berdasarkan ID
    $sql_get_berita = "SELECT * FROM galeriprestasi WHERE id_galeri = '$id_galeri'";
    $result_get_berita = mysqli_query($koneksi, $sql_get_berita);

    if ($result_get_berita) {
        $data_berita = mysqli_fetch_assoc($result_get_berita);

        // Hapus file gambar terkait dari direktori upload
        $foto_berita = $data_berita['foto'];
        $file_path = "../upload/$foto_berita";
        if (file_exists($file_path)) {
            unlink($file_path); // Hapus file jika ada
        }

        // Query untuk menghapus data berita dari database
        $sql_hapus_berita = "DELETE FROM galeriprestasi WHERE id_galeri = '$id_galeri'";
        if (mysqli_query($koneksi, $sql_hapus_berita)) {
            $_SESSION['success_message'] = "Berita berhasil dihapus.";
            echo '<script>alert("Berita berhasil dihapus."); window.location.href = "berita.php";</script>';
            exit();
        } else {
            $error_message = "Error: " . mysqli_error($koneksi);
        }
    } else {
        // ID berita tidak valid, redirect ke halaman berita.php
        header("Location: berita.php");
        exit();
    }
} else {
    // Parameter ID berita tidak ditemukan, redirect ke halaman berita.php
    header("Location: berita.php");
    exit();
}
?>
