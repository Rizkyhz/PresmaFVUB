<?php

include('admin/koneksi/koneksi.php');

$sql = "SELECT mahasiswa.nama_mahasiswa, prodi.nama_prodi, prestasimahasiswa.capaian, prestasimahasiswa.nama_prestasi, tingkatkejuaraan.tingkatan, YEAR(prestasimahasiswa.tanggal_pelaksanaan_akhir) AS tahun_pelaksanaan 
FROM prestasimahasiswa 
JOIN mahasiswa ON prestasimahasiswa.id_mahasiswa = mahasiswa.id_mahasiswa 
JOIN prodi ON mahasiswa.id_prodi_mahasiswa = prodi.id_prodi 
JOIN tingkatkejuaraan ON prestasimahasiswa.id_tingkat_kejuaraan = tingkatkejuaraan.id_tingjur 
WHERE id_status = 1;";

$query = mysqli_query($koneksi, $sql);

if (!$query) {
  die("Error: " . mysqli_error($koneksi));
}

$detailmahasiswa = mysqli_fetch_all($query, MYSQLI_ASSOC);

mysqli_close($koneksi);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title> PRESMA Vokasi - Data Prestasi Mahasiswa</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta content="" name="keywords" />
  <meta content="" name="description" />

  <!-- Favicon -->
  <link href="img/favicon.ico" rel="icon" />

  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet" />

  <!-- Icon Font Stylesheet -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />

  <!-- Libraries Stylesheet -->
  <link href="lib/animate/animate.min.css" rel="stylesheet" />
  <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />

  <!-- Customized Bootstrap Stylesheet -->
  <link href="css/bootstrap.min.css" rel="stylesheet" />

  <script src="js/apexcharts.js"></script>

  <!-- Template Stylesheet -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- jQuery (diperlukan oleh DataTables) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


  <!-- DataTables CSS dan JS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

</head>

