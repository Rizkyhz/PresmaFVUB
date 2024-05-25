<?php
session_start();
include('koneksi/koneksi.php');

// Check if the ID parameter is set in the URL
if (isset($_GET['id_lomba'])) {
    $id = $_GET['id_lomba'];

    // Fetch competition details from the database based on ID
    $select_query = "SELECT id_lomba, foto, keterangan FROM info_lomba WHERE id_lomba = $id";
    $result = mysqli_query($koneksi, $select_query);

    if ($result && mysqli_num_rows($result) > 0) {
        $data_lomba = mysqli_fetch_assoc($result);
    } else {
        // Handle error if competition not found
        echo "Competition not found.";
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
                        <h3><i class="fas fa-trophy"></i> Detail Informasi Lomba</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active"> Detail Informasi Lomba</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="card">
                <div class="card-header">
                    <a href="lomba.php" class="btn btn-sm btn-secondary" style="font-size:16px; font-weight: 600;">
                        <i class="fas fa-arrow-left"></i> Kembali</a>
                </div>
                <div class="card-body">
                    <!-- Display the image -->
                    <div class="form-group">
                        <label for="foto">Foto Lomba</label>
                        <img src="<?php echo $data_lomba['foto']; ?>" class="img-fluid" alt="Foto Lomba" width="300" height="200">
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <p><?php echo $data_lomba['keterangan']; ?></p>
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
