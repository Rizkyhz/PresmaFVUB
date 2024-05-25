<?php
include('koneksi/koneksi.php');

// Check if the ID parameter is set in the URL
if (isset($_GET['id_mahasiswa'])) {
    $id = $_GET['id_mahasiswa'];

    // Delete the mahasiswa data from the database
    $delete_query = mysqli_query($koneksi, "DELETE FROM `mahasiswa` WHERE `id_mahasiswa` = '$id'");

    // Check if the query was successful
    if ($delete_query) {
        // Display a JavaScript alert for successful deletion
        echo '<script>alert("Mahasiswa berhasil dihapus.");</script>';

        // Redirect back to the mahasiswa list page
        header('Location: mahasiswa.php');
        exit;
    } else {
        // Handle the case where the query was not successful
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    // Handle the case where the ID parameter is not set
    echo "Invalid request. Please provide a valid Mahasiswa ID.";
    // Optionally, you can redirect to the mahasiswa list page or another appropriate page
    // header('Location: mahasiswa.php');
    // exit;
}
?>
