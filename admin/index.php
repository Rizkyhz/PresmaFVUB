<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>PRESMA</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <!-- Favicon -->
    <link href="../img/favicon.ico" rel="icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap"
      rel="stylesheet"
    />

    <!-- Icon Font Stylesheet -->
    <link
      href="../https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
      rel="stylesheet"
    />
    <link
      href="../https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
      rel="stylesheet"
    />

    <!-- Libraries Stylesheet -->
    <link href="../lib/animate/animate.min.css" rel="stylesheet" />
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet" />

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet" />
  </head>

  <style>
    html,
    body {
      height: 100%;
      background: url(../img/bg-login22-01.png) no-repeat;
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
      width: 380px;
      height: 450px;
      padding: 20px;
      background-color: transparent;
      backdrop-filter: blur(40px);
      border-radius: 10px !important;
      box-shadow: 0px 0px 5px 0px #000000;
    }

    input[type="email"],
    input[type="password"] {
      background: #fff;
      color: black;
      border: 2px solid #003366;
      border-radius: 10px;
      margin-bottom: 25px;
    }

    input[type="email"]:focus,
    input[type="password"]:focus {
      outline: none;
      border: none;
      background: #fff;
      color: black;
      margin: 0;
    }

    .card-title {
      padding-top: 20px;
    }

    .btn {
      background: #003366 !important;
      color: #fff !important;
      transform: translateY(10px);
      font-size: 14px;
      border-radius: 10px !important;
    }
  </style>
  <body>
    <div class="global-container">
      <div class="card login-form">
        <div class="card-body">
          <?php if(!empty($_GET['gagal'])){?>
      <?php if($_GET['gagal']=="userKosong"){?>
          <span class="text-danger">
           Maaf Username Tidak Boleh Kosong
          </span>
        <?php } else if($_GET['gagal']=="passKosong"){?>
          <span class="text-danger">
          Maaf Password Tidak Boleh Kosong
         </span>
        <?php } else {?>
          <span class="text-danger">
          Maaf Username dan Password Anda Salah
        </span>
        <?php }?>
      <?php }?>
          <h1 class="card-title text-center" style="color: #003366">|LOGIN ADMIN|</h1>
        </div>
        <div class="card-text">
          <form action="konfirmasilogin.php" method="post">
            <div class="mb-2" style="margin-top: -20px">
              <label for="username" class="form-label">Username</label
              >
              <input type="text" class="form-control" id="username" name="username" value=""/>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" value=""/>
            </div>
            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="exampleCheck1"/>
              <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <div class="text-center" style="font-size: 12px">
              <a href="">Lupa Password?</a>
            </div>
            <div class="d-grid gap-2">
              <button name="login"type="submit" class="btn btn-primary">Submit</button>
            </div>
            <div class="text-center" style="font-size: 12px; margin-top: 20px">
              <p style="color: gray">
                Belum punya akun?<a href="register.php">Registrasi</a>
              </p>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- JavaScript Libraries -->
    <script src="../https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="../https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/wow/wow.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
  </body>
</html>
