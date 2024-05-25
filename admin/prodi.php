<?php
session_start();
include('koneksi/koneksi.php');

$id = $_SESSION['id_user'];
$sql_prodi = "SELECT * FROM prodi INNER JOIN `departemen` ON prodi.id_departemen_prodi = departemen.id_departemen";
$query_prodi = mysqli_query($koneksi, $sql_prodi);
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
                            <h3><i class="fas fa-university"></i> Data Program Studi</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active"> Data Program Studi</li>
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
                        <!-- <h3 class="card-title" style="margin-top:5px;"><i class="fas fa-list-ul"></i> Daftar Program Studi</h3> -->
                        <div class="card-tools">
                            <?php
                            // Hanya tampilkan tautan Tambah User jika peran pengguna bukan admin
                            if ($_SESSION['id_role'] != '1') {
                            ?>
                                <a href="tambahprodi.php" class="btn btn-sm btn-success float-right" style="font-size:16px; font-weight: 600;">
                                    <i class="fas fa-plus"></i> Tambah Data Program Studi</a>
                            <?php
                            }
                            ?>

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Add your content here -->
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="30%">ID Prodi</th>
                                    <th width="30%">Nama Prodi</th>
                                    <th width="30%">Nama Departemen</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                while ($data_prodi = mysqli_fetch_assoc($query_prodi)) {
                                ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $data_prodi['id_prodi']; ?></td>
                                        <td><?php echo $data_prodi['nama_prodi']; ?></td>
                                        <td><?php echo $data_prodi['nama_departemen']; ?></td>
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