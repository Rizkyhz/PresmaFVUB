<?php
session_start();

include('../admin/koneksi/koneksi.php');

if (!isset($_SESSION['id_mahasiswa'])) {
  header("Location:../login.php");
  exit();
}

$id_mahasiswa = $_SESSION['id_mahasiswa'];

$sqldashboard = "SELECT nama_mahasiswa, nim_mahasiswa, email_mahasiswa, profile_path 
                 FROM mahasiswa 
                 WHERE id_mahasiswa='$id_mahasiswa'";

$querydatamahasiswa = mysqli_query($koneksi, $sqldashboard);

if (!$querydatamahasiswa) {
  die("Error: " . mysqli_error($koneksi));
}
$fetchdetail = mysqli_fetch_assoc($querydatamahasiswa);

$nama = $fetchdetail['nama_mahasiswa'];
$nimmahasiswa = $fetchdetail['nim_mahasiswa'];
$email = $fetchdetail['email_mahasiswa'];
$profildir = $fetchdetail['profile_path'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title> PRESMA Vokasi - Edit Profile Mahasiswa</title>
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
            <a href="dash-user.php">Dashboard</a>
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
      </nav>

      <div class="container-xl px- mt-0">
        <!-- Account page navigation-->

        <hr class="mt-0 mb-4" />
        <div class="row">
          <div class="col-xl-4">
            <div class="card mb-4 mb-xl-0">
              <div class="card-header">Profile Picture</div>
              <div class="card-body text-center">
                <img style="width: 100px; height: 100px; object-fit:cover; margin-top : 30px; margin-left : 10px; border-radius: 50%; overflow: hidden;" class=" img-account-profile rounded-circle mb-2" src="<?php echo (!empty($profildir) ? '../' . $profildir : '../img/profile-user.png'); ?>" alt="" style="width: 50%" />
                <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>

                <form action="controller/profilepictureupload.php" method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="nim_mahasiswa" value="<?php echo $nimmahasiswa; ?>" />
                  <input type="hidden" name="id_mahasiswa" value="<?php echo $id_mahasiswa; ?>" />
                  <label for="fileInput" class="btn text-white" style="background-color: #003366">Upload new image</label><br>
                  <input type="file" id="fileInput" name="fileInput" style="display: none" />
                  <input type="submit" class="file-submit" value="Simpan" name="submit">
                </form>

              </div>
            </div>
          </div>
          <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
              <div class="card-header">Account Details</div>
              <div class="card-body">

                <form id="updateForm" action="controller/konfirmasieditprofile.php" method="POST">
                  <div class="mb-3">
                    <label class="small mb-1" for="inputNama">Nama </label>
                    <input class="form-control" id="inputNIM" type="text" value="<?php echo $nama; ?>" name="inputNama" placeholder="Masukan Nama" required />
                  </div>

                  <!-- Form Group (email address)-->
                  <div class="mb-3">
                    <label class="small mb-1" for="inputNIM">NIM </label>
                    <input class="form-control" id="inputNIM" type="text" value="<?php echo $nimmahasiswa; ?>" name="inputNIM" placeholder="Masukan NIM" required />
                  </div>
                  <div class="mb-3">
                    <label class="mb-1" for="inputDepartemen">Departemen</label>
                    <div class="d-flex">
                      <select class="form-select" id="inputDepartemen" onchange="updateDepartemen()">
                        <option value="" selected disabled>Pilih</option>
                        <option value="BisnisdanHospitality">Departemen Bisnis dan Hosplitality</option>
                        <option value="IndustriKreatifdanDigital">Departemen Industri Kreatif dan Digital</option>
                      </select>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label class="mb-1" for="inputProdi">Program Studi</label>
                    <div class="d-flex">
                      <select class="form-select" id="inputProdi" name="inputIdProdi">
                      </select>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label class="small mb-1" for="inputEmailAddress">Email</label>
                    <input class="form-control" id="inputEmailAddress" type="email" value="<?php echo $email; ?>" name="inputEmail" placeholder="Masukan Email" required />
                  </div>

                  <div class="mb-3">
                    <label class="small mb-1" for="inputPassword">Password</label>
                    <input class="form-control" id="inputPassword" type="password" name="inputPassword" placeholder="Masukan Password" required />
                  </div>

                  <div class="mb-3">
                    <label class="small mb-1" for="inputPassword">Confirm Password</label>
                    <input class="form-control" id="inputPassword" type="password" name="confirmpassword" placeholder="Masukan Password" required />
                  </div>

                  <!-- Save changes button-->
                  <button class="btn text-white" type="submit" style="background-color: #003366">
                    Save changes
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="../js/jquery.min.js"></script>
  <script src="../js/popper.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/main-dash.js"></script>
  <script src="../js/register-dropdown.js"></script>

</body>

</html>