<?php
session_start();
include('koneksi/koneksi.php');

if ($_SESSION['id_role'] != '0') {
    // Check if the 'id' parameter is set in the URL
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        // Sanitize the input to prevent SQL injection
        $id_lomba = mysqli_real_escape_string($koneksi, $_GET['id']);

        // Perform the deletion query
        $sql_delete_lomba = "DELETE FROM info_lomba WHERE id_lomba = $id_lomba";

        if (mysqli_query($koneksi, $sql_delete_lomba)) {
        echo '<script>alert("Dosen deleted successfully.");</script>';

            // Redirect ke halaman lomba.php setelah penghapusan berhasil
            header("Location: lomba.php?notif=hapusberhasil");
            exit();
        } else {
            $_SESSION['error_message'] = "Error: " . mysqli_error($koneksi);
        }
    } else {
        $_SESSION['error_message'] = "Invalid ID parameter.";
    }

} else {
    // If not superadmin, show an error message or perform other actions as needed
    $_SESSION['error_message'] = "Anda tidak memiliki izin untuk melakukan aksi ini.";
}

// Redirect back to the main page even in case of an error
header("Location: lomba.php");
exit();
?>
