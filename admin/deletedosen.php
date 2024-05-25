<?php
session_start();
include('koneksi/koneksi.php');

// Periksa apakah ID Dosen sudah diberikan melalui parameter GET
if (isset($_GET['id_dosen'])) {
    $id_dosen = $_GET['id_dosen'];

    // Query untuk menghapus dosen berdasarkan ID
    $sql_delete = "DELETE FROM dosen WHERE id_dosen = $id_dosen";
    $query_delete = mysqli_query($koneksi, $sql_delete);

    if ($query_delete) {
        echo '<script>alert("Dosen deleted successfully.");</script>';

        // Redirect ke halaman dosen.php setelah penghapusan berhasil
        header("Location: dosen.php?notif=hapusberhasil");
        exit();
    } else {
        // Tampilkan pesan error jika penghapusan gagal
        $error_message = "Error: " . mysqli_error($koneksi);
    }
} else {
    // Redirect jika ID Dosen tidak diberikan
    header("Location: dosen.php?notif=error");
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
                        <h3><i class="fas fa-user-tie"></i> Hapus Dosen</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="dosen.php">Data Dosen</a></li>
                            <li class="breadcrumb-item active">Hapus Dosen</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Add your content here -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title" style="margin-top:5px;"><i class="fas fa-user-tie"></i> Konfirmasi Hapus Dosen</h3>
                    <!-- Add your card tools/buttons here -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- Add your content here -->
                    <form method="post" action="">
                        <p>Apakah Anda yakin ingin menghapus dosen ini?</p>
                        <button type="submit" class="btn btn-danger">Ya, Hapus Dosen</button>
                        <a href="dosen.php" class="btn btn-primary">Tidak, Batalkan</a>
                    </form>
                    <?php
                    // Tampilkan pesan error jika ada
                    if (isset($error_message)) {
                        echo '<div class="alert alert-danger" role="alert">' . $error_message . '</div>';
                    }
                    ?>
                </div>
                <!-- /.card-body -->
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
