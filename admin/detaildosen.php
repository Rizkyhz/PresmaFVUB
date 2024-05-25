<?php
session_start();
include('koneksi/koneksi.php');

// Periksa apakah ID Dosen sudah diberikan melalui parameter GET
if (isset($_GET['id_dosen'])) {
    $id_dosen = $_GET['id_dosen'];

    // Ambil data dosen berdasarkan ID
    $sql_select = "SELECT * FROM dosen WHERE id_dosen = $id_dosen";
    $query_select = mysqli_query($koneksi, $sql_select);

    if ($query_select) {
        $data_dosen = mysqli_fetch_assoc($query_select);
    } else {
        // Redirect jika query tidak berhasil
        header("Location: dosen.php?notif=error");
        exit();
    }
} else {
    // Redirect jika ID Dosen tidak diberikan
    header("Location: dosen.php?notif=error");
    exit();
}

// Ambil data departemen
$sql_departemen = "SELECT departemen.* FROM departemen 
                   JOIN prodi ON departemen.id_departemen = prodi.id_departemen_prodi    
                   WHERE prodi.id_prodi = " . $data_dosen['id_prodi_dosen'];
$query_departemen = mysqli_query($koneksi, $sql_departemen);
$data_departemen = mysqli_fetch_assoc($query_departemen);

// Ambil data program studi
$sql_prodi = "SELECT * FROM prodi WHERE id_prodi = " . $data_dosen['id_prodi_dosen'];
$query_prodi = mysqli_query($koneksi, $sql_prodi);
$data_prodi = mysqli_fetch_assoc($query_prodi);
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
                            <h3><i class="fas fa-user-tie"></i> Detail Dosen</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dosen.php">Data Dosen</a></li>
                                <li class="breadcrumb-item active">Detail Dosen</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Add your content here -->
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Add your content here -->
                        <div class="form-group">
                            <label>ID Dosen:</label>
                            <p><?php echo $data_dosen['id_dosen']; ?></p>
                        </div>
                        <div class="form-group">
                            <label>Nama Dosen:</label>
                            <p><?php echo $data_dosen['nama_dosen']; ?></p>
                        </div>
                        <div class="form-group">
                            <label>Jabatan Dosen:</label>
                            <p><?php echo $data_dosen['jabatan_dosen']; ?></p>
                        </div>
                        <div class="form-group">
                            <label>NIK Dosen:</label>
                            <p><?php echo $data_dosen['nik_dosen']; ?></p>
                        </div>
                        <div class="form-group">
                            <label>Departemen:</label>
                            <p><?php echo $data_departemen['nama_departemen']; ?></p>
                        </div>
                        <div class="form-group">
                            <label>Program Studi:</label>
                            <p><?php echo $data_prodi['nama_prodi']; ?></p>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </section>
            <div class="mt-4" style="margin-left: 10px;">
                <a href="dosen.php" class="btn btn-warning " style="font-weight: 700; ">Back</a>
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include("includes/footer.php") ?>
    </div>
    <!-- ./wrapper -->

    <?php include("includes/script.php") ?>
</body>

</html>