<body>
  <!-- Spinner Start -->
  <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
  <!-- Spinner End -->

  <!-- Navbar Start -->
  <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
      <img src="img/logo-vokasi.png" alt="" style="width: 60px;">
      <img src="img/logo-prestasi.png" alt="" width="40px">
      <div class="ms-2">
        <h2 class="m-0 text-dark">PRESMA Vokasi</h2>
      </div>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <div class="navbar-nav ms-auto p-4 p-lg-0">
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="index.php" class="nav-item nav-link active">Home</a>
            <div class="nav-item dropdown">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Prestasi</a>
              <div class="dropdown-menu fade-down m-0">
                <a href="galeri-prestasi.php" class="dropdown-item">Galeri Prestasi</a>
                <a href="grafik-prestasi.php" class="dropdown-item">Grafik Data Prestasi</a>
              </div>
            </div>
            <div class="nav-item dropdown">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Lainnya</a>
              <div class="dropdown-menu fade-down m-0">
                <a href="info-lomba.php" class="dropdown-item">Informasi Lomba</a>
              </div>
            </div>
          </div>
          <a href="bantuan.php" class="nav-item nav-link">Bantuan</a>
        </div>
        <a href="login.php" class="btn py-4 px-lg-5 d-none d-lg-block" style="background-color: #003366; color: #FF9900;">Login<i class="fa fa-arrow-right ms-3" style="color: #FF9900;"></i></a>
      </div>
  </nav>
  <!-- Navbar End -->

  <!-- Team Start -->
  <div class="container-xxl py-5">
    <div class="container">
      <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
        <h6 class="section-title bg-white text-center text-primary px-3">
          DATA
        </h6>
        <h1 class="mb-5">Prestasi Mahasiswa</h1>
      </div>
      <!-- isi tabel -->
      <div class="row g-10">
        <div class="table-responsive">
          <input style="width: 300px; margin-bottom: 10px;" type="text" id="searchInput" placeholder="Cari data...">
          <table id="datatables" class="table table-hover table-striped">
            <thead style="background-color: #003366; color: #fff">
              <tr style='text-align: center;'>
                <th align='center' valign='middle'>No</th>
                <th align='center' valign='middle'>Nama</th>
                <th align='center' valign='middle'>Program Studi</th>
                <th align='center' valign='middle'>Capaian</th>
                <th align='center' valign='middle'>Nama Prestasi</th>
                <th align='center' valign='middle'>Tingkat</th>
                <th align='center' valign='middle'>Tahun</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach ($detailmahasiswa as $row) {
                echo "<tr style='text-align: center;'>";
                echo "<th>" . $no++ . "</th>";
                echo "<th>" . $row['nama_mahasiswa'] . "</th>";
                echo "<th>" . $row['nama_prodi'] . "</th>";
                echo "<th>" . $row['capaian'] . "</th>";
                echo "<th>" . $row['nama_prestasi'] . "</th>";
                echo "<th>" . $row['tingkatan'] . "</th>";
                echo "<th>" . $row['tahun_pelaksanaan'] . "</th>";
                echo "</tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
        <!-- isi tabel end-->
      </div>
    </div>
  </div>
  <!-- Team End -->

  <!-- Footer Start -->
  <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
      <div class="row g-5">
        <div class="col-lg-3 col-md-6"></div>
        <div class="col-lg-3 col-md-6">
          <img src="img/logo-vokasi.png" alt="" />
        </div>
        <div class="col-lg-6 col-md-10">
          <h4 class="mb-3" style="color: #ff9900">Contact Us :</h4>
          <p class="mb-2">
            <i class="fa fa-building me-3"></i>Gedung Akademik lt 1, Fakultas
            Vokasi
          </p>
          <p class="mb-2">
            <i class="fa fa-map-marker-alt me-3"></i>Jl. Veteran No 12 – 14,
            Ketawanggede, Malang
          </p>
          <p class="mb-2">
            <i class="fa fa-phone-alt me-3"></i>Phone: 0341-551-611
          </p>
          <p class="mb-2">
            <i class="fa fa-envelope me-3"></i>Email: vokasi@ub.ac.id
          </p>
          <div class="d-flex pt-2">
            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="copyright">
        <div class="row">
          <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
            &copy;
            <a class="border-bottom" href="#">2023,Universitas Brawijaya</a>.
            All Rights Reserved.
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer End -->

  <!-- Back to Top -->
  <a href="#" class="btn btn-lg btn-lg-square back-to-top" style="background-color: #FF9900;"><i class="bi bi-arrow-up"></i></a>


  <!-- JavaScript Libraries -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="lib/wow/wow.min.js"></script>
  <script src="lib/easing/easing.min.js"></script>
  <script src="lib/waypoints/waypoints.min.js"></script>
  <script src="lib/owlcarousel/owl.carousel.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>


  <script>
    $(document).ready(function() {
      $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("table tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
  </script>


  <script>
    $(document).ready(function() {
      // Initialize DataTable
      var table = $('#datatables').DataTable({
        "pageLength": 20, // Menampilkan 20 entri per halaman
        "ordering": false // Menonaktifkan sorting di semua kolom
      });
      $(document).ready(function() {
        var table = $('#datatables').DataTable();

        table.on('init', function() {
          table.column(2).orderable(false); // Menonaktifkan sorting pada kolom indeks ke-2 (kolom tahun)
        });



        // Initialize starting page and page length
        var start = 0;
        var length = 20;

        // Handle click event for Next Page button
        $('#nextPageButton').on('click', function() {
          start += length; // Increment start to move to the next page
          table.page.jumpToData(start, 0); // Jump to the next page
        });

        $(document).ready(function() {
          $('#datatables_filter').hide();
        });
      });
    });
  </script>
  <!-- Template Javascript -->
  <script src="js/main.js"></script>
  <!-- Template Javascript -->
  <script src="js/main.js"></script>
</body>

</html>