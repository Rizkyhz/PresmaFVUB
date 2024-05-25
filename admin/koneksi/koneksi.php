<?php
$koneksi = mysqli_connect("localhost","root","","presma_ub");
// cek koneksi
if (!$koneksi){
  die("Error koneksi: " . mysqli_connect_errno());
}
?>
