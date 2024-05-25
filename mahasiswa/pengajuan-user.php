<?php

session_start();

include('../admin/koneksi/koneksi.php');

if (!isset($_SESSION['id_mahasiswa'])) {
  header("Location:../login.php");
  exit();
}

$querydospem = "SELECT id_dosen, nama_dosen FROM dosen";
$result = $koneksi->query($querydospem);

$id_mahasiswa = $_SESSION['id_mahasiswa'];

if (isset($_POST['kirim'])) {
  $id_status = isset($_POST['3']) ? $_POST['3'] : 3;

  if (isset($_FILES['fileInput'])) {
    $file = $_FILES['fileInput'];

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($fileExtension, $allowedExtensions)) {
      header("Location:pengajuan-user.php?failed=invalidfile");
      exit();
    }

    $maxFileSize = 5 * 1024 * 1024;
    if ($file['size'] > $maxFileSize) {
      header("Location:dash-user.php?failed=toolargefile");
      exit();
    }

    $fileName = 'prestasi-' . uniqid() . '.' . $fileExtension;
    $filePath = 'data-prestasi/' . $fileName;
    $dir = 'data-prestasi/' . $fileName;

    move_uploaded_file($file['tmp_name'], $filePath);


    mysqli_query(
      $koneksi,
      "INSERT INTO prestasimahasiswa SET 
    id_mahasiswa = '$id_mahasiswa',
    id_status = '$id_status',
    angkatan = '$_POST[angkatan]',
    id_jenis_prestasi = '$_POST[id_jenis_prestasi]',
    capaian = '$_POST[capaian]',
    id_tingkat_kejuaraan = '$_POST[id_tingkat_kejuaraan]',
    nama_prestasi = '$_POST[nama_prestasi]',
    status_ormawa = '$_POST[delegasiOrmawa]',
    nama_ormawa = '$_POST[nama_ormawa]',
    id_pembimbing = '$_POST[id_pembimbing]',
    lokasi = '$_POST[lokasi]',
    lembaga_penyelenggara = '$_POST[lembaga_penyelenggara]',
    tanggal_pelaksanaan_awal = '$_POST[tanggal_pelaksanaan_awal]',
    tanggal_pelaksanaan_akhir = '$_POST[tanggal_pelaksanaan_akhir]',
    jenis_kepesertaan = '$_POST[jenis_kepesertaan]',
    url_prestasi = '$_POST[url_prestasi]',
    deskripsi_kegiatan = '$_POST[deskripsi]',
    prestasi_path = '$dir'"
    );

    echo "Record inserted successfully";

    echo "Error: " . mysqli_error($koneksi);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title> PRESMA Vokasi - Form Pengajuan</title>
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
            <a href="edit-user.php">Edit Profil</a>
          </li>
          <li>
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
                <a class="nav-link" href="index-user.php">Home</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Prestasi
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="data-prestasi.php">Data Prestasi</a>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Lainnya
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="galeri-prestasi.php">Galeri Prestasi</a>
                  <a class="dropdown-item" href="info-lomba.php">Informasi Lomba</a>
                  <a class="dropdown-item" href="data-prestasi.php">Grafik Data Prestasi</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>

      <div class="container-xl px- mt-0">
        <hr class="mt-0 mb-4" />
        <div class="row">
          <div class="col-12">
            <div class="card mb-4">
              <div class="card-header">Form Pengajuan Prestasi</div>
              <div class="card-body">
                <form id="yourFormId" method="post" enctype="multipart/form-data">
                  <div class="mb-3">
                    <label class="mb-1" for="inputAngkatan">Angkatan</label>
                    <input class="form-control" id="inputangkatan" type="text" name="angkatan" placeholder="Masukkan Tahun Angkatan" required />
                  </div>

                  <div class="mb-3">
                    <label class="mb-1" for="inputBidangMinat">Bidang Minat</label>
                    <div class="d-flex">
                      <select class="form-select" id="inputBidangMinat" onchange="updateBidangMinat()">
                        <option value="" selected disabled>Pilih</option>
                        <option value="PenalarandanKreatifitas">Penalaran dan Kreatifitas</option>
                        <option value="SeniMinatdanPrestasi">Seni, Minat dan Prestasi</option>
                        <option value="Kewirausahaan">Kewirausahaan</option>
                      </select>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label class="mb-1" for="inputJenisKejuaraan">Jenis Kejuaraan</label>
                    <div class="d-flex">
                      <select class="form-select" id="inputJenisKejuaraan" name="id_jenis_prestasi" required>
                      </select>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label class="mb-1" for="inputJenisKepesertaan">Tingkat Kejuaraan</label>
                    <div class="d-flex">
                      <select class="form-select" id="inputJenisKepesertaan" name="id_tingkat_kejuaraan" onchange="showMembersInput()" required>
                        <option value="" selected disabled>Pilih</option>
                        <option value="1">Lokal</option>
                        <option value="2">Kabupaten</option>
                        <option value="3">Provinsi</option>
                        <option value="4">Nasional</option>
                        <option value="5">Internasional</option>
                      </select>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label class="mb-1" for="inputPrestasi">Capaian Prestasi</label>
                    <input class="form-control" id="inputPrestasi" type="text" name="capaian" placeholder="Masukkan Capaian Prestasi" required />
                  </div>

                  <div class="mb-3">
                    <label class="small mb-1" for="inputNamaKegiatan">Nama Prestasi</label>
                    <input class="form-control" id="inputNamaKegiatan" type="text" name="nama_prestasi" placeholder="Masukkan Nama Kegiatan" required />
                  </div>

                  <div class="mb-3">
                    <label class="mb-1">Delegasi ORMAWA</label><br>
                    <input type="radio" id="yesDelegasi" name="delegasiOrmawa" value="1" />
                    <label for="yesDelegasi">Ya</label>
                    <input type="radio" id="noDelegasi" name="delegasiOrmawa" value="0" />
                    <label for="noDelegasi">Tidak</label>
                  </div>

                  <div id="namaOrmawa" style="display: none;">
                    <label class="small mb-1" for="inputNamaOrmawa">Nama ORMAWA</label>
                    <input class="form-control" id="inputNamaOrmawa" type="text" name="nama_ormawa" placeholder="Masukkan Nama Kegiatan" />
                  </div>

                  <div class="mb-3">
                    <label class="mb-1" for="inputPembimbing">Pembimbing</label><br>
                    <select id="pembimbing" name="id_pembimbing" required />
                    <?php
                    while ($row = $result->fetch_assoc()) {
                      echo "<option value=\"{$row['id_dosen']}\">{$row['nama_dosen']}</option>";
                    }
                    ?>
                    </select>
                  </div>

                  <div class="mb-3">
                    <label class="mb-1" for="inputDateRange">Waktu Kegiatan (tgl s/d tgl)</label>
                    <div class="input-group">
                      <input class="form-control" id="inputTanggalAwal" type="date" name="tanggal_pelaksanaan_awal" placeholder="Masukkan Tanggal Mulai" required />
                      <span class="input-group-text">s/d</span>
                      <input class="form-control" id="inputTanggalAkhir" type="date" name="tanggal_pelaksanaan_akhir" placeholder="Masukkan Tanggal Selesai" required />
                    </div>
                  </div>

                  <div class="mb-3">
                    <label class="mb-1" for="inputPenyelenggara">Penyelenggara</label>
                    <input class="form-control" id="inputPenyelenggara" type="text" name="lembaga_penyelenggara" placeholder="Masukkan Penyelenggara Lomba" required />
                  </div>

                  <div class="mb-3">
                    <label class="mb-1" for="inputTempatKegiatan">Tempat Kegiatan</label>
                    <input class="form-control" id="inputTempatKegiatan" type="text" name="lokasi" placeholder="Masukkan Tempat Kegiatan" required />
                  </div>

                  <div class="mb-3">
                    <label class="mb-1" for="inputJenisKepesertaan">Jenis Kepesertaan</label>
                    <div class="d-flex">
                      <select class="form-select" id="inputJenisKepesertaan" name="jenis_kepesertaan" onchange="showMembersInput()" required>
                        <option value="" selected disabled>Pilih</option>
                        <option value="1">Individu</option>
                        <option value="2">Kelompok</option>
                      </select>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label class="mb-1" for="inputLinkInformasi">URL Informasi Lomba</label>
                    <input class="form-control" id="inputLinkInformasi" type="text" name="url_prestasi" placeholder="Masukkan url informasi lomba" />
                  </div>

                  <div class="mb-3">
                    <label class="mb-1" for="inputDokumentasi">Dokumen Prestasi (Photo / PDF)</label><br>
                    <label for="fileInput" class="btn text-white" style="background-color: #003366"> Upload data Prestasi </label>
                    <input class="form-control" id="fileInput" name="fileInput" style="display: none" type="file" accept="image/jpeg, image/png, aplication/pdf" />
                  </div>

                  <div class="mb-3">
                    <label class="mb-1" for="inputDeskripsiKegiatan">Deskripsi Kegiatan</label>
                    <input class="form-control" id="inputDeskripsiKegiatan" name="deskripsi" placeholder="Deskripsi Kegiatan secara singkat">
                  </div>

                  <!-- Save changes button-->
                  <div class="mb-3">
                    <button class="btn btn-secondary" type="button" onclick="clearForm()">
                      Clear Form
                    </button>
                    <button class="btn text-white" type="submit" name="kirim" style="background-color: #003366">
                      Kirim
                    </button>
                  </div>
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
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="../js/pengajuan-dropdown.js"></script>