<?php
session_start();
include('koneksi/koneksi.php');

// Query untuk mendapatkan data role dari tabel user_role
$queryRole = mysqli_query($koneksi, "SELECT * FROM user_role");
?>

<!DOCTYPE html>
<html lang="en">

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
                            <h3><i class="fas fa-user-tie"></i> Tambah User</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="user.php">Data User</a></li>
                                <li class="breadcrumb-item active">Tambah User</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="card">
              <div class="card" style="background-color: #0174BE;">
                  <div class="card-header">
                     <h3 class="card-title"style="margin-top:5px; color:white; font-weight:500; "><i class="far fa-list-alt"></i> Form Tambah Data User</h3>
                     <div class="card-tools">
                        <a href="user.php" class="btn btn-sm btn-warning float-right"><i class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
                     </div>
                  </div>
               </div>
                    <div class="card-body">
                        <form method="post" action="konfirmasitambahuser.php">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                              <label for="password">Password</label>
                              <input type="password" class="form-control" id="password" name="password" required>
                           </div>
                            <div class="form-group">
                                <label for="id_role">Role</label>
                                <select class="form-control" id="id_role" name="id_role" value="" required>
                                    <option value="">Pilih Role</option>
                                    <?php while ($role = mysqli_fetch_assoc($queryRole)) { ?>
                                        <option value="<?php echo $role['id_role']; ?>"><?php echo $role['nama_role']; ?></option>
                                    <?php } ?>
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
    <?php include("includes/script.php") ?>
</body>

</html>
