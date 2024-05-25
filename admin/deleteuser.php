<?php
include('koneksi/koneksi.php');

// Check if user ID is provided in the URL
if (isset($_GET['id_user'])) {
    $userId = $_GET['id_user'];

    // Delete user based on the provided ID
    $deleteSql = "DELETE FROM `user` WHERE `id_user`='$userId'";
    $deleteQuery = mysqli_query($koneksi, $deleteSql);

    if ($deleteQuery) {
        echo '<script>alert("User deleted successfully.");</script>';
        // Redirect to the user list page with a success message
        header("Location: user.php?notif=deleteberhasil");
        exit();
    } else {
        // Redirect to the user list page with an error message
        header("Location: user.php?notif=gagal");
        exit();
    }
} else {
    // Redirect to the user list page if no user ID is provided
    header("Location: user.php");
    exit();
}
?>
