<?php
include('koneksi/koneksi.php');

if ($koneksi) {
    echo 'Database connected successfully';
} else {
    echo 'Error connecting to the database: ' . mysqli_connect_error();
}


if (isset($_POST['id_bidang'])) {
    $id_bidang = $_POST['id_bidang'];

    // Fetch jenis kejuaraan options based on selected bidang
    $sql_jenis_kejuaraan = "SELECT * FROM jeniskejuaraan WHERE id_bidang = $id_bidang";
    $query_jenis_kejuaraan = mysqli_query($koneksi, $sql_jenis_kejuaraan);

    if ($query_jenis_kejuaraan) {
        echo '<option value="">Select Jenis Kejuaraan</option>';

        while ($row_jenis_kejuaraan = mysqli_fetch_assoc($query_jenis_kejuaraan)) {
            echo "<option value='" . $row_jenis_kejuaraan['id_jeniskej'] . "'>" . $row_jenis_kejuaraan['jenis_kejuaraan'] . "</option>";
        }
    } else {
        echo '<option value="">Error fetching jenis kejuaraan</option>';
    }
} else {
    echo '<option value="">Invalid Request</option>';
}
?>
