<?php
session_start();
include('koneksi/koneksi.php');
$id = $_SESSION['id_user'];

$sql_prestasi = "SELECT `id_prestasi`,`nama_mahasiswa`, `nama_prestasi`, `tanggal_pelaksanaan`, `jenis_kepesertaan`, `capaian`, `no_surattugas`, `status` FROM prestasimahasiswa
INNER JOIN mahasiswa ON prestasimahasiswa.id_mahasiswa= mahasiswa.id_mahasiswa
INNER JOIN jeniskejuaraan ON prestasimahasiswa.id_jenis_kejuaraan=jeniskejuaraan.id_jeniskej
INNER JOIN status ON prestasimahasiswa.id_status=status.id_status";
$query_prestasi = mysqli_query($koneksi, $sql_prestasi);

if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
    $keyword = mysqli_real_escape_string($koneksi, $_GET['keyword']);
    $sql_prestasi = "SELECT `id_prestasi`,`nama_mahasiswa`, `nama_prestasi`, `tanggal_pelaksanaan`, `jenis_kepesertaan`, `capaian`, `no_surattugas`, `status` FROM prestasimahasiswa
                    INNER JOIN mahasiswa ON prestasimahasiswa.id_mahasiswa = mahasiswa.id_mahasiswa
                    INNER JOIN jeniskejuaraan ON prestasimahasiswa.id_jenis_kejuaraan = jeniskejuaraan.id_jeniskej
                    INNER JOIN status ON prestasimahasiswa.id_status = status.id_status
                    WHERE nama_mahasiswa LIKE '%$keyword%' OR tanggal_pelaksanaan LIKE '%$keyword%'";
} else {
    // If no search keyword, use the original query
    $sql_prestasi = "SELECT `id_prestasi`,`nama_mahasiswa`, `nama_prestasi`, `tanggal_pelaksanaan`, `jenis_kepesertaan`, `capaian`, `no_surattugas`, `status` FROM prestasimahasiswa
                    INNER JOIN mahasiswa ON prestasimahasiswa.id_mahasiswa = mahasiswa.id_mahasiswa
                    INNER JOIN jeniskejuaraan ON prestasimahasiswa.id_jenis_kejuaraan = jeniskejuaraan.id_jeniskej
                    INNER JOIN status ON prestasimahasiswa.id_status = status.id_status";
}

?>

