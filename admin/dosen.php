<?php
session_start();
include('koneksi/koneksi.php');

$id = $_SESSION['id_user'];

// Pagination settings
$limit = 10; // Number of records to display per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1; // Current page number
$offset = ($page - 1) * $limit; // Offset for the SQL query

// Fetch dosen data from the database based on the search query and pagination
$sql_dosen = "SELECT dosen. *, prodi.nama_prodi, departemen.nama_departemen
              FROM dosen
              LEFT JOIN prodi ON dosen.id_prodi_dosen = prodi.id_prodi
              LEFT JOIN departemen ON prodi.id_departemen_prodi = departemen.id_departemen";

// Apply search if a keyword is provided
if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
    $keyword = mysqli_real_escape_string($koneksi, $_GET['keyword']);
    $sql_dosen .= " WHERE dosen.nama_dosen LIKE '%$keyword%' OR departemen.nama_departemen LIKE '%$keyword%'";
}

// Count total records for pagination
$count_query = mysqli_query($koneksi, $sql_dosen);
$total_records = mysqli_num_rows($count_query);

// Modify the SQL query for pagination
$sql_dosen .= " LIMIT $offset, $limit";

$query_dosen = mysqli_query($koneksi, $sql_dosen);

// Check if the query was successful
if (!$query_dosen) {
    // Handle the case where the query was not successful
    echo "Error: " . mysqli_error($koneksi);
}

// Calculate the total number of pages
$total_pages = ceil($total_records / $limit);
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
                            <h3><i class="fas fa-user-tie"></i> Data Dosen</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active"></li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Add your content here -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-tools">
                            <?php
                            // Hanya tampilkan tautan Tambah User jika peran pengguna bukan admin
                            if ($_SESSION['id_role'] != '1') {
                            ?>
                                <a href="tambahdosen.php" class="btn btn-sm btn-success float-right" style="font-size:16px; font-weight: 600;">
                                    <i class="fas fa-plus"></i> Tambah Dosen</a>
                            <?php
                            }
                            ?>

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="mb-3">
                            <form action="" method="GET">
                                <div class="input-group">
                                    <input type="text" name="keyword" class="form-control" placeholder="Search by Name or Departemen">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">Nama Dosen</th>
                                    <th width="20%">Jabatan Dosen</th>
                                    <th width="20%">Departemen</th>
                                    <th width="20%">Program Studi</th>
                                    <th width="20%">
                                        <center>Aksi</center>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $no = 1;
                                while ($data_dosen = mysqli_fetch_assoc($query_dosen)) {
                                ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $data_dosen['nama_dosen']; ?></td>
                                        <td><?php echo $data_dosen['jabatan_dosen']; ?></td>
                                        <td><?php echo $data_dosen['nama_departemen']; ?></td>
                                        <td><?php echo $data_dosen['nama_prodi']; ?></td>
                                        <td align="center">
                                            <a href="detaildosen.php?id_dosen=<?php echo $data_dosen['id_dosen']; ?>" class="btn btn-xs btn-info" title="Detail"><i class="fas fa-eye"></i></a>
                                            <?php
                                            // Hanya tampilkan tautan Edit dan Delete jika peran pengguna bukan admin
                                            if ($_SESSION['id_role'] != '1') {
                                            ?>
                                                <a href="editdosen.php?id_dosen=<?php echo $data_dosen['id_dosen']; ?>" class="btn btn-xs btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                                <a href="hapusdosen.php?id_dosen=<?php echo $data_dosen['id_dosen']; ?>" class="btn btn-xs btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus dosen ini?');">
                                                    <i class="fas fa-trash" title="Hapus"></i>
                                                </a>
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
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                                <li class="page-item"><a class="page-link" href="dosen.php?page=<?= max($page - 1, 1); ?>">&laquo;</a></li>

                                <?php
                                for ($i = 1; $i <= $total_pages; $i++) {
                                    echo "<li class='page-item " . ($page == $i ? 'active' : '') . "'><a class='page-link' href='dosen.php?page=$i'>$i</a></li>";
                                }
                                ?>
                                <li class="page-item"><a class="page-link" href="dosen.php?page=<?= min($page + 1, $total_pages); ?>">&raquo;</a></li>
                            </ul>
                            <span class="float-right" style="margin-top: 5px; margin-right: 10px;">Halaman <?= $page; ?> dari <?= $total_pages; ?></span>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <!-- Add your footer content here -->
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