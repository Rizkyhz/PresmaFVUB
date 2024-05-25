<?php
include('admin/koneksi/koneksi.php');
$sql_departemen = "SELECT * FROM departemen";
$query_departemen = mysqli_query($koneksi, $sql_departemen);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title> PRESMA Vokasi - Registrasi</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta content="" name="keywords" />
  <meta content="" name="description" />

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

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

  <!-- Template Stylesheet -->
  <link href="css/style.css" rel="stylesheet" />
</head>

<style>
  html,
  body {
    height: 100%;
    margin: 0;
    padding: 0;
    background: url(img/bg-login22-01.png) no-repeat;
    background-size: cover;
  }

  .global-container {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #003366;
  }

  .login-form {
    width: 500px;
    padding: 15px 20px;
    /* Adjusted padding for top and bottom */
    background-color: transparent;
    backdrop-filter: blur(40px);
    border-radius: 10px !important;
    box-shadow: 0px 0px 5px 0px #000000;
    /* Add a subtle shadow for depth */
  }

  .form-label {
    color: #003366;
  }

  .form-control {
    background: #fff;
    color: black;
    border: 2px solid #003366;
    border-radius: 10px;
    margin-bottom: 20px;
  }

  .form-control:focus {
    outline: none;
    border: 2px solid #003366;
    background: #fff;
    color: black;
  }

  .card-title {
    padding-top: 20px;
    margin-bottom: 20px;
    /* Add margin below the title */
  }

  .btn {
    background: #003366 !important;
    color: #fff !important;
    transform: translateY(10px);
    font-size: 14px;
    border-radius: 10px !important;
  }

  .mb-3 {
    margin-bottom: 15px;
    /* Adjusted margin for better separation between form groups */
  }

  @media (max-width: 767px) {

    html,
    body {
      background: url(img/bg-login22-01.png) no-repeat;
      background-size: auto;
    }

    .login-form {
      width: 100%;
    }
  }
</style>

<body>
  <div class="global-container">
    <div class="card login-form">
      <div class="card-body">
        <center>
          <?php if (isset($_GET['failed'])) { ?>
            <?php if ($_GET['failed'] == "existingEmail") { ?>
              <span class="text-danger"> Maaf, Email anda sudah terdaftar.</span>
            <?php } else if ($_GET['failed'] == "passnotcorrect") { ?>
              <span class="text-danger">Maaf, Password anda tidak cocok.</span>
            <?php } ?>
          <?php } ?>
        </center>
        <h1 class="card-title text-center" style="color: #003366">REGISTRASI</h1>
      </div>
      <div class="card-text">
        <form action="mahasiswa/controller/konfirmasiregister.php" method="post">
          <div class="mb-3">
            <label for="inputNama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="inputNama" name="nama_mahasiswa" aria-describedby="nameHelp" required />
            <div id="nameHelp" class="form-text"></div>
          </div>
          <div class="mb-3">
            <label for="InputNIM" class="form-label">NIM</label>
            <input type="text" class="form-control" id="inputNIM" name="nim_mahasiswa" aria-describedby="nameHelp" required />
            <div id="nameHelp" class="form-text"></div>
          </div>

          <div class="form-group">
            <label>Departemen</label>
            <select class="form-control" id="inputDepartemen" name="inputDepartemen" required>
              <option value="">Pilih Departemen</option>
              <?php
              while ($data_departemen = mysqli_fetch_assoc($query_departemen)) {
                echo '<option value="' . $data_departemen['id_departemen'] . '">' . $data_departemen['nama_departemen'] . '</option>';
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label>Program Studi</label>
            <select class="form-control" id="id_prodi_mahasiswa" name="id_prodi_mahasiswa" required>
              <option value="">Pilih Program Studi</option>
              <!-- Opsi Program Studi akan Diisi Melalui JavaScript -->
            </select>
          </div>

          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" name="email_mahasiswa" aria-describedby="emailHelp" required />
            <div id="emailHelp" class="form-text"></div>
          </div>

          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="exampleInputPassword1" required />
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" name="passwordconfirm" id="exampleInputPassword1" required />
          </div>
          <div class="d-grid gap-2 mb-4">
            <div class="btn-group">
              <button type="submit" name="kirim" class="btn btn-primary">Register</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- JavaScript Libraries -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="lib/wow/wow.min.js"></script>
  <script src="lib/easing/easing.min.js"></script>
  <script src="lib/waypoints/waypoints.min.js"></script>
  <script src="lib/owlcarousel/owl.carousel.min.js"></script>
  <script src="js/main.js"></script>
  <script>
    document
      .getElementById("inputDepartemen")
      .addEventListener("change", function() {
        var departemenId = this.value;
        var prodiDropdown = document.getElementById("id_prodi_mahasiswa");
        prodiDropdown.innerHTML = "";

        $.ajax({
          url: "mahasiswa/controller/get_prodi.php",
          method: "POST",
          data: {
            id_departemen: departemenId,
          },
          dataType: "json",
          success: function(response) {
            response.forEach(function(prodi) {
              var option = document.createElement("option");
              option.value = prodi.id_prodi;
              option.text = prodi.nama_prodi;
              prodiDropdown.appendChild(option);
            });
          },
          error: function() {
            console.error("Error while fetching program studi data.");
          },
        });
      });
  </script>

</body>

</html>