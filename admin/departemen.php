<?php
session_start();
include('koneksi/koneksi.php');

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
                        <h3><i class="fas fa-building"></i> Data Departemen</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active"></li>
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
                    <div class="card-tools">
                        <?php
                            // Hanya tampilkan tautan Tambah User jika peran pengguna bukan admin
                            //Jika nilai 'id_role' dalam $_SESSION adalah '1', maka kondisi $_SESSION['id_role'] != '1' menjadi salah, dan oleh karena itu, blok kode di dalamnya tidak akan dieksekusi.
                            // Jika nilai 'id_role' dalam $_SESSION bukan '1' (misalnya, '2', '3', atau nilai lainnya), maka kondisi menjadi benar, dan blok kode di dalamnya akan dieksekusi. Artinya, tautan "Tambah Data Departemen" akan ditampilkan.
                            if ($_SESSION['id_role'] != '1') {
                            ?>
                                <a href="tambahdepartemen.php" class="btn btn-sm btn-success float-right" style="font-size:16px; font-weight: 600;">
                            <i class="fas fa-plus"></i> Tambah Data Departemen</a>
                            <?php
                            }
                            ?>


                        <!-- Add any additional buttons or links here -->
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- Add your content here -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">ID Departemen</th>
                                <th width="20%">Nama Departemen</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 1;
                            while ($data_departemen = mysqli_fetch_assoc($query_departemen)) {
                                ?>
                                <tr>
                                    <td><?php echo $data_departemen['id_departemen']; ?></td>
                                    <td><?php echo $data_departemen['nama_departemen']; ?></td>

                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
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
