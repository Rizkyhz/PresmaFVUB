<?php
session_start();
include('koneksi/koneksi.php');

$id_user = $_SESSION['id_user'];

$target_dir = "../upload/";
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

if (isset($_GET['id_lomba'])) {
    $id_lomba = $_GET['id_lomba'];

    $sql_get_lomba = "SELECT * FROM info_lomba WHERE id_lomba = '$id_lomba'";
    $result_get_lomba = mysqli_query($koneksi, $sql_get_lomba);

    if ($result_get_lomba) {
        $data_lomba = mysqli_fetch_assoc($result_get_lomba);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $foto = $_FILES['foto']['name'];
            $keterangan = $_POST['keterangan'];

            if (!empty($foto)) {
                $target_file = $target_dir . basename($_FILES['foto']['name']);
                move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);
            } else {
                $foto = $data_lomba['foto'];
            }

            $sql_update_lomba = "UPDATE info_lomba SET foto = '$foto', keterangan = '$keterangan' WHERE id_lomba = '$id_lomba'";

            if (mysqli_query($koneksi, $sql_update_lomba)) {
                $_SESSION['success_message'] = "Info Lomba berhasil diedit.";
                echo '<script>alert("Info Lomba berhasil diedit."); window.location.href = "lomba.php";</script>';
                exit();
            } else {
                $error_message = "Error: " . mysqli_error($koneksi);
            }
        }
    } else {
        header("Location: lomba.php");
        exit();
    }
} else {
    header("Location: lomba.php");
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
                        <h3><i class="fas fa-edit"></i> Edit Informasi Lomba</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="lomba.php">Data Informasi Lomba</a></li>
                            <li class="breadcrumb-item active">Edit Informasi Lomba</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="card">
                <div class="card" style="background-color: #0174BE;">
                        <div class="card-header">
                            <h3 class="card-title"style="margin-top:5px; color:white; font-weight:500; "><i class="far fa-list-alt"></i> Form Edit Data Informasi Lomba</h3>
                            <div class="card-tools">
                                <a href="lomba.php" class="btn btn-sm btn-warning float-right"><i class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                <div class="card-body">
                    <?php
                    if (isset($error_message)) {
                        echo '<div class="alert alert-danger">' . $error_message . '</div>';
                    }
                    ?>

                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="foto">Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                            <p class="text-muted">Biarkan kosong jika tidak ingin mengganti foto.</p>
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="5" required><?php echo $data_lomba['keterangan']; ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
    <?php include("includes/footer.php") ?>
</div>
<?php include("includes/script.php") ?>
</body>
</html>
