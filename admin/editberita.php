<?php
session_start();
include('koneksi/koneksi.php');

$id = $_SESSION['id_user'];

// Pastikan direktori upload ada atau buat jika belum ada
$target_dir = "../upload/";
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// Ambil ID berita dari parameter URL
if (isset($_GET['id_galeri'])) {
    $id_galeri = $_GET['id_galeri'];

    // Query untuk mendapatkan data berita berdasarkan ID
    $sql_get_berita = "SELECT * FROM galeriprestasi WHERE id_galeri = '$id_galeri'";
    $result_get_berita = mysqli_query($koneksi, $sql_get_berita);

    if ($result_get_berita) {
        $data_berita = mysqli_fetch_assoc($result_get_berita);

        // Proses update berita
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $judul_berita = $_POST['judul_berita'];
            $foto = $_FILES['foto']['name'];
            $isi_berita = $_POST['isi_berita'];

            // Proses upload foto jika ada perubahan
            if (!empty($foto)) {
                $target_file = $target_dir . basename($_FILES['foto']['name']);
                move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);
            } else {
                // Jika tidak ada perubahan pada foto, gunakan foto yang sudah ada
                $foto = $data_berita['foto'];
            }

            // Query untuk melakukan update berita
            $sql_update_berita = "UPDATE galeriprestasi SET judul_berita = '$judul_berita', foto = '$foto', isi_berita = '$isi_berita' WHERE id_galeri = '$id_galeri'";

            if (mysqli_query($koneksi, $sql_update_berita)) {
               $_SESSION['success_message'] = "Berita berhasil diedit.";
                echo '<script>alert("Berita berhasil diedit."); window.location.href = "berita.php";</script>';
                exit();
            } else {
                $error_message = "Error: " . mysqli_error($koneksi);
            }
        }
    } else {
        // ID berita tidak valid, redirect ke halaman berita.php
        header("Location: berita.php");
        exit();
    }
} else {
    // Parameter ID berita tidak ditemukan, redirect ke halaman berita.php
    header("Location: berita.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <?php include("includes/head.php") ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <?php include("includes/header.php") ?>
    <?php include("includes/sidebar.php") ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3><i class="fas fa-edit"></i> Edit Galeri Prestasi</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="berita.php">Data Galeri Prestasi</a></li>
                            <li class="breadcrumb-item active">Edit Galeri Prestasi</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Add your content here -->
            <div class="card">
                <div class="card" style="background-color: #0174BE;">
                        <div class="card-header">
                            <h3 class="card-title"style="margin-top:5px; color:white; font-weight:500; "><i class="far fa-list-alt"></i> Form Edit Data Galeri Prestasi</h3>
                            <div class="card-tools">
                                <a href="berita.php" class="btn btn-sm btn-warning float-right"><i class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                <div class="card-body">
                    <?php
                    if (isset($error_message)) {
                        echo '<div class="alert alert-danger">' . $error_message . '</div>';
                    }
                    ?>

                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="judul_berita">Judul Berita</label>
                            <input type="text" class="form-control" id="judul_berita" name="judul_berita" required value="<?php echo $data_berita['judul_berita']; ?>">
                        </div>

                        <div class="form-group">
                            <label for="foto">Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                            <p class="text-muted">Biarkan kosong jika tidak ingin mengganti foto.</p>
                        </div>

                        <div class="form-group">
                            <label for="isi_berita">Isi Berita</label>
                            <textarea class="form-control" id="isi_berita" name="isi_berita" rows="5" required><?php echo $data_berita['isi_berita']; ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
                <!-- /.card-body -->
                <!-- Add your footer content here -->
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include("includes/footer.php") ?>
</div>
<!-- ./wrapper -->

<?php include("includes/script.php") ?>
</body>
</html>
