<?php
session_start();
include('koneksi/koneksi.php');

if (isset($_GET['id_prestasi'])) {
    $id_prestasi = $_GET['id_prestasi'];

    // Query to get details of the selected achievement
// Query to get details of the selected achievement, including the "nama_mahasiswa" column
    $sql_prestasi_detail = "SELECT prestasimahasiswa.*, mahasiswa.nama_mahasiswa, savedfiles.file_path_surattugas AS file_path_surattugas, savedfiles.file_path_sertifikat
                        FROM prestasimahasiswa
                        JOIN mahasiswa ON prestasimahasiswa.id_mahasiswa = mahasiswa.id_mahasiswa
                        LEFT JOIN savedfiles ON prestasimahasiswa.id_file = savedfiles.id_file
                        WHERE prestasimahasiswa.id_prestasi = '$id_prestasi'";

    $result_prestasi_detail = mysqli_query($koneksi, $sql_prestasi_detail);

    if ($result_prestasi_detail) {
        $data_prestasi_detail = mysqli_fetch_assoc($result_prestasi_detail);

        // Now $data_prestasi_detail contains the details of the selected achievement
        // You can use this data to display the details in your HTML
    } else {
        // Query failed, handle the error or redirect as needed
        header("Location: presma.php");
        exit();
    }
} else {
    // Parameter ID berita tidak ditemukan, redirect ke halaman berita.php
    header("Location: presma.php");
    exit();
}
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
                <!-- Existing code for the table -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Prestasi Mahasiswa</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                       <div class="container">
                            <h2>Detail Prestasi</h2>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>ID Prestasi</th>
                                        <td><?php echo $data_prestasi_detail['id_prestasi']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Nama Prestasi</th>
                                        <td><?php echo $data_prestasi_detail['nama_prestasi']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Nama Mahasiswa</th>
                                        <td><?php echo $data_prestasi_detail['nama_mahasiswa']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Pelaksanaan</th>
                                        <td><?php echo $data_prestasi_detail['tanggal_pelaksanaan']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Lembaga Penyelenggara</th>
                                        <td><?php echo $data_prestasi_detail['lembaga_penyelenggara']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Lokasi</th>
                                        <td><?php echo $data_prestasi_detail['lokasi']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Capaian</th>
                                        <td><?php echo $data_prestasi_detail['capaian']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Surat Tugas</th>
                                        <td>
                                             <?php
                                                $surat_tugas_link = $data_prestasi_detail['file_path_surattugas'];
                                                echo "<a href='{$surat_tugas_link}' target='_blank'>Lihat Surat Tugas</a>";
                                                ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Sertifikat</th>
                                        <td>
                                            <?php
                                                    // Assuming there is a column in saved_files table for sertifikat
                                                    $sertifikat_link = $data_prestasi_detail['file_path_sertifikat'];
                                                    echo "<a href='{$sertifikat_link}' target='_blank'>Lihat Sertifikat</a>";
                                                    ?>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="mt-4" style="margin-left: 10px;">
                            <a href="presma.php" class="btn btn-warning " style="font-weight: 700; ">Back</a>
                        </div>
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
