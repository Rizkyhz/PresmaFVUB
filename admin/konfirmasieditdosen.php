<?php
session_start();
include('koneksi/koneksi.php');

// Periksa apakah formulir telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Peroleh data dari formulir
    $id_dosen = $_POST['id_dosen'];
    $nama_dosen = $_POST['nama_dosen'];
    $jabatan_dosen = $_POST['jabatan_dosen'];
    $nik_dosen = $_POST['nik_dosen'];
    $id_departemen_dosen = $_POST['id_departemen_dosen'];
    $id_prodi_dosen = $_POST['id_prodi_dosen'];

    // Query untuk memperbarui data dosen
    $sql_update = "UPDATE dosen SET
                   nama_dosen = '$nama_dosen',
                   jabatan_dosen = '$jabatan_dosen',
                   nik_dosen = '$nik_dosen',
                   id_departemen_dosen = '$id_departemen_dosen',
                   id_prodi_dosen = '$id_prodi_dosen'
                   WHERE id_dosen = $id_dosen";

    $query_update = mysqli_query($koneksi, $sql_update);

    if ($query_update) {
        // Redirect ke halaman dosen.php setelah perubahan berhasil
        header("Location: dosen.php?notif=editberhasil");
        exit();
    } else {
        // Tampilkan pesan error jika perubahan gagal
        $error_message = "Error: " . mysqli_error($koneksi);
    }
} else {
    // Redirect jika formulir tidak disubmit
    header("Location: dosen.php?notif=error");
    exit();
}

// Ambil data departemen untuk dropdown
$sql_departemen = "SELECT * FROM departemen";
$query_departemen = mysqli_query($koneksi, $sql_departemen);

// Ambil data program studi untuk dropdown (diisi melalui JavaScript)
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
                        <h3><i class="fas fa-user-tie"></i> Konfirmasi Edit Dosen</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="dosen.php">Data Dosen</a></li>
                            <li class="breadcrumb-item active">Konfirmasi Edit Dosen</li>
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
                    <h3 class="card-title" style="margin-top:5px;"><i class="fas fa-user-tie"></i> Konfirmasi Edit Dosen</h3>
                    <!-- Add your card tools/buttons here -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- Add your content here -->
                    <form method="post" action="konfirmasieditdosen.php">
                        <input type="hidden" name="id_dosen" value="<?php echo $id_dosen; ?>">
                        <input type="hidden" name="nama_dosen" value="<?php echo $nama_dosen; ?>">
                        <input type="hidden" name="jabatan_dosen" value="<?php echo $jabatan_dosen; ?>">
                        <input type="hidden" name="nik_dosen" value="<?php echo $nik_dosen; ?>">
                        <input type="hidden" name="id_departemen_dosen" value="<?php echo $id_departemen_dosen; ?>">
                        <input type="hidden" name="id_prodi_dosen" value="<?php echo $id_prodi_dosen; ?>">

                        <p>Apakah Anda yakin ingin menyimpan perubahan ini?</p>
                        <button type="submit" class="btn btn-primary">Ya, Simpan Perubahan</button>
                        <a href="editdosen.php?id_dosen=<?php echo $id_dosen; ?>" class="btn btn-danger">Tidak, Batalkan</a>
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
