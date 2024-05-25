<?php
session_start();
include('koneksi/koneksi.php');

// Check if the user has the necessary permission
if ($_SESSION['id_role'] == '0') {
    echo 'Anda tidak memiliki izin untuk melakukan aksi ini.';
    exit();
}

// Check if the 'id_prestasi' parameter is set in the URL
if (isset($_GET['id_prestasi'])) {
    // Get the 'id_prestasi' value from the URL
    $id_prestasi = mysqli_real_escape_string($koneksi, $_GET['id_prestasi']);

    // Delete the prestasi data from the database
    $sql_delete = "DELETE FROM prestasimahasiswa WHERE id_prestasi = $id_prestasi";
    $result_delete = mysqli_query($koneksi, $sql_delete);

    if ($result_delete) {
        echo '<script>alert("Prestasi deleted successfully.");</script>';
        // Redirect to the prestasi data page after successful deletion
        header("Location: presma.php");
        exit();
    } else {
        // Display an error message if deletion fails
        echo 'Error deleting prestasi data.';
    }
} else {
    // Display an error message if 'id_prestasi' parameter is not set
    echo 'Invalid request. Missing ID parameter.';
}
?>
