<?php
session_start();
include('koneksi/koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_departemen = $_POST["nama_departemen"];

    // Validasi form, pastikan semua field diisi sesuai kebutuhan
    if (empty($nama_departemen)) {
        $error_message = "Nama Departemen harus diisi!";
    } else {
        // Query untuk mengecek apakah data departemen sudah ada
        $sql_cek_duplicate = "SELECT * FROM departemen WHERE nama_departemen = '$nama_departemen'";
        $result_cek_duplicate = mysqli_query($koneksi, $sql_cek_duplicate);

        if (mysqli_num_rows($result_cek_duplicate) > 0) {
            // Data departemen sudah ada, beri pesan error
            $error_message = "Departemen dengan nama yang sama sudah ada.";
        } else {
            // Data departemen belum ada, lakukan penyisipan ke database
            $sql_tambah_departemen = "INSERT INTO departemen (nama_departemen) VALUES ('$nama_departemen')";

            if (mysqli_query($koneksi, $sql_tambah_departemen)) {
                header("Location: departemen.php");
                exit();
            } else {
                $error_message = "Error: " . mysqli_error($koneksi);
            }
        }
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
                        <h3><i class="fas fa-building"></i> Tambah Departemen</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="departemen.php">Data Departemen</a></li>
                            <li class="breadcrumb-item active">Tambah Data Departemen</li>
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
                            <h3 class="card-title"style="margin-top:5px; color:white; font-weight:500; "><i class="far fa-list-alt"></i> Form Tambah Data Departemen</h3>
                            <div class="card-tools">
                                <a href="departemen.php" class="btn btn-sm btn-warning float-right"><i class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- Add your content here -->
                    <form method="post" action="">
                        <div class="form-group">
                            <label for="nama_departemen">Nama Departemen:</label>
                            <input type="text" class="form-control" id="nama_departemen" name="nama_departemen" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah Departemen</button>
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
