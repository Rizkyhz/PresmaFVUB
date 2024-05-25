<?php
session_start();
include('koneksi/koneksi.php');

// Check if the ID parameter is set in the URL
if (isset($_GET['id_galeri'])) {
    $id = $_GET['id_galeri'];

    // Fetch news article details from the database based on ID
    $select_query = "SELECT id_galeri, judul_berita, foto, isi_berita FROM galeriprestasi WHERE id_galeri = $id";
    $result = mysqli_query($koneksi, $select_query);


    if ($result && mysqli_num_rows($result) > 0) {
        $data_berita = mysqli_fetch_assoc($result);
    } else {
        // Handle error if news article not found
        echo "News article not found.";
        exit();
    }
} else {
    // Handle error if ID parameter is not set
    echo "Invalid request.";
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

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3><i class="fas fa-newspaper"></i> Detail Galeri Prestasi</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active"> Detail Galeri Prestasi</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="card">
                <div class="card-header">
                    <a href="berita.php" class="btn btn-sm btn-secondary" style="font-size:16px; font-weight: 600;">
                        <i class="fas fa-arrow-left"></i> Kembali</a>
                </div>
                <div class="card-body">
                    <!-- Display the image -->
                    <div class="form-group">
                        <label for="foto">Foto Berita</label>

                        <img src="../upload/<?php echo $data_berita['foto']; ?>" class="img-fluid" alt="Foto Berita" width="300" height="200">
                    </div>

                    <div class="form-group">
                        <label for="judul_berita">Judul Berita</label>
                        <p><?php echo $data_berita['judul_berita']; ?></p>
                    </div>

                    <div class="form-group">
                        <label for="isi_berita">Isi Berita</label>
                        <p><?php echo $data_berita['isi_berita']; ?></p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php include("includes/footer.php") ?>
</div>
<?php include("includes/script.php") ?>
</body>
</html>
