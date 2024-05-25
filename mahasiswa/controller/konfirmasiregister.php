<?php

include('../../admin/koneksi/koneksi.php');

if (isset($_POST['kirim'])) {
    $password = $_POST['password'];
    $passwordconfirm = $_POST['passwordconfirm'];

    if ($password == $passwordconfirm) {
        $email = mysqli_real_escape_string($koneksi, $_POST['email_mahasiswa']);

        $checkEmailQuery = "SELECT COUNT(*) FROM mahasiswa WHERE email_mahasiswa = '$email'";
        $checkEmailResult = mysqli_query($koneksi, $checkEmailQuery);

        if (!$checkEmailResult) {
            die("Query failed: " . mysqli_error($koneksi));
        }

        $emailCount = mysqli_fetch_row($checkEmailResult)[0];

        if ($emailCount > 0) {
            header("Location:../../register.php?failed=existingEmail");
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO mahasiswa 
            (nama_mahasiswa, id_prodi_mahasiswa, nim_mahasiswa, email_mahasiswa, `password`)
            VALUES ('$_POST[nama_mahasiswa]', '$_POST[id_prodi_mahasiswa]', '$_POST[nim_mahasiswa]', '$email', '$hashed_password')";

            $stmt = mysqli_prepare($koneksi, $sql);
            if ($stmt) {
                mysqli_stmt_execute($stmt);
                header("Location:../../login.php");
            } else {
                echo "Error: " . mysqli_error($koneksi);
            }
        }
    } else {
        header("Location:../../register.php?failed=passnotcorrect");
    }
}
