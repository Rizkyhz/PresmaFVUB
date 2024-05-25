<?php
session_start();
include('koneksi/koneksi.php');

$items_per_page = 10; // Jumlah item per halaman
$katakunci = ''; // Inisialisasi variabel $katakunci
// Hitung offset berdasarkan halaman yang diminta
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $katakunci = $_POST['katakunci'];
    $sql = "SELECT `id_user`, `username`, `email`, `nama_role` FROM `user` INNER JOIN user_role ON user.id_role = user_role.id_role WHERE username LIKE '%$katakunci%' OR email LIKE '%$katakunci%' OR nama_role LIKE '%$katakunci%' LIMIT $offset, $items_per_page";
} else {
    // Default query without search
    $sql = "SELECT `id_user`, `username`, `email`, `nama_role` FROM `user` INNER JOIN user_role ON user.id_role = user_role.id_role LIMIT $offset, $items_per_page";
}

$query = mysqli_query($koneksi, $sql);

// Query untuk menghitung total item
$count_query = "SELECT COUNT(*) as total FROM `user` INNER JOIN user_role ON user.id_role = user_role.id_role WHERE username LIKE '%$katakunci%' OR email LIKE '%$katakunci%' OR nama_role LIKE '%$katakunci%'";
$count_result = mysqli_query($koneksi, $count_query);
$count_data = mysqli_fetch_assoc($count_result);

$total_items = $count_data['total'];

// Hitung total halaman
$total_pages = ceil($total_items / $items_per_page);

?>

<!DOCTYPE html>
<html lang="en">

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
                            <h3><i class="fas fa-user-tie"></i> Data User</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active"> Data User</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <?php
                            // Hanya tampilkan tautan Tambah User jika peran pengguna bukan admin
                            if ($_SESSION['id_role'] != '1') {
                            ?>
                                <a href="tambahuser.php" class="btn btn-sm btn-success float-right" style=" font-size:18px; font-style:bold">
                                    <i class="fas fa-plus"></i>  Tambah User</a>
                            <?php
                            }
                            ?>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="col-md-12">
                            <form method="post" action="">
                                <div class="row">
                                    <div class="col-md-4 bottom-10">
                                        <input type="text" class="form-control" id="katakunci" name="katakunci">
                                    </div>
                                    <div class="col-md-5 bottom-10">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i>&nbsp; Search</button>
                                    </div>
                                </div><!-- .row -->
                            </form>
                        </div><br>
                        <div class="col-sm-12">
                            <?php if (!empty($_GET['notif'])) { ?>
                                <?php if ($_GET['notif'] == "tambahberhasil") { ?>
                                    <div class="alert alert-success" role="alert">
                                        Data Berhasil Ditambahkan</div>
                                <?php } else if ($_GET['notif'] == "editberhasil") { ?>
                                    <div class="alert alert-success" role="alert">
                                        Data Berhasil Diubah</div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="30%">Username</th>
                                    <th width="30%">Email</th>
                                    <th width="20%">Status</th>
                                    <th width="15%"><center>Aksi</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1; // Initialize the counter
                                while ($data_b = mysqli_fetch_assoc($query)) {
                                    $username = $data_b['username'];
                                    $email = $data_b['email'];
                                    $role = $data_b['nama_role'];
                                    $id_user = $data_b['id_user'];
                                ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $username; ?></td>
                                        <td><?php echo $email; ?></td>
                                        <td><?php echo $role; ?></td>
                                        <td align="center">
                                            <a href="detailuser.php?id_user=<?php echo $data_b['id_user']; ?>" class="btn btn-xs btn-info" title="Detail"><i class="fas fa-eye"></i></a>
                                            <?php
                                                // Hanya tampilkan tautan Edit dan Delete jika peran pengguna bukan admin
                                                if ($_SESSION['id_role'] != '1') {
                                                ?>
                                                    <a href="edituser.php?id_user=<?php echo $id_user; ?>" class="btn btn-xs btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                                    <a href="deleteuser.php?id_user=<?php echo $id_user; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');" class="btn btn-xs btn-danger"><i class="fas fa-trash" title="Hapus"></i></a>
                                                <?php
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
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                            <li class="page-item"><a class="page-link" href="user.php?page=<?= max($page - 1, 1); ?>">&laquo;</a></li>

                            <?php
                            for ($i = 1; $i <= $total_pages; $i++) {
                                echo "<li class='page-item " . ($page == $i ? 'active' : '') . "'><a class='page-link' href='user.php?page=$i'>$i</a></li>";
                            }
                            ?>
                            <li class="page-item"><a class="page-link" href="user.php?page=<?= min($page + 1, $total_pages); ?>">&raquo;</a></li>
                        </ul>
                        <span class="float-right" style="margin-top: 5px; margin-right: 10px;">Halaman <?= $page; ?> dari <?= $total_pages; ?></span>
                    </div>
                </div>
                <!-- /.card -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include("includes/footer.php") ?>
    </div>
    <!-- ./wrapper -->
    <?php include("includes/script.php") ?>
</body>

</html>
