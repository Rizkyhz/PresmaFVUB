<?php
include('../../admin/koneksi/koneksi.php');

if (isset($_POST['submit'])) {
    $nim = $_POST['nim_mahasiswa'];
    $id_mahasiswa = $_POST['id_mahasiswa'];

    if (isset($_FILES['fileInput'])) {
        $file = $_FILES['fileInput'];

        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions)) {
            header("Location:../edit-user.php?failed=invalidfile");
            exit();
        }

        $maxFileSize = 5 * 1024 * 1024;
        if ($file['size'] > $maxFileSize) {
            header("Location:../edit-user.php?failed=toolargefile");
            exit();
        }

        $fileName = 'fotoprofil-' . $nim . '.' . $fileExtension;
        $filePath = '../../img/profilepicture/' . $fileName;
        $dir = '/img/profilepicture/' . $fileName;

        move_uploaded_file($file['tmp_name'], $filePath);

        $sql = "UPDATE mahasiswa SET profile_path = '$dir' WHERE id_mahasiswa = '$id_mahasiswa'";

        $result = mysqli_query($koneksi, $sql);

        if ($result) {
            header('Location: ../edit-user.php?success=uploadsuccess');
            exit();
        } else {
            header("Location:../edit-user.php?failed=uploadfailed");
            exit();
        }
    } else {
        header("Location:../edit-user.php?failed=nofileselected");
        exit();
    }
}
