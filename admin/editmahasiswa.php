<?php
include('koneksi/koneksi.php');
session_start();

// Check if the ID parameter is set
if (isset($_GET['id_mahasiswa'])) {
    $id_mahasiswa = $_GET['id_mahasiswa'];

    // Fetch mahasiswa data based on the ID
    $query = mysqli_query($koneksi, "SELECT * FROM `mahasiswa` INNER JOIN `prodi` ON mahasiswa.id_prodi_mahasiswa = prodi.id_prodi WHERE `id_mahasiswa` = $id_mahasiswa");

    // Check if the query was successful
    if ($query) {
        // Fetch the data as an associative array
        $mahasiswa_data = mysqli_fetch_assoc($query);
    } else {
        // Handle the case where the query was not successful
        die("Error fetching data: " . mysqli_error($koneksi));
    }
} else {
    // If the ID parameter is not set, redirect or handle accordingly
    header("Location: mahasiswa.php"); // Redirect to the list page
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Perform update query based on the submitted form data
    $new_nama_mahasiswa = $_POST['nama_mahasiswa'];
    $new_nim_mahasiswa = $_POST['nim_mahasiswa'];
    $new_email_mahasiswa = $_POST['email_mahasiswa'];
    $new_password = $_POST['password'];

    $update_query = mysqli_query($koneksi, "UPDATE `mahasiswa` SET
                        `nama_mahasiswa` ='$new_nama_mahasiswa',
                        `nim_mahasiswa` = '$new_nim_mahasiswa',
                        `email_mahasiswa` = '$new_email_mahasiswa',
                        `password` = '$new_password'
                        WHERE `id_mahasiswa` = $id_mahasiswa");

    // Check if the update query was successful

    if ($update_query) {
        // Redirect to the list page after successful update
        echo '<script>alert("Berita berhasil diedit."); window.location.href = "mahasiswa.php";</script>';
        exit();
    } else {
        // Handle the case where the update query was not successful
        die("Error updating data: " . mysqli_error($koneksi));
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("includes/head.php") ?>
    <title>Edit Mahasiswa</title>
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
                            <h1>Edit Mahasiswa</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="mahasiswa.php">Data Mahasiswa</a></li>
                                <li class="breadcrumb-item active">Edit Mahasiswa</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="card">
                    <div class="card" style="background-color: #0174BE;">
                        <div class="card-header">
                            <h3 class="card-title" style="margin-top:5px; color:white; font-weight:500; "><i class="far fa-list-alt"></i> Form Edit Data Mahasiswa</h3>
                            <div class="card-tools">
                                <a href="mahasiswa.php" class="btn btn-sm btn-warning float-right"><i class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Display success message if it exists in the session -->
                        <form action="editmahasiswa.php?id_mahasiswa=<?php echo $id_mahasiswa; ?>" method="post">
                            <div class="form-group">
                                <label for="nama_mahasiswa">Nama Mahasiswa</label>
                                <input type="text" class="form-control" id="nama_mahasiswa" name="nama_mahasiswa" value="<?php echo $mahasiswa_data['nama_mahasiswa']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="new_nim_mahasiswa">NIM</label>
                                <input type="text" class="form-control" id="new_nim_mahasiswa" name="nim_mahasiswa" value="<?php echo $mahasiswa_data['nim_mahasiswa']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="new_prodi_mahasiswa">Program Studi</label>
                                <input type="text" class="form-control" id="id_prodi_mahasiswa" name="id_prodi_mahasiswa" value="<?php echo $mahasiswa_data['nama_prodi']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="new_email_mahasiswa">Email</label>
                                <input type="email" class="form-control" id="new_email_mahasiswa" name="email_mahasiswa" value="<?php echo $mahasiswa_data['email_mahasiswa']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="new_email_mahasiswa">Password</label>
                                <input type="text" class="form-control" id="password" name="password" value="<?php echo $mahasiswa_data['password']; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
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