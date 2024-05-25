<?php
session_start();
include('koneksi/koneksi.php');

// Check if prestasi ID is provided in the URL
if (isset($_GET['id_prestasi'])) {
    $id_prestasi = $_GET['id_prestasi'];

    // Fetch prestasi details based on the provided ID
    $query = mysqli_query($koneksi, "SELECT * FROM prestasimahasiswa WHERE id_prestasi = $id_prestasi");

    // Check if the prestasi exists
    if ($query && mysqli_num_rows($query) > 0) {
        $prestasi_data = mysqli_fetch_assoc($query);
        $id_mahasiswa = $prestasi_data['id_mahasiswa'];
        $nama_prestasi = $prestasi_data['nama_prestasi'];
        $tanggal_pelaksanaan = $prestasi_data['tanggal_pelaksanaan'];
        $lembaga_penyelenggara = $prestasi_data['lembaga_penyelenggara'];
        $lokasi = $prestasi_data['lokasi'];
        $capaian = $prestasi_data['capaian'];
        $no_surattugas = $prestasi_data['no_surattugas'];
        $id_bidang = $prestasi_data['id_bidang'];
        $id_jenis_kejuaraan = $prestasi_data['id_jenis_kejuaraan'];
        $id_tingkat_kejuaraan = $prestasi_data['id_tingkat_kejuaraan'];
        $jenis_kepesertaan = $prestasi_data['jenis_kepesertaan'];
        $id_status = $prestasi_data['id_status'];

        // Fetch mahasiswa details based on the prestasi data
        $query_mahasiswa = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa");
        $mahasiswa_data = mysqli_fetch_assoc($query_mahasiswa);

        // Fetch data for dropdowns
        $query_bidang = mysqli_query($koneksi, "SELECT * FROM bidang");
        $query_jenis_kejuaraan = mysqli_query($koneksi, "SELECT * FROM jeniskejuaraan");
        $query_tingkat_kejuaraan = mysqli_query($koneksi, "SELECT * FROM tingkatkejuaraan");
        $query_jenis_kepesertaan = mysqli_query($koneksi, "SELECT * FROM jenis_kepesertaan");
        $query_departemen = mysqli_query($koneksi, "SELECT * FROM departemen");
        $query_status = mysqli_query($koneksi, "SELECT * FROM status");

    } else {
        // Redirect to the prestasi list page if the prestasi does not exist
        header("Location: presma.php");
        exit();
    }
} else {
    // Redirect to the prestasi list page if no prestasi ID is provided
    header("Location: presma.php");
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
            <!-- ... (same as your existing code) ... -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="card">
                 <div class="card" style="background-color: #0174BE;">
                        <div class="card-header">
                            <h3 class="card-title"style="margin-top:5px; color:white; font-weight:500; "><i class="far fa-list-alt"></i> Form Edit Data Prestasi</h3>
                            <div class="card-tools">
                                <a href="presma.php" class="btn btn-sm btn-warning float-right"><i class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="POST" action="konfirmasieditpresma.php">
                        <input type="hidden" name="id_prestasi" value="<?php echo $id_prestasi; ?>">
                        <div class="card-body">
                           <div class="form-group">
                                <label for="id_mahasiswa">Nama Mahasiswa</label>
                                <select class="form-control" name="id_mahasiswa" required readonly>
                                    <?php
                                    echo '<option value="' . $mahasiswa_data['id_mahasiswa'] . '" selected>' . $mahasiswa_data['nama_mahasiswa'] . '</option>';
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nama_prestasi">Nama Prestasi</label>
                                <input type="text" class="form-control" name="nama_prestasi" id="nama_prestasi" value="<?php echo $nama_prestasi; ?>">
                            </div>
                            <div class="form-group">
                                <label for="tanggal_pelaksanaan">Tanggal Pelaksanaan</label>
                                <input type="date" class="form-control" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan" value="<?php echo $tanggal_pelaksanaan; ?>">
                            </div>
                            <div class="form-group">
                                <label for="lembaga_penyelenggara">Lembaga Penyelenggara</label>
                                <input type="text" class="form-control" name="lembaga_penyelenggara" id="lembaga_penyelenggara" value="<?php echo $lembaga_penyelenggara; ?>">
                            </div>
                            <div class="form-group">
                                <label for="lokasi">Lokasi</label>
                                <input type="text" class="form-control" name="lokasi" id="lokasi" value="<?php echo $lokasi; ?>">
                            </div>
                            <div class="form-group">
                                <label for="capaian">Capaian</label>
                                <input type="text" class="form-control" name="capaian" id="capaian" value="<?php echo $capaian; ?>">
                            </div>
                            <div class="form-group">
                                <label for="no_surattugas">Nomor Surat Tugas</label>
                                <input type="text" class="form-control" name="no_surattugas" id="no_surattugas" value="<?php echo $no_surattugas; ?>">
                            </div>
                            <!-- Dropdowns for Bidang, Jenis Kejuaraan, Tingkat Kejuaraan, Jenis Kepesertaan, and Status -->
                            <div class="form-group">
                                <label for="id_bidang">Bidang Prestasi</label>
                                <select class="form-control" name="id_bidang" required>
                                    <?php
                                    while ($data_bidang = mysqli_fetch_assoc($query_bidang)) {
                                        $selected = ($data_bidang['id_bidang'] == $id_bidang) ? 'selected' : '';
                                        echo '<option value="' . $data_bidang['id_bidang'] . '" ' . $selected . '>' . $data_bidang['nama_bidang'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Dropdown for Jenis Kejuaraan -->
                            <div class="form-group">
                                <label for="id_jenis_kejuaraan">Jenis Kejuaraan</label>
                                <select class="form-control" name="id_jenis_kejuaraan" required>
                                    <?php
                                    while ($data_jenis_kejuaraan = mysqli_fetch_assoc($query_jenis_kejuaraan)) {
                                        $selected = ($data_jenis_kejuaraan['id_jeniskej'] == $id_jenis_kejuaraan) ? 'selected' : '';
                                        echo '<option value="' . $data_jenis_kejuaraan['id_jeniskej'] . '" ' . $selected . '>' . $data_jenis_kejuaraan['jenis_kejuaraan'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Dropdown for Tingkat Kejuaraan -->
                            <div class="form-group">
                                <label for="id_tingkat_kejuaraan">Tingkat Kejuaraan</label>
                                <select class="form-control" name="id_tingkat_kejuaraan" required>
                                    <?php
                                    while ($data_tingkat_kejuaraan = mysqli_fetch_assoc($query_tingkat_kejuaraan)) {
                                        $selected = ($data_tingkat_kejuaraan['id_tingjur'] == $id_tingkat_kejuaraan) ? 'selected' : '';
                                        echo '<option value="' . $data_tingkat_kejuaraan['id_tingjur'] . '" ' . $selected . '>' . $data_tingkat_kejuaraan['tingkatan'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Dropdown for Jenis Kepesertaan -->
                            <div class="form-group">
                                <label for="jenis_kepesertaan" readonly>Jenis Kepesertaan</label>
                                <select class="form-control" name="jenis_kepesertaan"  readonly>
                                    <?php
                                    while ($data_jenis_kepesertaan = mysqli_fetch_assoc($query_jenis_kepesertaan)) {
                                        $selected = ($data_jenis_kepesertaan['id_jenis_kepesertaan'] == $jenis_kepesertaan) ? 'selected' : '';
                                        echo '<option value="' . $data_jenis_kepesertaan['id_jenis_kepesertaan'] . '" ' . $selected . '>' . $data_jenis_kepesertaan['jenis_kepesertaan'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-info float-right">
                                    <i class="fas fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include("includes/footer.php") ?>
</div>
<!-- ./wrapper -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<?php include("includes/script.php") ?>
<script>

</script>

</body>
</html>
