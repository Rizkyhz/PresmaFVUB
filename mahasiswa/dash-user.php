<?php
session_start();

include('../admin/koneksi/koneksi.php');

if (!isset($_SESSION['id_mahasiswa'])) {
  header("Location:../login.php");
  exit();
}

$id_mahasiswa = $_SESSION['id_mahasiswa'];

$sqldetailprestasi = "SELECT capaian, nama_prestasi, tingkatkejuaraan.tingkatan AS tingkat, st_path, prestasi_path, statusprestasi.nama_status
                      FROM prestasimahasiswa
                      JOIN tingkatkejuaraan ON prestasimahasiswa.id_tingkat_kejuaraan = tingkatkejuaraan.id_tingjur
                      JOIN statusprestasi ON prestasimahasiswa.id_status = statusprestasi.id_statusprestasi
                      WHERE id_mahasiswa = '$id_mahasiswa'";

$sqljumlahprestasi = "SELECT COUNT(*) AS jumlah_prestasi 
                      FROM prestasimahasiswa 
                      WHERE id_mahasiswa = '$id_mahasiswa' AND id_status = 1;";

$sqldashboard = "SELECT mahasiswa.nama_mahasiswa, mahasiswa.nim_mahasiswa, profile_path, prodi.nama_prodi, departemen.nama_departemen 
                 FROM mahasiswa 
                 JOIN prodi ON mahasiswa.id_prodi_mahasiswa = prodi.id_prodi 
                 JOIN departemen ON prodi.id_departemen_prodi = departemen.id_departemen 
                 WHERE mahasiswa.id_mahasiswa='$id_mahasiswa'";

$queryjumlahprestasi = mysqli_query($koneksi, $sqljumlahprestasi);
$querydatamahasiswa = mysqli_query($koneksi, $sqldashboard);
$querydetailprestasi = mysqli_query($koneksi, $sqldetailprestasi);

if (!$queryjumlahprestasi || !$querydatamahasiswa || !$sqldetailprestasi) {
  die("Error: " . mysqli_error($koneksi));
}

$fetchdetailprestasi = mysqli_fetch_all($querydetailprestasi, MYSQLI_ASSOC);
$fetchdetail = mysqli_fetch_assoc($querydatamahasiswa);
$fetchprestasi = mysqli_fetch_assoc($queryjumlahprestasi);

$jumlahprestasi = $fetchprestasi['jumlah_prestasi'];
$nama = $fetchdetail['nama_mahasiswa'];
$nimmahasiswa = $fetchdetail['nim_mahasiswa'];
$programstudi = $fetchdetail['nama_prodi'];
$departemen = $fetchdetail['nama_departemen'];
$profildir = $fetchdetail['profile_path'];

mysqli_close($koneksi);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title> PRESMA Vokasi - Dashboard Mahasiswa</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet" />

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="../css/style-dashboard.css" />
</head>

