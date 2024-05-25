<?php
include('koneksi/koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $userId = $_POST['id_user'];
    $newUsername = $_POST['username']; 
    $newEmail = $_POST['email'];
    $newPassword = $_POST['password'];

    $hashedPassword = md5($newPassword);

    // Update user data in the database
    $updateSql = "UPDATE `user` SET `username`='$newUsername', `email`='$newEmail',`password`='$hashedPassword' WHERE `id_user`='$userId'";
    $updateQuery = mysqli_query($koneksi, $updateSql);

    if ($updateQuery) {
        // Redirect to the user list page with a success message
        header("Location: user.php?notif=editberhasil");
        exit();
    } else {
        // Redirect to the user list page with an error message
        header("Location: user.php?notif=gagal");
        exit();
    }
} else {
    // Redirect to the user list page if accessed directly without form submission
    header("Location: user.php");
    exit();
}
?>
