<?php
session_start();
include('koneksi/koneksi.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    $keterangan = isset($_POST['keterangan']) ? $_POST['keterangan'] : null;

    // Validate form data (add your validation logic here)
    $errors = [];

    if (empty($keterangan)) {
        $errors[] = "Keterangan is required.";
    }

    // Check if a file is uploaded
    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto'];

        // Check if the file is an image
        $allowed_types = ['image/jpeg', 'image/png'];
        if (!in_array($foto['type'], $allowed_types)) {
            $errors[] = "Only JPEG and PNG images are allowed.";
        }

        // Move the uploaded file to a desired location
        $upload_dir = 'fotolomba/';
        $upload_path = $upload_dir . basename($foto['name']);

        if (move_uploaded_file($foto['tmp_name'], $upload_path)) {
            $foto_path = $upload_path;
        } else {
            $errors[] = "Failed to upload the file.";
        }
    } else {
        $errors[] = "Foto is required.";
    }

    if (empty($errors)) {
        // Form data is valid, proceed with database insertion
        $insert_query = "INSERT INTO info_lomba (foto, keterangan) VALUES ('$foto_path', '$keterangan')";
        $result = mysqli_query($koneksi, $insert_query);

        if ($result) {
            // Successful insertion
            $_SESSION['success_message'] = "Informasi Lomba berhasil ditambahkan.";
            header("Location: lomba.php");
            exit();
        } else {
            // Error in database insertion
            $error_message = "Error: " . mysqli_error($koneksi);
            echo $error_message;
            // You can handle the error as needed
        }
    } else {
        // Display validation errors
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
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
                        <h3><i class="fas fa-trophy"></i> Tambah Informasi Lomba</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active"> Tambah Informasi Lomba</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="card">
                   <div class="card" style="background-color: #0174BE;">
                        <div class="card-header">
                            <h3 class="card-title"style="margin-top:5px; color:white; font-weight:500; "><i class="far fa-list-alt"></i> Form Tambah Data Informasi Lomba</h3>
                            <div class="card-tools">
                                <a href="lomba.php" class="btn btn-sm btn-warning float-right"><i class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                <div class="card-body">
                    <form method="post" action="tambahinfolomba.php" enctype="multipart/form-data">
                        <!-- <div class="form-group">
                            <label for="foto">Foto</label>
                            <img src="..fotolomba/<?php echo $data_lomba['foto']; ?>" class="img-fluid" alt="Foto Lomba">
                        </div> -->
                        <div class="form-group">
                            <label for="foto">Foto</label>
                            <input type="file" class="form-control" name="foto" accept="image/*" required>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" name="keterangan" required></textarea>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-info">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
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
