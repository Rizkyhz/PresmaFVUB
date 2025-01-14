<!DOCTYPE html>
<html>
  <?php
session_start();
$id_user = $_SESSION['id_user'];
include('koneksi/koneksi.php');

//get profil
$sql = "select `username`, `email`,`password`, `id_role` from `user`
 where `id_user`='$id_user'";
 //echo $sql;
$query = mysqli_query($koneksi, $sql);
while($data = mysqli_fetch_row($query)){
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
            <h3><i class="fas fa-user-tie"></i> Profil</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Profil</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
            <div class="card">
              <div class="card-header">
                <div class="card-tools">
                  <a href="edituser.php" class="btn btn-sm btn-info float-right"><i class="fas fa-edit"></i> Edit Profil</a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="col-sm-12">
                <?php if(!empty($_GET['notif'])){
                  if($_GET['notif']=="editberhasil"){?>
                     <div class="alert alert-success" role="alert">
                     Data Berhasil Diubah</div>
                 <?php }?>
                 <?php }?>
                      </div>
                <table class="table table-bordered">
                      <tbody>
                         <tr>
                             <td colspan="2"><i class="fas fa-user-circle"></i>
		                            <strong>PROFIL<strong></td>
                         </tr>
                         <tr>
                            <td width="20%"><strong>Username<strong></td>
                            <td width="80%"><?php echo $username; ?></td>
                          </tr>
                          <tr>
                            <td width="20%"><strong>Email<strong></td>
                            <td width="80%"><?php echo $email;?></td>
                         </tr>
                          <tr>
                          <td width="20%"><strong>Password<strong></td>
                          <td width="80%"><?php echo $password;?></td>
                         </tr>
                          <tr>
                          <td width="20%"><strong>Status<strong></td>
                          <td width="80%"><?php echo $role;?></td>
                         </tr>
                       </tbody>
                  </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">&nbsp;</div>
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