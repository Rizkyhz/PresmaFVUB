<!DOCTYPE html>
<html>
<?php
session_start();
$page = isset($_GET['page']) ? ($_GET['page']) : false;
// Modify the condition to allow users with id_role 0 or 1
if ($_SESSION['id_role'] != '0' && $_SESSION['id_role'] != '1') {
    header("Location: index.php");
    exit();
}


include('koneksi/koneksi.php');
$id_user = $_SESSION['id_user'];

// Get profil user
$sql = "SELECT `username`, `email`,`password`, `id_role` FROM `user` WHERE `id_user`=$id_user";
$query = mysqli_query($koneksi, $sql);

while ($data = mysqli_fetch_row($query)) {
    $username = $data[0];
    $email = $data[1];
    $password = $data[2];
    $role = $data[3];
}
?>
<head>
    <?php include("includes/head.php") ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include("includes/header.php") ?>
        <?php include("includes/sidebar.php") ?>

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h3><i class="fas fa-user-tie"></i> Edit Profil</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="profil.php">Profil</a></li>
                                <li class="breadcrumb-item active">Edit Profil</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="card">
                    <div class="card-body">
                        <!-- Form untuk mengedit profil -->
                        <form class="form-horizontal" method="post" action="konfirmasieditprofil.php">
                            <!-- Isi form sesuai kebutuhan -->
                            <!-- Contoh: -->
                            <div class="form-group row">
                                <label for="username" class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="username" id="username" value="<?php echo $username; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="email" id="email" value="<?php echo $email; ?>">
                                </div>
                            </div>
                            <!-- Tambahkan field lain sesuai kebutuhan -->
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <button name="submit" type="submit" class="btn btn-info float-right"><i class="fas fa-save"></i> Simpan</button>
                                </div>
                            </div>
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

    <?php include("includes/script.php") ?>
</body>
</html>
