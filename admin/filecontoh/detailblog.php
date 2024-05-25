<?php
session_start();
include('../koneksi/koneksi.php');
if(isset($_GET['data'])){
  $id_blog = $_GET['data'];
  //gat data blog
  $sql = "SELECT `b`.`cover`,`k`.`kategori_blog`,`b`.`judul`,
        `b`.`isi`, DATE_FORMAT(`b`.`tanggal`,'%d-%m-%Y')
        FROM `blog` `b`
        INNER JOIN `kategori_blog` `k` ON
        `b`.`id_kategori_blog`=`k`.`id_kategori_blog`
        WHERE `b`.`id_blog`='$id_blog'";
  $query = mysqli_query($koneksi,$sql);
  while($data = mysqli_fetch_row($query)){
    $cover = $data[0];
    $kategori_blog = $data[1];
    $judul = $data[2];
    $isi = $data[3];
    $tanggal = $data[4];
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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3><i class="fas fa-user-tie"></i> Detail Data Blog</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="blog.php">Data Blog</a></li>
              <li class="breadcrumb-item active">Detail Data Blog</li>
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
                  <a href="blog.php" class="btn btn-sm btn-warning float-right">
                  <i class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <td><strong>Cover Blog<strong></td>
                        <td><img src="cover/<?php echo $cover;?>"  class="img-fluid" width="200px;"></td>
                      </tr>
                      <tr>
                        <td width="20%"><strong>Tanggal<strong></td>
                        <td width="80%"><?php echo $tanggal;?></td>
                      </tr>
                      <tr>
                        <td width="20%"><strong>Kategori Blog<strong></td>
                        <td width="80%"><?php echo $kategori_blog;?></td>
                      </tr>
                      <tr>
                        <td width="20%"><strong>Judul<strong></td>
                        <td width="80%"><?php echo $judul;?></td>
                      </tr>
                      <!-- <tr>
                        <td><strong>Tag<strong></td>
                        <td>
                          <ul>
                          <?php
                            //get tag
                            $sql_h = "SELECT `t`.`tag` from `tag_blog` `tb`
                                      inner join `tag` `t`
                                       ON  `tb`.`id_tag` = `t`.`id_tag`
                                      where `tb`.`id_blog`='$id_blog'";
                            $query_h = mysqli_query($koneksi,$sql_h);
                            while($data_h = mysqli_fetch_row($query_h)){
                            $tag= $data_h[0];
                            ?>
                            <li><?php echo $tag;?></li>
                            <?php }?>

                          </ul>
                        </td>
                      </tr> -->
                      <tr>
                        <td width="20%"><strong>Isi<strong></td>
                        <td width="80%"><?php echo $isi;?></td>
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
