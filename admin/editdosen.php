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
                            <h3><i class="fas fa-user-tie"></i> Edit Dosen</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dosen.php">Data Dosen</a></li>
                                <li class="breadcrumb-item active">Edit Dosen</li>
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
                            <h3 class="card-title" style="margin-top:5px; color:white; font-weight:500; "><i class="far fa-list-alt"></i> Form Edit Data Dosen</h3>
                            <div class="card-tools">
                                <a href="dosen.php" class="btn btn-sm btn-warning float-right"><i class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Add your content here -->
                        <form method="post" action="konfirmasieditdosen.php">
                            <input type="hidden" name="id_dosen" value="<?php echo $data_dosen['id_dosen']; ?>">

                            <div class="form-group">
                                <label>Nama Dosen:</label>
                                <input type="text" class="form-control" name="nama_dosen" value="<?php echo $data_dosen['nama_dosen']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Jabatan Dosen:</label>
                                <input type="text" class="form-control" name="jabatan_dosen" value="<?php echo $data_dosen['jabatan_dosen']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>NIK Dosen:</label>
                                <input type="text" class="form-control" name="nik_dosen" value="<?php echo $data_dosen['nik_dosen']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Departemen:</label>
                                <select class="form-control" name="id_departemen_dosen" required>
                                    <?php
                                    while ($data_departemen = mysqli_fetch_assoc($query_departemen)) {
                                        $selected = ($data_departemen['id_departemen'] == $data_dosen['id_departemen_dosen']) ? 'selected' : '';
                                        echo '<option value="' . $data_departemen['id_departemen'] . '" ' . $selected . '>' . $data_departemen['nama_departemen'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Program Studi:</label>
                                <select class="form-control" name="id_prodi_dosen" required>
                                    <!-- Opsi Program Studi akan Diisi Melalui JavaScript -->
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
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

    <!-- Tambahkan jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Tambahkan JavaScript untuk Mengisi Opsi Program Studi Berdasarkan Departemen -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var departemenId = <?php echo $data_dosen['id_departemen_dosen']; ?>;
            var prodiDropdown = document.querySelector('[name="id_prodi_dosen"]');

            // Gunakan AJAX untuk mendapatkan data Program Studi dari server
            $.ajax({
                url: 'get_prodi.php', // Ganti dengan URL sesuai kebutuhan
                method: 'POST',
                data: {
                    id_departemen: departemenId
                },
                dataType: 'json',
                success: function(response) {
                    // Tambahkan opsi Program Studi ke dropdown
                    response.forEach(function(prodi) {
                        var option = document.createElement('option');
                        option.value = prodi.id_prodi;
                        option.text = prodi.nama_prodi;
                        option.selected = (prodi.id_prodi === <?php echo $data_dosen['id_prodi_dosen']; ?>);
                        prodiDropdown.appendChild(option);
                    });
                },
                error: function() {
                    console.error('Error while fetching program studi data.');
                }
            });
        });
    </script>

    <?php include("includes/script.php") ?>
</body>

</html>