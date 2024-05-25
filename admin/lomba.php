<?php
session_start();
include('koneksi/koneksi.php');
// $id_user = $_SESSION['id_user'];
$sql_infolomba = "SELECT * FROM info_lomba";
$query_infolomba = mysqli_query($koneksi, $sql_infolomba);
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
                        <h3><i class="fas fa-trophy"></i> Informasi Lomba</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active"> Informasi Lomba</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                          <?php
                        // Cek peran pengguna, jika bukan superadmin, tampilkan tombol "Tambah Informasi Lomba"
                        if ($_SESSION['id_role'] != '0') {
                            echo '<a href="tambahinfolomba.php" class="btn btn-sm btn-success float-right" style="font-size:16px; font-weight: 600;">';
                            echo '<i class="fas fa-plus"></i> Tambah Informasi Lomba</a>';
                        }
                        ?>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="30%">ID Lomba</th>
                            <th width="30%">Foto</th>
                            <th width="20%">Keterangan</th>
                            <th width="30%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = 1;
                        while ($data_infolomba = mysqli_fetch_assoc($query_infolomba)) {
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $data_infolomba['id_lomba']; ?></td>
                                <td><?php echo $data_infolomba['foto']; ?></td>
                                <td><?php echo $data_infolomba['keterangan']; ?></td>
                                <td align="center">
                                <a href='detailinfolomba.php?id_lomba=<?php echo $data_infolomba['id_lomba']; ?>' class='btn btn-info btn-sm' style='font-size:12px;'><i class='fas fa-eye'></i> </a>

                                     <?php
                                        if ($_SESSION['id_role'] != '0') {
                                echo "<a href='editinfolomba.php?id_lomba={$data_infolomba['id_lomba']}' class='btn btn-warning btn-sm' style='font-size:12px;'><i class='fas fa-edit'></i> </a>";
                                echo "<button class='btn btn-danger btn-sm' style='font-size:12px;' onclick='confirmDelete({$data_infolomba['id_lomba']})'><i class='fas fa-trash'></i> </button>";
                                } else {
                                     // Jika superadmin, tampilkan pesan atau tindakan lain sesuai kebutuhan
                                                    }
                                                ?>
                            </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    <?php include("includes/footer.php") ?>
</div>
<?php include("includes/script.php") ?>
<script>
    function confirmDelete(id) {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            window.location.href = 'deletelomba.php?id=' + id;
        }
    }
</script></body>
</html>
