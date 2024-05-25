<?php
include('koneksi/koneksi.php');

// Check if user ID is provided in the URL
if (isset($_GET['id_user'])) {
    $userId = $_GET['id_user'];

    // Fetch user details based on the provided ID
    $sql = "SELECT `username`, `email`,`password`, `nama_role` FROM `user` INNER JOIN user_role ON user.id_role = user_role.id_role WHERE id_user = $userId";
    $query = mysqli_query($koneksi, $sql);

    // Check if the user exists
    if ($query && mysqli_num_rows($query) > 0) {
        $userData = mysqli_fetch_assoc($query);
        $username = $userData['username'];
        $email = $userData['email'];
        $password = $userData['password'];
        $role = $userData['nama_role'];
    } else {
        // Redirect to the user list page if the user does not exist
        header("Location: user.php");
        exit();
    }
} else {
    // Redirect to the user list page if no user ID is provided
    header("Location: user.php");
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
                      <h3 class="card-title"style="margin-top:5px; color:white; font-weight:500; "><i class="far fa-list-alt"></i> Form Edit Data User</h3>
                      <div class="card-tools">
                          <a href="user.php" class="btn btn-sm btn-warning float-right"><i class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
                      </div>
                    </div>
                </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                      <form method="POST" action="konfirmasiedituser.php">
                          <input type="hidden" name="id_user" value="<?php echo $userId; ?>">
                          <div class="card-body">
                          <div class="form-group row">
                            <label for="username" class="col-sm-3 col-form-label">username</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" name="username"
                                id="username" value="<?php echo $username;?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" name="email"
                              id="email" value="<?php echo $email;?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="password" class="col-sm-3 col-form-label">password</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" name="password"
                              id="password" value="<?php echo $password;?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="role" class="col-sm-3 col-form-label">role</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" name="role"
                              id="id_role" value="<?php echo $role;?>" readonly>
                            </div>
                          </div>
                          <div class="col-sm-12">
                            <button type="submit" class="btn btn-info float-right">
                              <i class="fas fa-save"></i> Simpan</button>
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
