<head>

  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet" />

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="css/style.css" />
</head>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #0C356A">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="dist/img/logo-prestasi.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">PRESMA</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

     <!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="<?php echo ($_SESSION['id_role'] == '1') ? 'admin.php' : ($_SESSION['id_role'] == '0' ? 'superadmin.php' : ''); ?>" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>
                    Profil
                </p>
            </a>
        </li>

      <?php
          if (isset($_SESSION['id_role'])) {
              if ($_SESSION['id_role'] == "1" || $_SESSION['id_role'] == "0") {
          ?>
          <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-database"></i>
                  <p>
                      Data Master
                      <i class="fas fa-angle-left right"></i>
                  </p>
              </a>
              <ul class="nav nav-treeview">
                 <li class="nav-item">
                <a href="user.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data User</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="mahasiswa.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Mahasiswa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="prodi.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Prodi</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="departemen.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Departemen</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="dosen.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Dosen</p>
                </a>
              </li>

              </ul>
          </li>
          <?php
              }
          }
          ?>


        <li class="nav-item">
            <a href="presma.php" class="nav-link">
                <i class="nav-icon fas fa-file-alt"></i>
                <p>
                    Prestasi
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="berita.php" class="nav-link">
                <i class="nav-icon fas fa-images"></i></i>
                <p>
                    Galeri Prestasi
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="lomba.php" class="nav-link">
                <i class="nav-icon fas fa-layer-group"></i>
                <p>
                    Informasi Lomba
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="signout.php" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>
                    Sign Out
                </p>
            </a>
        </li>
    </ul>
</nav>
<!-- /.sidebar-menu -->

    </div>
    <!-- /.sidebar -->
  </aside>