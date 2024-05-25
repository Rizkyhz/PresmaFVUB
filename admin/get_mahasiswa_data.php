<?php
// get_mahasiswa_data.php
include('koneksi/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nim_mahasiswa'])) {
    $nim = $_POST['nim_mahasiswa'];
    // print_r($nim);exit;

    // Query untuk mengambil data mahasiswa berdasarkan NIM
    $query = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE nim_mahasiswa= '$nim'");

    if ($row = mysqli_fetch_assoc($query)) {
        // Mengembalikan data mahasiswa dalam format JSON
        echo json_encode($row);
    } else {
        echo 'not_found';
    }
} else {
    echo 'invalid_request';
}
?>
