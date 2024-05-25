<?php
include('koneksi/koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_departemen'])) {
    $id_departemen = $_POST['id_departemen'];

    // Query untuk mendapatkan data Program Studi berdasarkan ID Departemen
    $sql_prodi = "SELECT * FROM prodi WHERE id_departemen_prodi = $id_departemen";
    $query_prodi = mysqli_query($koneksi, $sql_prodi);

    $data_prodi = array();

    while ($row = mysqli_fetch_assoc($query_prodi)) {
        $data_prodi[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($data_prodi);
    exit();
} else {
    header('HTTP/1.1 400 Bad Request');
    exit();
}
