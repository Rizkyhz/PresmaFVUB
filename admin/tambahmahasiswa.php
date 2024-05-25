<?php
include('koneksi/koneksi.php');

// Start a session
session_start();

// Initialize variables for form validation
$nama_mahasiswa_error = $nim_mahasiswa_error = $email_mahasiswa_error = $prodi_mahasiswa_error = $password_error = '';

// Fetch program study data from the prodi table
$prodi_query = mysqli_query($koneksi, "SELECT * FROM `prodi`");
$prodi_data = mysqli_fetch_all($prodi_query, MYSQLI_ASSOC);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Perform validation on form data
    $nama_mahasiswa = trim($_POST['nama_mahasiswa']);
    $nim_mahasiswa = trim($_POST['nim_mahasiswa']);
    $email_mahasiswa = trim($_POST['email_mahasiswa']);
    $prodi_mahasiswa = trim($_POST['id_prodi_mahasiswa']);
    $password = trim($_POST['password']);

    // Validate nama_mahasiswa
    if (empty($nama_mahasiswa)) {
        $nama_mahasiswa_error = 'Nama Mahasiswa is required';
    }

    // Validate nim_mahasiswa
    if (empty($nim_mahasiswa)) {
        $nim_mahasiswa_error = 'NIM is required';
    }

    // Validate email_mahasiswa
    if (empty($email_mahasiswa)) {
        $email_mahasiswa_error = 'Email is required';
    }

    // Validate prodi_mahasiswa
    if (empty($prodi_mahasiswa)) {
        $prodi_mahasiswa_error = 'Program Studi is required';
    }

    // Validate password
    if (empty($password)) {
        $password_error = 'Password is required';
    }

    // If there are no validation errors, insert the new mahasiswa
    if (empty($nama_mahasiswa_error) && empty($nim_mahasiswa_error) && empty($email_mahasiswa_error) && empty($prodi_mahasiswa_error) && empty($password_error)) {
        // Use prepared statements to prevent SQL injection
        $insert_query = mysqli_prepare($koneksi, "INSERT INTO `mahasiswa` (`nama_mahasiswa`, `nim_mahasiswa`, `email_mahasiswa`, `id_prodi_mahasiswa`, `password`) VALUES (?, ?, ?, ?, ?)");
        // Bind parameters
        mysqli_stmt_bind_param($insert_query, "sssss", $nama_mahasiswa, $nim_mahasiswa, $email_mahasiswa, $prodi_mahasiswa, $password);

        // Execute the statement
        $success = mysqli_stmt_execute($insert_query);

        // Check if the insert query was successful
        if ($success) {
            // Set a success message in the session
            $_SESSION['success_message'] = 'Mahasiswa berhasil ditambahkan.';

            // Redirect to the list page after successful insert
            header("Location: mahasiswa.php");
            exit();
        } else {
            // Handle the case where the insert query was not successful
            die("Error adding data: " . mysqli_error($koneksi));
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("includes/head.php") ?>
    <title>Tambah Mahasiswa</title>
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
                            <h1>Tambah Mahasiswa</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="mahasiswa.php">Data Mahasiswa</a></li>
                                <li class="breadcrumb-item active">Tambah Mahasiswa</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="card">
                    <div class="card" style="background-color: #0174BE;">
                        <div class="card-header">
                            <h3 class="card-title"style="margin-top:5px; color:white; font-weight:500; "><i class="far fa-list-alt"></i> Form Tambah Data Mahasiswa</h3>
                            <div class="card-tools">
                                <a href="mahasiswa.php" class="btn btn-sm btn-warning float-right"><i class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Display validation errors if any -->
                        <?php if (!empty($nama_mahasiswa_error) || !empty($nim_mahasiswa_error) || !empty($email_mahasiswa_error) || !empty($prodi_mahasiswa_error) || !empty($password_error)): ?>
                            <div class="alert alert-danger" role="alert">
                                <ul>
                                    <?php echo !empty($nama_mahasiswa_error) ? "<li>$nama_mahasiswa_error</li>" : ''; ?>
                                    <?php echo !empty($nim_mahasiswa_error) ? "<li>$nim_mahasiswa_error</li>" : ''; ?>
                                    <?php echo !empty($email_mahasiswa_error) ? "<li>$email_mahasiswa_error</li>" : ''; ?>
                                    <?php echo !empty($prodi_mahasiswa_error) ? "<li>$prodi_mahasiswa_error</li>" : ''; ?>
                                    <?php echo !empty($password_error) ? "<li>$password_error</li>" : ''; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form action="tambahmahasiswa.php" method="post">
                            <div class="form-group">
                                <label for="nama_mahasiswa">Nama Mahasiswa</label>
                                <input type="text" class="form-control" id="nama_mahasiswa" name="nama_mahasiswa" value="<?php echo isset($_POST['nama_mahasiswa']) ? $_POST['nama_mahasiswa'] : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="nim_mahasiswa">NIM</label>
                                <input type="text" class="form-control" id="nim_mahasiswa" name="nim_mahasiswa" value="<?php echo isset($_POST['nim_mahasiswa']) ? $_POST['nim_mahasiswa'] : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email_mahasiswa">Email</label>
                                <input type="email" class="form-control" id="email_mahasiswa" name="email_mahasiswa" value="<?php echo isset($_POST['email_mahasiswa']) ? $_POST['email_mahasiswa'] : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="prodi_mahasiswa">Program Studi</label>
                                <select class="form-control" id="id_prodi_mahasiswa" name="id_prodi_mahasiswa" required value="">
                                    <option value="" disabled selected>Select Program Studi</option>
                                    <?php foreach ($prodi_data as $prodi): ?>
                                        <option value="<?php echo $prodi['id_prodi']; ?>"><?php echo $prodi['nama_prodi']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Tambah</button>
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
