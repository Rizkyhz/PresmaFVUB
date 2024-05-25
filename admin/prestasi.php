<?php
session_start();
include('koneksi/koneksi.php');

// Query untuk mendapatkan seluruh data prestasi
$query_prestasi = "SELECT * FROM prestasimahasiswa";
$result_prestasi = mysqli_query($koneksi, $query_prestasi);

?>

<!DOCTYPE html>
<html lang="en">
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
                        <h1>Data Prestasi Mahasiswa</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Prestasi Mahasiswa</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Daftar Prestasi Mahasiswa</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID Prestasi</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Nama Prestasi</th>
                                        <th>Tanggal Pelaksanaan</th>
                                        <th>Levaga Penyelenggara</th>
                                        <th>Lokasi</th>
                                        <th>Capaian</th>
                                        <th>Surat Tugas</th>
                                        <th>Sertifikat</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($result_prestasi)) {
                                        // Query untuk mendapatkan nama mahasiswa
                                        $id_mahasiswa = $row['id_mahasiswa'];
                                        $query_nama_mahasiswa = "SELECT nama_mahasiswa FROM mahasiswa WHERE id_mahasiswa = '$id_mahasiswa'";
                                        $result_nama_mahasiswa = mysqli_query($koneksi, $query_nama_mahasiswa);
                                        $row_nama_mahasiswa = mysqli_fetch_assoc($result_nama_mahasiswa);
                                        $nama_mahasiswa = $row_nama_mahasiswa['nama_mahasiswa'];

                                        echo "<tr>";
                                        echo "<td>{$row['id_prestasi']}</td>";
                                        echo "<td>{$nama_mahasiswa}</td>";
                                        echo "<td>{$row['nama_prestasi']}</td>";
                                        echo "<td>{$row['tanggal_pelaksanaan']}</td>";
                                        echo "<td>{$row['lembaga_penyelenggara']}</td>";
                                        echo "<td>{$row['lokasi']}</td>";
                                        echo "<td>{$row['capaian']}</td>";
                                        echo "<td><a href='filesurattugas/{$row['id_file']}' target='_blank'>Lihat Surat Tugas</a></td>";
                                        echo "<td><a href='filesertif/{$row['id_file']}' target='_blank'>Lihat Sertifikat</a></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
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