<body>
  <div class="wrapper d-flex align-items-stretch">
    <nav id="sidebar" style="background-color: #003366">
      <div class="p-4 pt-5">
        <a href="#" class="img logo rounded-circle mb-5" style="background-image: url(../img/logo-prestasi.png)"></a>
        <ul class="list-unstyled components mb-5">
          <li class="active"></li>
          <li>
            <a href="edit-user.php">Edit Profil</a>
          </li>
          <li>
            <a href="pengajuan-user.php">Pengajuan Prestasi</a>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Page Content  -->
    <div id="content" class="p-4 p-md-5">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <button type="button" id="sidebarCollapse" class="btn btn-primary">
            <i class="fa fa-bars"></i>
            <span class="sr-only">Toggle Menu</span>
          </button>
          <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars"></i>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav navbar-nav ml-auto">
              <li class="nav-item active">
                <a class="nav-link text-secondary" href="index-user.php">Home</a>
              </li>
              <li class="nav-item dropdown text-secondary">
                <a class="nav-link dropdown-toggle text-secondary" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Prestasi
                </a>
                <div class="dropdown-menu " aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="user-data-prestasi.php">Data Prestasi</a>
                  <a class="dropdown-item" href="user-galeri-prestasi.php">Galeri Prestasi</a>
                  <a class="dropdown-item" href="user-grafik-prestasi.php">Grafik Data Prestasi</a>
                </div>
              </li>
              <li class="nav-item dropdown text-secondary">
                <a class="nav-link dropdown-toggle text-secondary" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Lainnya
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="user-info-lomba.php">Informasi Lomba</a>
                  <a class="dropdown-item" href="pengajuan-user.php">Pengajuan Prestasi</a>
                </div>
              <li class="nav-item active">
                <a class="nav-link text-secondary" href="user-bantuan.php">Bantuan</a>
              </li>
              </li>
            </ul>
          </div>
        </div>
      </nav>

      <div class="card text-white" style="background-color: #003366; border-radius: 10px">
        <div class="card-header">PROFIL</div>
        <dif class="d-flex flex-wrap">
          <div style="margin-left : 10px;">
            <img style="width: 100px; height: 100px; object-fit:cover; margin-top : 30px; margin-left : 10px; border-radius: 50%; overflow: hidden;" class=" img-account-profile rounded-circle mb-2" src="<?php echo (!empty($profildir) ? '../' . $profildir : '../img/profile-user.png') ?>" alt="" style="width: 50%" />
          </div>
          <div class=" card-body">
            <h4 class="text-white"><?php echo $nama; ?></h4>
            <p><?php echo $nimmahasiswa; ?></p>
            <p><?php echo $programstudi; ?> / <?php echo $departemen; ?></p>
          </div>
        </dif>
      </div>

      <br />

      <div class="card text-white col-md-6" style="border-radius: 10px; background-color: #ff9900">
        <div class="card-header">Jumlah Prestasi</div>
        <div class="d-flex flex-wrap">
          <div class="ms-3 my-3">
            <img src="../img/piala.png" alt="" style="width: 100px" />
          </div>
          <div class="card-body">
            <h1><?php echo $jumlahprestasi; ?> Prestasi</h1>
          </div>
        </div>
      </div>

      <br />

      <div class="table-responsive">
        <table class="table table-hover table-striped">
          <thead class="text-center" style="background-color: #003366; color: #fff">
            <trtr style='text-align: center;'>
              <th>No</th>
              <th>Capaian</th>
              <th>Nama Prestasi</th>
              <th>Tingkat</th>
              <th>Sertifikat</th>
              <th>Status Pengajuan</th>
              <th>Surat Tugas</th>
              </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            if (empty($fetchdetailprestasi)) {
              echo "<tr><th colspan='7' style='text-align: center; font-family: Poppins;'>Maaf, Anda tidak memiliki data Prestasi</th></tr>";
            } else {
              foreach ($fetchdetailprestasi as $row) {
                echo "<tr style='text-align: center;'>";
                echo "<th style='font-family: Poppins;'>" . $no++ . "</th>";
                echo "<th style='font-family: Poppins;'>" . $row['capaian'] . "</th>";
                echo "<th style='font-family: Poppins;'>" . $row['nama_prestasi'] . "</th>";
                echo "<th style='font-family: Poppins;'>" . $row['tingkat'] . "</th>";
                if (!empty($row['prestasi_path'])) {
                  echo "<th style='font-family: Poppins;'><a href='" . $row['prestasi_path'] . "' download>Unduh Prestasi</a></th>";
                } else {
                  echo "<th style='font-family: Poppins;'>No File</th>";
                }
                $buttonStyle = "";
                switch ($row['nama_status']) {
                  case "Berhasil":
                    $buttonStyle = "background-color: green; color: white; border: none";
                    break;
                  case "Gagal":
                    $buttonStyle = "background-color: red; color: white; border: none";
                    break;
                  case "Dalam Antrean":
                    $buttonStyle = "background-color: blue; color: white; border: none";
                    break;
                  case "Diproses":
                    $buttonStyle = "background-color: yellow; color: black; border: none";
                    break;
                }

                echo "<th><button style='" . $buttonStyle . "'>" . $row['nama_status'] . "</button></th>";
                if (!empty($row['st_path'])) {
                  echo "<th style='font-family: Poppins;'><a href='" . $row['st_path'] . "' download>Unduh Surat Tugas</a></th>";
                } else {
                  echo "<th style='font-family: Poppins;'>No File</th>";
                }
                echo "</tr>";
              }
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="../js/jquery.min.js"></script>
  <script src="../js/popper.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/main-dash.js"></script>
</body>

</html>