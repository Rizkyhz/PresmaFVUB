<?php
session_start();

include('koneksi/koneksi.php');

// Handle the search query
$keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($koneksi, $_GET['keyword']) : '';

// Pagination settings
$limit = 10; // Number of records to display per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1; // Current page number
$offset = ($page - 1) * $limit; // Offset for the SQL query

// Fetch mahasiswa data from the database based on the search query and pagination  
$sql = "SELECT `id_mahasiswa`, `nama_mahasiswa`, `nama_prodi`, `nim_mahasiswa`, `email_mahasiswa`, `password`
        FROM `mahasiswa` INNER JOIN `prodi` ON mahasiswa.id_prodi_mahasiswa = prodi.id_prodi";

// Apply search if a keyword is provided
if (!empty($keyword)) {
    $sql .= " WHERE `nama_mahasiswa` LIKE '%$keyword%' OR `nim_mahasiswa` LIKE '%$keyword%'";
}

// Count total records for pagination
$count_query = mysqli_query($koneksi, $sql);
$total_records = mysqli_num_rows($count_query);

// Modify the SQL query for pagination
$sql .= " LIMIT $offset, $limit";

$query = mysqli_query($koneksi, $sql);

// Check if the query was successful
if ($query) {
    // Fetch the data as an associative array
    $mahasiswa_data = mysqli_fetch_all($query, MYSQLI_ASSOC);
} else {
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
                            <h3><i class="fas fa-user-graduate"></i> Data Mahasiswa</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active">Data Mahasiswa</li>
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
                            // Hanya tampilkan tautan Tambah User jika peran pengguna bukan admin
                            if ($_SESSION['id_role'] != '1') {
                            ?>
                                <a href="tambahmahasiswa.php" class="btn btn-sm btn-success float-right" style="font-size:medium;">
                                    <i class="fas fa-plus"></i> Tambah Mahasiswa</a>
                            <?php
                            }
                            ?>

                        </div>
                    </div>
                    <!-- Add this code above the table in your HTML -->
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="mb-3">
                            <form action="" method="GET">
                                <div class="input-group">
                                    <input type="text" name="keyword" class="form-control" placeholder="Search by Name or NIM">
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
                                    <th width="20%">NIM</th>
                                    <th width="30%">Nama Mahasiswa</th>
                                    <th width="20%">Program Studi</th>
                                    <th width="15%">Email</th>
                                    <th width="10%">
                                        <center>Aksi</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($mahasiswa_data)) {
                                    $no = 1;
                                    foreach ($mahasiswa_data as $mahasiswa) {
                                ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $mahasiswa['nim_mahasiswa']; ?></td>
                                            <td><?php echo $mahasiswa['nama_mahasiswa']; ?></td>
                                            <td><?php echo $mahasiswa['nama_prodi']; ?></td>
                                            <td><?php echo $mahasiswa['email_mahasiswa']; ?></td>
                                            <td align="center">
                                                <!-- Tambahkan tombol atau tautan aksi di sini sesuai kebutuhan -->
                                                <a href="detailmahasiswa.php?id_mahasiswa=<?php echo $mahasiswa['id_mahasiswa']; ?>" class="btn btn-xs btn-info" title="Detail"><i class="fas fa-eye"></i></a>
                                                <?php
                                                // Hanya tampilkan tautan Edit dan Delete jika peran pengguna bukan admin
                                                if ($_SESSION['id_role'] != '1') {
                                                ?>
                                                    <a href="editmahasiswa.php?id_mahasiswa=<?php echo $mahasiswa['id_mahasiswa']; ?>" class="btn btn-xs btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                                    <a href="deletemahasiswa.php?id_mahasiswa=<?php echo $mahasiswa['id_mahasiswa']; ?>" class="btn btn-xs btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini?');"><i class="fas fa-trash" title="Hapus"></i></a>
                                                <?php
                                                }
                                                ?>

                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="6">Tidak ada data mahasiswa.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                        <!-- Add this code below the table in your HTML -->
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                                <li class="page-item"><a class="page-link" href="mahasiswa.php?page=<?= max($page - 1, 1); ?>">&laquo;</a></li>

                                <?php
                                for ($i = 1; $i <= $total_pages; $i++) {
                                    echo "<li class='page-item " . ($page == $i ? 'active' : '') . "'><a class='page-link' href='mahasiswa.php?page=$i'>$i</a></li>";
                                }
                                ?>
                                <li class="page-item"><a class="page-link" href="mahasiswa.php?page=<?= min($page + 1, $total_pages); ?>">&raquo;</a></li>
                            </ul>
                            <span class="float-right" style="margin-top: 5px; margin-right: 10px;">Halaman <?= $page; ?> dari <?= $total_pages; ?></span>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
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