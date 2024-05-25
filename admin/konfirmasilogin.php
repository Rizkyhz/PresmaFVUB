<?php
include('koneksi/koneksi.php');
if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $username = mysqli_real_escape_string($koneksi, $user);
    $password = mysqli_real_escape_string($koneksi, MD5($pass));

    //cek username dan password
    $sql = "select `id_user`, `id_role` from `user`
                where `username`='$username' and
               `password`='$password'";
    $query = mysqli_query($koneksi, $sql);
    $jumlah = mysqli_num_rows($query);
    if (empty($user)) {
        header("Location:index.php?gagal=userKosong");
    } else if (empty($pass)) {
        header("Location:index.php?gagal=passKosong");
    } else if ($jumlah == 0) {
        header("Location:index.php?gagal=userpassSalah");
    } else if (mysqli_num_rows($query) != 0) {
        $row = mysqli_fetch_assoc($query);

        session_start();
        $_SESSION['id_user'] = $row['id_user'];
        $_SESSION['id_role'] = $row['id_role'];
        if ($row['id_role'] == '1') {
            header("Location:../admin/admin.php");
        } else if ($row['id_role'] == '0') {
            header("Location:../admin/superadmin.php");
        }
    } else {
        header("Location:../login.php");
    }
}
