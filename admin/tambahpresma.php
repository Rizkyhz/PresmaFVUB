<?php
session_start();
include('koneksi/koneksi.php');

$id_bidang = isset($_POST['id_bidang']) ? $_POST['id_bidang'] : null;
$id_jenis_kejuaraan = isset($_POST['id_jenis_kejuaraan']) ? $_POST['id_jenis_kejuaraan'] : null;
$no_surattugas = isset($_POST['no_surattugas']) ? $_POST['no_surattugas'] : null;

// Fetch data for dropdowns
$query_tingkat_kejuaraan = mysqli_query($koneksi, "SELECT * FROM tingkatkejuaraan");
$query_jenis_kepesertaan = mysqli_query($koneksi, "SELECT * FROM jenis_kepesertaan");
$query_status = mysqli_query($koneksi, "SELECT * FROM status");
$query_departemen = mysqli_query($koneksi, "SELECT * FROM departemen");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle file uploads
    $nama_file_surattugas = $_FILES['scan_surattugas']['name'];
    $file_path_surattugas = 'filesurattugas/' . $nama_file_surattugas;
    move_uploaded_file($_FILES['scan_surattugas']['tmp_name'], $file_path_surattugas);
    echo $_FILES['scan_surattugas']['name'];


    $nama_file_sertifikat = $_FILES['scan_sertifikat']['name'];
    $file_path_sertifikat = 'filesertif/' . $nama_file_sertifikat;
    move_uploaded_file($_FILES['scan_sertifikat']['tmp_name'], $file_path_sertifikat);
    echo $_FILES['scan_sertifikat']['name'];

    // Insert file information into the 'savedfiles' table
    $insert_file_query = "INSERT INTO savedfiles (nama_file_surattugas, file_path_surattugas, nama_file_sertifikat, file_path_sertifikat) VALUES ('$nama_file_surattugas', '$file_path_surattugas', '$nama_file_sertifikat', '$file_path_sertifikat')";
    $result_file = mysqli_query($koneksi, $insert_file_query);

    if (!$result_file) {
        die("Gagal menyimpan informasi file: " . mysqli_error($koneksi));
    }
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Continue with the rest of the form submission
    $id_mahasiswa = $_POST['id_mahasiswa'];
    $nama_prestasi = $_POST['nama_prestasi'];
    $tanggal_pelaksanaan = $_POST['tanggal_pelaksanaan'];
    $lembaga_penyelenggara = $_POST['lembaga_penyelenggara'];
    $lokasi = $_POST['lokasi'];
    $capaian = $_POST['capaian'];
    $bidang = $_POST['id_bidang'];
    $id_jenis_kejuaraan = isset($_POST['id_jenis_kejuaraan']) ? $_POST['id_jenis_kejuaraan'] : null;
    $no_surattugas = $_POST['no_surattugas'];
    $id_tingkat_kejuaraan = $_POST['id_tingkat_kejuaraan'];
    $jenis_kepesertaan = isset($_POST['jenis_kepesertaan']) ? $_POST['jenis_kepesertaan'] : '';
    $id_dosen = $_POST['id_dosen'];
    

    $id_status = isset($_POST['id_status']) ? $_POST['id_status'] : 1; // Nilai default: Menunggu Konfirmasi
    $delegasi_ormawa = isset($_POST['delegasi_ormawa']) ? $_POST['delegasi_ormawa'] : 'no';
    $nama_ormawa = ($delegasi_ormawa === 'yes') ? mysqli_real_escape_string($koneksi, $_POST['nama_ormawa']) : '';

    // Insert prestasi details into the database
