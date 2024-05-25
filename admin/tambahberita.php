<?php
session_start();
include('koneksi/koneksi.php');

$id = $_SESSION['id_user'];

// Pastikan direktori upload ada atau buat jika belum ada
$target_dir = "../upload/";
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// Proses tambah berita
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul_berita = $_POST['judul_berita'];
    $foto = $_FILES['foto']['name'];
    $isi_berita = $_POST['isi_berita'];

    // Proses upload foto
    $target_file = $target_dir . basename($_FILES['foto']['name']);
    move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);

    // Query untuk menambahkan berita ke database
    $sql_tambah_berita = "INSERT INTO galeriprestasi (judul_berita, foto, isi_berita) VALUES ( '$judul_berita', '$foto', '$isi_berita')";

    if (mysqli_query($koneksi, $sql_tambah_berita)) {
        $_SESSION['success_message'] = "Berita berhasil ditambahkan.";
        echo '<script>alert("Berita berhasil ditambahkan."); window.location.href = "berita.php";</script>';
        exit();
    } else {
        echo "Error: " . $sql_tambah_berita . "<br>" . mysqli_error($koneksi);
    }
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
                        <h3><i class="fas fa-plus"></i> Tambah Berita</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="berita.php">Data Berita</a></li>
                            <li class="breadcrumb-item active">Tambah Berita</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Add your content here -->
            <div class="card">
                <div class="card-body">
                    <div class="card" style="background-color: #0174BE;">
                        <div class="card-header">
                            <h3 class="card-title"style="margin-top:5px; color:white; font-weight:500; "><i class="far fa-list-alt"></i> Form Tambah Data Galeri Prestasi</h3>
                            <div class="card-tools">
                                <a href="berita.php" class="btn btn-sm btn-warning float-right"><i class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="judul_berita">Judul Berita:</label>
                            <input type="text" class="form-control" name="judul_berita" required>
                        </div>
                        <div class="form-group">
                            <label for="foto">Foto:</label>
                            <input type="file" class="form-control" name="foto" accept="image/*" >
                        </div>
                        <div class="form-group">
                            <label for="isi_berita">Isi Berita:</label>
                            <textarea class="form-control" name="isi_berita" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
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
