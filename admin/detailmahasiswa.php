<?php
include('koneksi/koneksi.php');

session_start();

if (isset($_GET['id_mahasiswa'])) {
    $mahasiswa_id = $_GET['id_mahasiswa'];

    $query = mysqli_query($koneksi, "SELECT * FROM `mahasiswa` INNER JOIN `prodi` ON mahasiswa.id_prodi_mahasiswa = prodi.id_prodi WHERE `id_mahasiswa` = '$mahasiswa_id'");

    if ($query) {
        $mahasiswa_data = mysqli_fetch_assoc($query);
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    header("Location: mahasiswa.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("includes/head.php") ?>
    <title>Detail Mahasiswa</title>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include("includes/header.php") ?>
        <?php include("includes/sidebar.php") ?>

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                </div>
            </section>

            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="color:black; font-size:larger;"><i class="fas fa-user"></i> Detail Mahasiswa</h3>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($mahasiswa_data)) : ?>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Nama Mahasiswa</th>
                                    <td><?php echo $mahasiswa_data['nama_mahasiswa']; ?></td>
                                </tr>
                                <tr>
                                    <th>NIM</th>
                                    <td><?php echo $mahasiswa_data['nim_mahasiswa']; ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?php echo $mahasiswa_data['email_mahasiswa']; ?></td>
                                </tr>
                                <tr>
                                    <th>Program Studi</th>
                                    <td><?php echo $mahasiswa_data['nama_prodi']; ?></td>
                                </tr>
                            </table>

                            <h4 class="mt-4">Riwayat Prestasi Mahasiswa</h4>
                            <?php
                            // Fetch prestasi mahasiswa data from the database based on mahasiswa_id
                            $prestasi_query = mysqli_query($koneksi, "SELECT * FROM `prestasimahasiswa` WHERE `id_mahasiswa` = '$mahasiswa_id'");
                            if ($prestasi_query) {
                                // Check if there are any achievements
                                if (mysqli_num_rows($prestasi_query) > 0) {
                                    echo '<table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>ID Prestasi</th>
                                                    <th>Nama Prestasi</th>
                                                    <th>Tanggal Pelaksanaan</th>
                                                    <th>Lembaga Penyelenggara</th>
                                                    <th>Lokasi</th>
                                                    <th>Jenis Kepesertaan</th>
                                                    <th>Capaian</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                    while ($prestasi_data = mysqli_fetch_assoc($prestasi_query)) {
                                        echo '<tr>
                                                <td>' . $prestasi_data['id_prestasi'] . '</td>
                                                <td>' . $prestasi_data['nama_prestasi'] . '</td>
                                                <td>' . $prestasi_data['tanggal_pelaksanaan_akhir'] . '</td>
                                                <td>' . $prestasi_data['lembaga_penyelenggara'] . '</td>
                                                <td>' . $prestasi_data['lokasi'] . '</td>
                                                <td>' . $prestasi_data['jenis_kepesertaan'] . '</td>
                                                <td>' . $prestasi_data['capaian'] . '</td>
                                            </tr>';
                                    }
                                    echo '</tbody></table>';
                                } else {
                                    echo '<p>No academic achievements found.</p>';
                                }
                            } else {
                                echo "Error fetching academic achievements: " . mysqli_error($koneksi);
                            }
                            ?>

                            <div class="mt-3">
                                <a href="mahasiswa.php" class="btn btn-warning " style="font-weight: 700;">Back</a>
                            </div>
                        <?php else : ?>
                            <div class="alert alert-warning" role="alert">
                                Mahasiswa not found.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </div>

        <?php include("includes/footer.php") ?>
    </div>
    <?php include("includes/script.php") ?>
</body>

</html>