$insert_prestasi_query = "INSERT INTO prestasimahasiswa (id_mahasiswa, nama_prestasi, tanggal_pelaksanaan, lembaga_penyelenggara, lokasi, capaian, id_jenis_kejuaraan, no_surattugas, id_bidang, id_tingkat_kejuaraan, jenis_kepesertaan,id_dosen, id_status, nama_ormawa, id_file) VALUES ('$id_mahasiswa', '$nama_prestasi', '$tanggal_pelaksanaan', '$lembaga_penyelenggara', '$lokasi', '$capaian', '$id_jenis_kejuaraan', '$no_surattugas', '$bidang', '$id_tingkat_kejuaraan', '$jenis_kepesertaan','$id_dosen', '$id_status', '$nama_ormawa', LAST_INSERT_ID())";

    $result_prestasi = mysqli_query($koneksi, $insert_prestasi_query);

    if ($result_prestasi) {
        // Prestasi details inserted successfully

        // If jenis_kepesertaan is 'kelompok', handle group members
        if ($jenis_kepesertaan === 'kelompok') {
            $id_prestasi = mysqli_insert_id($koneksi);

            // Loop through the anggota_nim array and insert each member
            foreach ($_POST['anggota_nim'] as $nim) {
                $insert_member_query = "INSERT INTO kelompok (id_prestasi, nim_anggota) VALUES ('$id_prestasi', '$nim')";
                mysqli_query($koneksi, $insert_member_query);
            }
        }

        // Redirect to the prestasi list page
        $_SESSION['success_message'] = "Prestasi berhasil ditambahkan.";
        echo '<script>alert("Prestasi berhasil ditambahkan."); window.location.href = "presma.php";</script>';
        exit();
    } else {
        // Error in inserting prestasi details
        $error_message = "Error: " . mysqli_error($koneksi);
        echo $error_message;
        // You can handle the error as needed
    }
}

$data_nama_mahasiswa = array();
$query_mahasiswa = mysqli_query($koneksi, "SELECT id_mahasiswa, nama_mahasiswa FROM mahasiswa");
while ($row_mahasiswa = mysqli_fetch_assoc($query_mahasiswa)) {
    $data_mahasiswa[] = $row_mahasiswa;
}
// Fetch bidang data
$sql_bidang = "SELECT * FROM bidang";
$query_bidang = mysqli_query($koneksi, $sql_bidang);

// Fetch jenis kejuaraan data
$sql_jenis_kejuaraan = "SELECT * FROM jenis_kejuaraan";
$query_jenis_kejuaraan = mysqli_query($koneksi, $sql_jenis_kejuaraan);

// Fetch data for dropdowns again (this is done outside the form submission block so that the dropdowns are available when the page loads)
$query_tingkat_kejuaraan = mysqli_query($koneksi, "SELECT * FROM tingkatkejuaraan");
$query_jenis_kepesertaan = mysqli_query($koneksi, "SELECT * FROM jenis_kepesertaan");
$query_status = mysqli_query($koneksi, "SELECT * FROM status");
$query_departemen = mysqli_query($koneksi, "SELECT * FROM departemen");

?>

