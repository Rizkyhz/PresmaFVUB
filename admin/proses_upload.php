<!-- <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_dir = "uploads/"; // Direktori tempat menyimpan file
    $target_file_surattugas = $target_dir . basename($_FILES["scan_surattugas"]["name"]);
    $target_file_sertifikat = $target_dir . basename($_FILES["scan_sertifikat"]["name"]);

    // Pindahkan file ke direktori yang ditentukan
    if (move_uploaded_file($_FILES["scan_surattugas"]["tmp_name"], $target_file_surattugas) &&
        move_uploaded_file($_FILES["scan_sertifikat"]["tmp_name"], $target_file_sertifikat)) {
        echo "File berhasil diunggah.";
    } else {
        echo "Terjadi kesalahan saat mengunggah file.";
    }
}
?> -->
