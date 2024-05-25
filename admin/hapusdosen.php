<?php
include('koneksi/koneksi.php');

// Check if user ID is provided in the URL
if (isset($_GET['id_dosen'])) {
    $userId = $_GET['id_dosen'];

    // Delete user based on the provided ID
    $deleteSql = "DELETE FROM `dosen` WHERE `id_dosen`='$userId'";
    $deleteQuery = mysqli_query($koneksi, $deleteSql);

    if ($deleteQuery) {
        // Redirect to the dosen list page with a success message
        header("Location: dosen.php?notif=deleteberhasil");
        exit();
    } else {
        // Redirect to the dosen list page with an error message
        header("Location: dosen.php?notif=gagal");
        exit();
    }
} else {
    // Redirect to the dosen list page if no dosen ID is provided
    header("Location: dosen.php");
    exit();
}
?>
