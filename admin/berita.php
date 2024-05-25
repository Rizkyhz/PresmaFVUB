<?php
session_start();
include('koneksi/koneksi.php');

$id = $_SESSION['id_user'];
$sql_berita = "SELECT * FROM galeriprestasi";
$query_berita = mysqli_query($koneksi, $sql_berita);
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
                        <h3><i class="fas fa-newspaper"></i> Data Galeri Prestasi</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active"> Data Galeri Prestasi</li>
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
                    <!-- <h3 class="card-title" style="margin-top:5px;"><i class="fas fa-list-ul"></i> Daftar Berita</h3> -->
                    <div class="card-tools"> <?php
                            if ($_SESSION['id_role'] != '0') {
                                // Hanya pengguna selain superadmin yang bisa melihat dan menggunakan tombol ini
                                echo '<a href="tambahberita.php" class="btn btn-sm btn-success float-right" style="font-size:16px; font-weight:600;">';
                                echo '<i class="fas fa-plus"></i> Tambah Data Berita</a></a>';
                            } else {
                                // Jika superadmin, tampilkan pesan atau tindakan lain sesuai kebutuhan
                                echo 'Anda tidak memiliki izin untuk menambah prestasi.';
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
                            <th width="20%">ID Galeri</th>
                            <th width="30%">Judul Berita</th>
                            <th width = "6%">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = 1;
                        while ($data_berita = mysqli_fetch_assoc($query_berita)) {
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $data_berita['id_galeri']; ?></td>
                                <td><?php echo $data_berita['judul_berita']; ?></td>
                                <td>

                                        <a href="detailberita.php?id_galeri=<?php echo $data_berita['id_galeri']; ?>" class="btn btn-sm btn-info" title="Lihat">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <?php
                                        if ($_SESSION['id_role'] != '0') {
                                            // Tombol Hapus hanya ditampilkan untuk pengguna selain superadmin
                                            echo '<a href="editberita.php?id_galeri=' . $data_berita['id_galeri'] . '" class="btn btn-sm btn-warning" title="Edit"><i class="far fa-edit"></i></a>';
                                            echo '<a href="hapusberita.php?id_galeri=' . $data_berita['id_galeri'] . '" onclick="return confirm(\'Apakah Anda yakin ingin menghapus berita ini?\');" class="btn btn-sm btn-danger" title="Hapus"><i class="far fa-trash-alt"></i></a>';
                                        }
                                        ?>
                                    </td>
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
