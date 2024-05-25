<?php
   session_start();
   include('../koneksi/koneksi.php');
    $id_kategori_blog = $_POST['kategori'];
    $judul = $_POST['judul'];
    $tgl = $_POST['tanggal'];
    $isi = $_POST['isi'];
    $lokasi_file = $_FILES['cover']['tmp_name'];
    $nama_file = $_FILES['cover']['name'];
    $direktori = 'cover/'.$nama_file;

    if(empty($id_kategori_blog)){
      header("Location:tambahblog.php?notif=tambahkosong&
      jenis=kategoriblog");
   }else if(empty($judul)){
   header("Location:tambahblog.php?notif=tambahkosong&
      jenis=judul");
   }else if(empty($tgl)){
      header("Location:tambahblog.php?notif=tambahkosong&
      jenis=tanggal");
   }else if(!move_uploaded_file($lokasi_file,$direktori)){
      header("Location:tambahblog.php?notif=tambahkosong&
      jenis=cover");
    }else{

    $id_user =  $_SESSION['id_user'];

    $ex = explode("-",$tgl);
    $hari = $ex[0];
    $bulan = $ex[1];
    $tahun = $ex[2];
    $tanggal = $tahun.'-'.$bulan.'-'.$hari;

   $sql = "INSERT INTO `blog`
      (`id_kategori_blog`,`id_user`,`tanggal`,`judul`,`isi`,`cover`)
      VALUES ('$id_kategori_blog','$id_user','$tanggal','$judul','$isi','$nama_file')";
      //echo $sql;
      mysqli_query($koneksi,$sql);
      $id_blog = mysqli_insert_id($koneksi);

    //   if(!empty($_POST['tag'])){
    //      foreach($_POST['tag'] as $id_tag){
    //         $sql_i = "insert into `tag_blog` (`id_blog`, `id_tag`)
    //         values ('$id_blog', '$id_tag')";
    //         mysqli_query($koneksi,$sql_i);
    //      }
    //   }
      header("Location:blog.php?notif=tambahberhasil");
   }
?>

