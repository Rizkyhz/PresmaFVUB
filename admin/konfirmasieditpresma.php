<?php
session_start();
include('koneksi/koneksi.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the form
    $id_prestasi = $_POST['id_prestasi'];
    $id_mahasiswa = $_POST['id_mahasiswa'];
    $nama_prestasi = $_POST['nama_prestasi'];
    $tanggal_pelaksanaan = $_POST['tanggal_pelaksanaan'];
    $lembaga_penyelenggara = $_POST['lembaga_penyelenggara'];
    $lokasi = $_POST['lokasi'];
    $capaian = $_POST['capaian'];
    $no_surattugas = $_POST['no_surattugas'];
    $id_bidang = $_POST['id_bidang'];
    $id_jenis_kejuaraan = $_POST['id_jenis_kejuaraan'];
    $id_tingkat_kejuaraan = $_POST['id_tingkat_kejuaraan'];
    $jenis_kepesertaan = $_POST['jenis_kepesertaan'];

    // Update the prestasi data in the database
    $update_query = "UPDATE `prestasimahasiswa` SET
        `id_mahasiswa` = '$id_mahasiswa',
        `nama_prestasi` = '$nama_prestasi',
        `tanggal_pelaksanaan` = '$tanggal_pelaksanaan',
        `lembaga_penyelenggara` = '$lembaga_penyelenggara',
        `lokasi` = '$lokasi',
        `capaian` = '$capaian',
        `no_surattugas` = '$no_surattugas',
        `id_bidang` = '$id_bidang',
        `id_jenis_kejuaraan` = '$id_jenis_kejuaraan',
        `id_tingkat_kejuaraan` = '$id_tingkat_kejuaraan'
        WHERE `id_prestasi` = '$id_prestasi'";

    // Perform the update query
    $result = mysqli_query($koneksi, $update_query);

    if ($result) {
        // Redirect to the prestasi list page if the update is successful
        header("Location: presma.php");
        exit();
    } else {
        // Handle the case where the update fails
        echo "Error updating prestasi: " . mysqli_error($koneksi);
    }
} else {
    // Redirect to the prestasi list page if the form is not submitted
    header("Location: presma.php");
    exit();
}
?>
