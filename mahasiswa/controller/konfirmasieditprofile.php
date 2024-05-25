<?php
include('../../admin/koneksi/koneksi.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['inputPassword'];
    $passwordconfirm = $_POST['confirmpassword'];

    if ($password == $passwordconfirm) {
        if (isset($_SESSION['id_mahasiswa'])) {
            $id_mahasiswa = $_SESSION['id_mahasiswa'];

            $nama = $_POST['inputNama'];
            $nim = $_POST['inputNIM'];
            $idprodi = $_POST['inputIdProdi'];
            $email = $_POST['inputEmail'];
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "UPDATE mahasiswa SET 
                   nama_mahasiswa = '$nama',
                   id_prodi_mahasiswa = '$idprodi',
                   email_mahasiswa = '$email',
                   password = '$hashedPassword'
                   WHERE id_mahasiswa = $id_mahasiswa";

            $result = mysqli_query($koneksi, $sql);

            if ($result) {
                header('Location: ../edit-user.php?success=successinput');
                exit();
            } else {
                header("Location:../edit-user.php?failed=updatefailed");
                exit();
            }
        } else {
            header("Location:../edit-user.php?failed=sessionError");
            exit();
        }
    } else {
        header("Location:../edit-user.php?failed=passnotcorrect");
        exit();
    }
}
