<?php
session_start();
include('koneksi/koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_prodi = $_POST["nama_prodi"];
    $id_departemen = $_POST["id_departemen_prodi"];

    // Validasi form, pastikan semua field diisi sesuai kebutuhan
    if (empty($nama_prodi) || empty($id_departemen)) {
        $error_message = "Nama Prodi dan Departemen harus diisi!";
    } else {
        // Query untuk mengecek apakah data prodi sudah ada
        $sql_cek_duplicate = "SELECT * FROM prodi WHERE nama_prodi = '$nama_prodi' AND id_departemen_prodi = '$id_departemen'";
        $result_cek_duplicate = mysqli_query($koneksi, $sql_cek_duplicate);

        if (mysqli_num_rows($result_cek_duplicate) > 0) {
            // Data prodi sudah ada, beri pesan error
            $error_message = "Program Studi dengan nama yang sama di Departemen yang sama sudah ada.";
        } else {
            // Data prodi belum ada, lakukan penyisipan ke database
            $sql_tambah_prodi = "INSERT INTO prodi (nama_prodi, id_departemen_prodi) VALUES ('$nama_prodi', '$id_departemen')";

            if (mysqli_query($koneksi, $sql_tambah_prodi)) {
                header("Location: prodi.php");
                exit();
            } else {
                $error_message = "Error: " . mysqli_error($koneksi);
            }
        }
    }
}

$sql_departemen = "SELECT * FROM departemen";
$query_departemen = mysqli_query($koneksi, $sql_departemen);
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
                        <h3><i class="fas fa-university"></i> Tambah Program Studi</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="prodi.php">Data Program Studi</a></li>
                            <li class="breadcrumb-item active">Tambah Program Studi</li>
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
                            <h3 class="card-title"style="margin-top:5px; color:white; font-weight:500; "><i class="far fa-list-alt"></i> Form Tambah Data Prodi</h3>
                            <div class="card-tools">
                                <a href="prodi.php" class="btn btn-sm btn-warning float-right"><i class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                <div class="card-body">
                    <?php
                    if (isset($error_message)) {
                        echo '<div class="alert alert-danger">' . $error_message . '</div>';
                    }
                    ?>

                    <form action="" method="post">
                        <div class="form-group">
                            <label for="nama_prodi">Nama Program Studi:</label>
                            <input type="text" class="form-control" id="nama_prodi" name="nama_prodi" required value="">
                        </div>

                        <div class="form-group">
                            <label for="id_departemen_prodi">Departemen:</label>
                            <select class="form-control" id="id_departemen_prodi" name="id_departemen_prodi" required value="">
                                <?php
                                while ($data_departemen = mysqli_fetch_assoc($query_departemen)) {
                                    echo '<option value="' . $data_departemen['id_departemen'] . '">' . $data_departemen['nama_departemen'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Tambah Program Studi</button>
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
