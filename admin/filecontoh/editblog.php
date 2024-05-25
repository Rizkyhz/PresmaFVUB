<?php
session_start();
include('../koneksi/koneksi.php');
if(isset($_GET['data'])){
  $id_blog = $_GET['data'];
  $_SESSION['id_blog']=$id_blog;
  //get data blog
  $sql_m = "SELECT `id_kategori_blog`,`judul`,`isi`, DATE_FORMAT(`tanggal`,'%d-%m-%Y')
  FROM `blog` WHERE `id_blog`='$id_blog'";
  $query_m = mysqli_query($koneksi,$sql_m);
  while($data_m = mysqli_fetch_row($query_m)){
    $id_kategori_blog= $data_m[0];
    $judul = $data_m[1];
    $isi = $data_m[2];
    $tanggal = $data_m[3];
  }
  //get tag
  $sql_h = "select `id_tag` from `tag_blog`
        where `id_blog`='$id_blog'";
  $query_h = mysqli_query($koneksi,$sql_h);
  $array_tag = array();
  while($data_h = mysqli_fetch_row($query_h)){
    $id_tag= $data_h[0];
    $array_tag[] = $id_tag;
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
            <h3><i class="fas fa-edit"></i> Edit Data Blog</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="blog.php">Data Blog</a></li>
              <li class="breadcrumb-item active">Edit Data Blog</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title"style="margin-top:5px;"><i class="far fa-list-alt"></i> Form Edit Data Blog</h3>
        <div class="card-tools">
          <a href="blog.php" class="btn btn-sm btn-warning float-right">
          <i class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
        </div>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      </br></br>
      <div class="col-sm-10">
        <?php if((!empty($_GET['notif']))&&(!empty($_GET['jenis']))){?>
          <?php if($_GET['notif']=="editkosong"){?>
            <div class="alert alert-danger" role="alert">Maaf data
            <?php echo $_GET['jenis'];?> wajib di isi</div>
          <?php }?>
        <?php }?>

      </div>

<form class="form-horizontal" action="konfirmasieditblog.php" method="post"
      enctype="multipart/form-data">
        <div class="card-body">
        <div class="form-group row">
            <label for="foto" class="col-sm-3 col-form-label">Cover Blog </label>
            <div class="col-sm-7">
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="cover"
                id="customFile">
                <label class="custom-file-label" for="customFile">
                Choose file</label>
              </div>
            </div>
          </div>
        <div class="form-group row">
            <label for="kategori" class="col-sm-3 col-form-label">
             Kategori Blog</label>
            <div class="col-sm-7">
              <select class="form-control" name="kategori" id="kategori">
              <?php
                $sql_k = "SELECT `id_kategori_blog`,`kategori_blog` FROM
                `kategori_blog` ORDER BY `kategori_blog`";
                $query_k = mysqli_query($koneksi, $sql_k);
                while($data_k = mysqli_fetch_row($query_k)){
                      $id_kat = $data_k[0];
                      $kat = $data_k[1];
                ?>
                      <option value="<?php echo $id_kat;?>"
                      <?php if($id_kategori_blog==$id_kat){?>selected<?php }?>>
                      <?php echo $kat;?></option>
                <?php }?>

              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="nim" class="col-sm-3 col-form-label">Judul</label>
            <div class="col-sm-7">
              <input type="text" class="form-control" name="judul" id="judul"
               value="<?php echo $judul;?>">
            </div>
          </div>
          <div class="form-group row">
            <label for="tanggal" class="col-sm-3 col-form-label">Tanggal</label>
            <div class="col-sm-7">
              <div class="input-group date">
                <input type="text" class="form-control" name="tanggal"
                   id="datepicker"  autocomplete="off"
                value="<?php echo $tanggal;?>">
                  <div class="input-group-append">
                    <span class="input-group-text">
                    <i class="fas fa-calendar-alt"></i></span>
                  </div>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="isi" class="col-sm-3 col-form-label">Isi</label>
            <div class="col-sm-7">
              <textarea class="form-control" name="isi" id="editor1" rows="12">
              Lorem Ipsum</textarea>
            </div>
          </div>
          <!-- <div class="form-group row">
            <label for="hobi" class="col-sm-3 col-form-label">Tag</label>
            <div class="col-sm-7">
              <?php
              $sql_g = "SELECT `id_tag`,`tag` FROM `tag`
                        ORDER BY `tag`";
              $query_g = mysqli_query($koneksi, $sql_g);
              while($data_g = mysqli_fetch_row($query_g)){
                  $id_tg = $data_g[0];
                  $tg = $data_g[1];
              ?>
              <input type="checkbox"  name="tag[]" value="<?php echo $id_tg;?>"
              <?php if(in_array($id_tg, $array_tag)){?>checked="checked"
               <?php }?>>
              <?php echo $tg;?> </br>
              <?php }?>
            </div>
          </div> -->

          </div>
        </div>

      </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <div class="col-sm-12">
            <button type="submit" class="btn btn-info float-right">
        <i class="fas fa-save"></i> Simpan</button>
          </div>
        </div>
        <!-- /.card-footer -->
      </form>

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