<!DOCTYPE html>
<html>
<head>
    <?php include("includes/head.php") ?>
    <script>
        function changeStatus(id_prestasi, newStatus) {
           var confirmation = confirm('Apakah Anda yakin ingin mengubah status menjadi ' + newStatus + '?');
              if (confirmation) {
                 window.location.href = 'status.php?id_prestasi=' + id_prestasi + '&status=' + newStatus;
            }
        }
    </script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include("includes/header.php") ?>
        <?php include("includes/sidebar.php") ?>

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h3><i class="fas fa-trophy"></i> Data Prestasi</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active"> Data Prestasi</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <div class="card-tools">
                             <?php
                                if ($_SESSION['id_role'] != '0') {
                                    // Hanya pengguna selain superadmin yang bisa melihat dan menggunakan tombol ini
                                    echo '<a href="tambahpresma.php" class="btn btn-sm btn-success float-right" style="font-size: 16px; font-weight: 600;">';
                                    echo '<i class="fas fa-plus"></i> Tambah Prestasi</a>';
                                } else {
                                    // Jika superadmin, tampilkan pesan atau tindakan lain sesuai kebutuhan
                                    echo 'Anda tidak memiliki izin untuk menambah prestasi.';
                                }
                                ?>
                    </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="GET">
                                <div class="input-group">
                                    <input type="text" name="keyword" class="form-control" placeholder="Search by Name or Tanggal ">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
                                    </div>
                                </div>
                            </form>
                            <br>
                            <?php
                                // Pagination variables
                                $results_per_page = 10; // Number of results per page
                                $sql_prestasi_count = "SELECT COUNT(*) FROM prestasimahasiswa";
                                $query_prestasi_count = mysqli_query($koneksi, $sql_prestasi_count);
                                $row = mysqli_fetch_row($query_prestasi_count);
                                $total_results = $row[0];
                                $total_pages = ceil($total_results / $results_per_page);

                                // Check current page
                                if (!isset($_GET['page'])) {
                                    $page = 1;
                                } else {
                                    $page = $_GET['page'];
                                }

                                // Calculate the starting point for the results on the current page
                                $offset = ($page - 1) * $results_per_page;

                                // Modify the main SQL query to include LIMIT
                                $sql_prestasi .= " LIMIT $offset, $results_per_page";

                                // Execute the modified query
                                $query_prestasi = mysqli_query($koneksi, $sql_prestasi);
                                ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="20%">Nama Mahasiswa</th>
                                    <th width="20%">Nama Prestasi</th>
                                    <th width="10%">Tanggal Pelaksanaan</th>
                                    <th width="10%">Jenis Kepesertaan</th>
                                    <th width="10%">Capaian</th>
                                    <th width="10%">No Surat Tugas</th>
                                    <th width="10%">Status</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                while ($data_prestasi = mysqli_fetch_assoc($query_prestasi)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $data_prestasi['nama_mahasiswa']; ?></td>
                                        <td><?php echo $data_prestasi['nama_prestasi']; ?></td>
                                        <td><?php echo $data_prestasi['tanggal_pelaksanaan']; ?></td>
                                        <td><?php echo $data_prestasi['jenis_kepesertaan']; ?></td>
                                        <td><?php echo $data_prestasi['capaian']; ?></td>
                                        <td><?php echo $data_prestasi['no_surattugas']; ?></td>
                                        <td >
                                             <?php
                                                $statusClass = ''; // Initialize the CSS class for the button
                                                $clickable = true; // Assume the button is clickable by default

                                                // Set the CSS class based on the status
                                                switch ($data_prestasi['status']) {
                                                    case 'Dalam Antrean':
                                                        $statusClass = 'btn-info';
                                                        break;
                                                    case 'Diproses':
                                                        $statusClass = 'btn-warning';
                                                        break;
                                                    case 'Berhasil':
                                                        $statusClass = 'btn-success';
                                                        $clickable = false; // Disable the button if status is 'Berhasil'
                                                        break;
                                                    case 'Gagal':
                                                        $statusClass = 'btn-danger';
                                                        $clickable = false; // Disable the button if status is 'Gagal'
                                                        break;
                                                    default:
                                                        $statusClass = 'btn-secondary';
                                                        break;
                                                }

                                                // Output the button with the appropriate class and clickable attribute
                                               echo '<a href="#" class="btn btn-xs ' . $statusClass . '"';

                                                    // Add the 'disabled' attribute if the button is not clickable
                                                    if (!$clickable) {
                                                        echo ' disabled';
                                                    } else {
                                                        echo ' onclick="changeStatus(' . $data_prestasi['id_prestasi'] . ', \'' . $data_prestasi['status'] . '\');"';
                                                    }

                                                    echo '>';
                                                    echo $data_prestasi['status'];
                                                    echo '</a>';
                                                ?>
                                        </td>


                                        <td align="center">
                                            <a href="detailpresma.php?id_prestasi=<?php echo $data_prestasi['id_prestasi']; ?>" class="btn btn-xs btn-info" title="Detail"><i class="fas fa-eye"></i></a>

                                                <!-- Tambahkan tombol atau tautan aksi di sini sesuai kebutuhan -->
                                                <?php
                                                    if ($_SESSION['id_role'] != '0') {
                                                        // Hanya pengguna selain superadmin yang bisa melihat dan melakukan aksi ini
                                                        echo '<a href="editpresma.php?id_prestasi=' . $data_prestasi['id_prestasi'] . '" class="btn btn-xs btn-warning" title="Edit"><i class="fas fa-edit"></i></a>';
                                                        echo '<a href="deletepresma.php?id_prestasi=' . $data_prestasi['id_prestasi'] . '" class="btn btn-xs btn-danger" onclick="return confirm(\'Apakah Anda yakin ingin menghapus mahasiswa ini?\');"><i class="fas fa-trash" title="Hapus"></i></a>';
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
                         <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                                <li class="page-item"><a class="page-link" href="presma.php?page=<?= max($page - 1, 1); ?>">&laquo;</a></li>

                                <?php
                                for ($i = 1; $i <= $total_pages; $i++) {
                                    echo "<li class='page-item " . ($page == $i ? 'active' : '') . "'><a class='page-link' href='presma.php?page=$i'>$i</a></li>";
                                }
                                ?>
                                <li class="page-item"><a class="page-link" href="presma.php?page=<?= min($page + 1, $total_pages); ?>">&raquo;</a></li>
                            </ul>
                            <span class="float-right" style="margin-top: 5px; margin-right: 10px;">Halaman <?= $page; ?> dari <?= $total_pages; ?></span>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include("includes/footer.php") ?>
    </div>
    <?php include("includes/script.php") ?>
</body>
</html>