<!DOCTYPE html>
<html>
<head>
    <?php include("includes/head.php") ?>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <!-- Add these links to your HTML file -->
        <!-- Tambahkan di dalam tag <head> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <?php include("includes/header.php") ?>
    <?php include("includes/sidebar.php") ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <!-- ... (same as your existing code) ... -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="card">
                <div class="card" style="background-color: #0174BE;">
                        <div class="card-header">
                            <h3 class="card-title"style="margin-top:5px; color:white; font-weight:500; "><i class="far fa-list-alt"></i> Form Tambah Data Prestasi</h3>
                            <div class="card-tools">
                                <a href="presma.php" class="btn btn-sm btn-warning float-right"><i class="fas fa-arrow-alt-circle-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="post" action="tambahpresma.php" id="formSearch" enctype="multipart/form-data">
                        <div class="card-body">
                            <!-- Dropdown/Select for Nama Mahasiswa -->
                            <!-- Ubah dropdown Nama Mahasiswa -->
                                <div class="form-group">
                                    <label for="id_mahasiswa">Nama Mahasiswa</label>
                                    <select name="id_mahasiswa" id="id_mahasiswa" class="form-control select2">
                                        <option value="">Pilih Nama Mahasiswa</option>
                                        <?php foreach ($data_mahasiswa as $mahasiswa) : ?>
                                            <option value="<?= $mahasiswa['id_mahasiswa']; ?>"><?= $mahasiswa['nama_mahasiswa']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <!-- Dropdown for Bidang Prestasi -->
                             <div class="form-group">
                                <label for="bidang">Bidang Prestasi</label>
                                <select name="id_bidang" id="bidang" class="form-control">
                                    <option value="">Select Bidang</option>
                                    <?php
                                    while ($row_bidang = mysqli_fetch_assoc($query_bidang)) {
                                        echo "<option value='" . $row_bidang['id_bidang'] . "'>" . $row_bidang['nama_bidang'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="id_jenis_kejuaraan">Jenis Kejuaraan</label>
                                <select name="id_jenis_kejuaraan" id="id_jenis_kejuaraan" class="form-control">
                                    <option value="">Select Jenis Kejuaraan</option>
                                    <!-- Options will be dynamically populated using AJAX -->
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="nama_prestasi">Nama Prestasi</label>
                                <input type="text" class="form-control" name="nama_prestasi" placeholder="Masukkan Nama Prestasi Anda" id="nama_prestasi" value="">
                            </div>
                            <div class="form-group">
                                <label for="capaian">Capaian Prestasi</label>
                                <input type="text" class="form-control" name="capaian" id="capaian" value="">
                            </div>
                            <div class="form-group">
                                <label for="tanggal_pelaksanaan">Tanggal Pelaksanaan</label>
                                <input type="date" class="form-control" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan" value="">
                            </div>
                            <div class="form-group">
                                <label for="lembaga_penyelenggara">Lembaga Penyelenggara</label>
                                <input type="text" class="form-control" name="lembaga_penyelenggara" placeholder="Masukkan Lembaga Penyelenggara" id="lembaga_penyelenggara" value="">
                            </div>
                            <div class="form-group">
                                <label for="lokasi">Tempat Kegiatan</label>
                                <input type="text" class="form-control" name="lokasi" placeholder="Masukkan Tempat" id="lokasi" value="">
                            </div>
                            <div class="form-group">
                                <label for="delegasi_ormawa">Delegasi ORMAWA</label>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="delegasi_ormawa" value="yes" id="delegasi_ormawa_yes" required onclick="showOrHideForm()">
                                    <label class="form-check-label" for="delegasi_ormawa_yes">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="delegasi_ormawa" value="no" id="delegasi_ormawa_no" required onclick="showOrHideForm()">
                                    <label class="form-check-label" for="delegasi_ormawa_no">Tidak</label>
                                </div>
                            </div>

                            <div id="ormawaForm" style="display: none;">
                                <div class="form-group">
                                    <label for="nama_ormawa">Nama ORMAWA</label>
                                    <input type="text" class="form-control" id="nama_ormawa" name="nama_ormawa">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="id_tingkat_kejuaraan">Tingkat Kejuaraan</label>
                                <select class="form-control" name="id_tingkat_kejuaraan" value="" required>
                                    <option value="">Select Tingkat Kejuaraan</option>
                                    <?php
                                    while ($data_tingkat_kejuaraan = mysqli_fetch_assoc($query_tingkat_kejuaraan)) {
                                        echo '<option value="' . $data_tingkat_kejuaraan['id_tingjur'] . '" ' . $selected . '>' . $data_tingkat_kejuaraan['tingkatan'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                          <div class="form-group">
                                <label for="jenis_kepesertaan">Jenis Kepesertaan</label>
                                <?php
                                while ($row = mysqli_fetch_assoc($query_jenis_kepesertaan)) {
                                    $id_kepesertaan = $row['id_kepesertaan'];
                                    $jenis_kepesertaan = $row['jenis_kepesertaan'];

                                    echo '<div class="form-check">';
                                    echo '<input type="radio" class="form-check-input" name="jenis_kepesertaan" value="' . $id_kepesertaan . '" id="jenis_kepesertaan_' . $id_kepesertaan . '" required>';

                                    // Check if the current option is "kelompok"
                                    if ($jenis_kepesertaan === 'kelompok') {
                                        echo '<label class="form-check-label kelompok-label" for="jenis_kepesertaan_' . $id_kepesertaan . '">' . $jenis_kepesertaan . '</label>';
                                    } else {
                                        echo '<label class="form-check-label" for="jenis_kepesertaan_' . $id_kepesertaan . '">' . $jenis_kepesertaan . '</label>';
                                    }

                                    echo '</div>';
                                }

                                ?>
                            </div>
                            <!-- Di dalam form -->
                            <div class="form-group" id="kelompok-field" style="display: none;">
                                <label for="nama_anggota_kelompok">Nama Anggota Kelompok</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="anggota_nim[]" id="nim_anggota" placeholder="Masukkan NIM Anggota">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-success" onclick="tambahAnggota()">
                                            <i class="fas fa-plus"></i> Tambah Anggota
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="anggotaContainer"></div>

                            <div class="form-group">
                                <label for="id_dosen">Dosen Pembimbing</label>
                                <select class="form-control" name="id_dosen" required>
                                    <option value="">Select Dosen Pembimbing</option>
                                    <?php
                                    $query_dosen = mysqli_query($koneksi, "SELECT * FROM dosen");
                                    while ($row_dosen = mysqli_fetch_assoc($query_dosen)) {
                                        echo '<option value="' . $row_dosen['id_dosen'] . '">' . $row_dosen['nama_dosen'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="nama_document">Nomor Sertifikat</label>
                                <input type="text" class="form-control" name="nama_document" id="nama_document" placeholder="Masukkan Nomor Sertifikat">
                            </div>
                            <div class="form-group">
                                <label for="no_surattugas">Nomor Surat Tugas</label>
                                <input type="text" class="form-control" name="no_surattugas" id="no_surattugas" placeholder="Masukkan Nomor Surat Tugas Pembimbing">
                            </div>
                           <div class=""><br>
                            <h5>Perlengkapan Dokumen</h5><br>
                           </div>
                            <div class="form-group">
                                <label for="scan_surattugas">Upload Surat Tugas </label>
                                <input type="file" class="form-control-file" name="scan_surattugas" id="scan_surattugas" accept=".pdf, .doc, .docx, .jpg, .jpeg, .png" required>
                                <small id="scan_sertifikat_help" class="form-text text-muted">Hanya file dengan ekstensi .pdf, .doc, .docx, .jpg, .jpeg, .png yang diperbolehkan.</small>
                            </div>

                            <div class="form-group">
                                <label for="scan_sertifikat">Upload Sertifikat</label>
                                <input type="file" class="form-control-file" name="scan_sertifikat" id="scan_sertifikat" accept=".pdf, .doc, .docx, .jpg, .jpeg, .png" required>
                                <small id="scan_sertifikat_help" class="form-text text-muted">Hanya file dengan ekstensi .pdf, .doc, .docx, .jpg, .jpeg, .png yang diperbolehkan.</small>
                            </div>
                        </form>

                        <!-- Submit button -->
                        <div class="card-footer">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-info float-right">
                                    <i class="fas fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </form>
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
<script>
      document.addEventListener('DOMContentLoaded', function () {
        <?php
        mysqli_data_seek($query_jenis_kepesertaan, 0); // Kembali ke awal data
        while ($row = mysqli_fetch_assoc($query_jenis_kepesertaan)) {
            $id_kepesertaan = $row['id_kepesertaan'];
        ?>
            var kelompokField = document.getElementById('kelompok-field');
            var radioKelompok = document.getElementById('jenis_kepesertaan_<?php echo $id_kepesertaan; ?>');

            // Tambahkan event listener untuk setiap perubahan pada radio button
            radioKelompok.addEventListener('change', function () {
                // Periksa apakah radio button kelompok dipilih
                if (radioKelompok.checked) {
                    // Jika dipilih, tampilkan field nama anggota kelompok
                    kelompokField.style.display = 'block';
                } else {
                    // Jika tidak dipilih, sembunyikan field nama anggota kelompok
                    kelompokField.style.display = 'none';
                }
            });
        <?php
        }
        ?>
    });
    var anggotaCounter = 0;

    function tambahAnggota() {
        var nimAnggota = document.getElementById('nim_anggota').value;
        if (nimAnggota.trim() === '') {
            alert('Silakan masukkan NIM anggota.');
            return;
        }

        // Panggil AJAX untuk mengambil data diri mahasiswa berdasarkan NIM
        $.ajax({
            type: 'POST',
            url: 'get_mahasiswa_data.php', // Gantilah dengan skrip PHP yang sesuai
            // data: 'nim=' + nimAnggota,
            data: {
                nim_mahasiswa: nimAnggota
            },
            success: function (data) {
                // Cek apakah data ditemukan
                if (data !== 'not_found') {
                    // Parse data JSON
                    var mahasiswaData = JSON.parse(data);

                    // Tambahkan anggota ke dalam container
                    tambahkanAnggotaKeContainer(mahasiswaData);
                } else {
                    alert('Data mahasiswa tidak ditemukan.');
                }
            }
        });
    }

    function tambahkanAnggotaKeContainer(data) {
        anggotaCounter++;

        // Buat elemen input untuk NIM anggota
        var inputNim = '<input type="hidden" name="anggota_nim[]" value="' + data.nim + '">';

        // Buat elemen input untuk nama anggota
        var inputNama = '<input type="text" class="form-control" name="anggota_nama[]" value="' + data.nama_mahasiswa + '" readonly>';

        // Buat elemen untuk menghapus anggota
        var buttonHapus = '<button type="button" class="btn btn-danger" onclick="hapusAnggota(' + anggotaCounter + ')"><i class="fas fa-trash"></i></button>';

        // Buat div untuk menyimpan input dan tombol hapus
        var anggotaDiv = '<div class="form-group anggota" data-index="' + anggotaCounter + '">' + inputNim + inputNama + buttonHapus + '</div>';

        // Tambahkan anggota ke dalam container
        $('#anggotaContainer').append(anggotaDiv);
    }

    function hapusAnggota(index) {
        // Hapus elemen anggota berdasarkan index
        $('.anggota[data-index="' + index + '"]').remove();
    }

    // nama_mahasiswa
    // $(document).ready(function () {
    //     var data_nama_mahasiswa = <?php echo json_encode($data_nama_mahasiswa); ?>;
    //     $('#nama_mahasiswa').autocomplete({
    //         source: data_nama_mahasiswa,
    //         minLength: 1, // Minimum karakter sebelum pencarian dimulai
    //         select: function (event, ui) {
    //             // Update the hidden input field with the selected id_mahasiswa
    //             $('#id_mahasiswa').val(ui.item.id_mahasiswa);
    //         }
    //     });
    // });
//      $(document).ready(function() {
//         $('.select2').select2();
//     });
//     $(document).ready(function () {
//     // Assuming that the value of the Mahasiswa dropdown is updated when a user makes a selection
//     $('select[name="id_mahasiswa"]').on('change', function () {
//         var selectedMahasiswaId = $(this).val();
//         $('#id_mahasiswa').val(selectedMahasiswaId);
//     });
//         $('.select2').select2();

// });
 $(document).ready(function () {
        // Inisialisasi Select2 pada dropdown Nama Mahasiswa
        $('.select2').select2({
            minimumInputLength: 1, // Set minimum input length before triggering search
            ajax: {
                url: 'get_nama_mahasiswa.php', // Replace with your PHP file to fetch data dynamically
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // Search term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data,
                    };
                },
                cache: true,
            },
            placeholder: 'Pilih Nama Mahasiswa',
        });
    });

    // Fungsi untuk menangani perubahan pada dropdown Nama Mahasiswa
    $('#id_mahasiswa').on('change', function () {
        var selectedMahasiswaId = $(this).val();
        // Set nilai pada input tersembunyi
        $('#id_mahasiswa_hidden').val(selectedMahasiswaId);
        // Bersihkan nilai input teks jika ada
        $('#nama_mahasiswa_input').val('');
    });

    // Fungsi untuk menangani perubahan pada input teks Nama Mahasiswa
    $('#nama_mahasiswa_input').on('input', function () {
        // Kosongkan nilai dropdown jika ada
        $('#id_mahasiswa').val('');
        // Bersihkan nilai input tersembunyi jika ada
        $('#id_mahasiswa_hidden').val('');
    });

    // jenis_kejuaraaan
     $(document).ready(function () {
            $('#bidang').on('change', function () {
                var bidangID = $(this).val();
                if (bidangID) {
                    $.ajax({
                        type: 'POST',
                        url: 'get_jenis_kejuaraan.php', // Create a new PHP file to handle this AJAX request
                        data: 'id_bidang=' + bidangID,
                        success: function (html) {
                            $('#id_jenis_kejuaraan').html(html);
                        }
                    });
                } else {
                    $('#id_jenis_kejuaraan').html('<option value="">Select Jenis Kejuaraan</option>');
                }
            });
        });
     function showOrHideForm() {
        var ormawaForm = document.getElementById("ormawaForm");
        var yesRadio = document.getElementById("delegasi_ormawa_yes");

        if (yesRadio.checked) {
            ormawaForm.style.display = "block";
        } else {
            ormawaForm.style.display = "none";
        }
    }
</script>

</body>
</html>
