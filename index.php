<?php
include('admin/koneksi/koneksi.php');

$sql = "SELECT COUNT(*) AS jumlah_mahasiswa, YEAR(tanggal_pelaksanaan_akhir) AS tahun 
        FROM prestasimahasiswa  
        WHERE id_status = 1 
        GROUP BY YEAR(tanggal_pelaksanaan_akhir)";

$result = mysqli_query($koneksi, $sql);

$user_data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $user_data[] = [
        'jumlah_mahasiswa' => $row['jumlah_mahasiswa'],
        'tahun' => $row['tahun'],
    ];
}

mysqli_close($koneksi);

$dataGrafik = json_encode($user_data);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PRESMA Vokasi</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <script src="js/apexcharts.js"></script>

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <img src="img/logo-vokasi.png" alt="" style="width: 60px;">
            <img src="img/logo-prestasi.png" alt="" width="40px">
            <div class="ms-2">
                <h2 class="m-0 text-dark">PRESMA Vokasi</h2>
            </div>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto p-4 p-lg-0">
                        <a href="index.php" class="nav-item nav-link active">Home</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Prestasi</a>
                            <div class="dropdown-menu fade-down m-0">
                                <a href="data-prestasi.php" class="dropdown-item">Data Prestasi</a>
                                <a href="galeri-prestasi.php" class="dropdown-item">Galeri Prestasi</a>
                                <a href="grafik-prestasi.php" class="dropdown-item">Grafik Data Prestasi</a>
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Lainnya</a>
                            <div class="dropdown-menu fade-down m-0">
                                <a href="info-lomba.php" class="dropdown-item">Informasi Lomba</a>
                            </div>
                        </div>
                    </div>
                    <a href="bantuan.php" class="nav-item nav-link">Bantuan</a>
                </div>
                <a href="login.php" class="btn py-4 px-lg-5 d-none d-lg-block" style="background-color: #003366; color: #FF9900;">Login<i class="fa fa-arrow-right ms-3" style="color: #FF9900;"></i></a>
            </div>
    </nav>
    <!-- Navbar End -->


    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5">
        <div class="owl-carousel header-carousel position-relative">
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="img/gedung-vokasi.jpg" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">

                                <h1 class="display-3 text-white animated slideInDown">PRESMA VOKASI</h1>
                                <p class="fs-5 text-white mb-4 pb-2">Universitas Brawijaya</p>
                                <a href="login.php" class="btn py-md-3 px-md-5 me-3 animated slideInLeft" style="background-color: #FF9900; color: #003366;">Login</a>
                                <a href="register.php" class="btn py-md-3 px-md-5 me-3 animated slideInLeft" style="background-color: #003366; color: #FF9900;">Sign Up</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="img/carousel-2.jpg" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">

                                <h1 class="display-3 text-white animated slideInDown">Get Educated Online From Your Home</h1>
                                <p class="fs-5 text-white mb-4 pb-2">Vero elitr justo clita lorem. Ipsum dolor at sed stet sit diam no. Kasd rebum ipsum et diam justo clita et kasd rebum sea sanctus eirmod elitr.</p>
                                <a href="" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft" style="background-color: #FF9900; color: #003366;">Lihat Prestasi</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="img/prestasi1.jpg" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">


                                <p class="fs-5 text-white mb-4 pb-2">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sunt assumenda quo accusamus impedit quam explicabo voluptatibus quasi.
                                </p>
                                <a href="detail-pres-1.php" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft" style="background-color: #FF9900; color: #003366;">Lihat Prestasi</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- Menu Utama Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title text-center px-3" style="color: #FF9900;"></h6>
                <h1 class="mb-5" style="color: #003366;">Menu Utama</h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <a href="galeri-prestasi.php">
                                <i class="fa fa-3x fa-trophy mb-4" style="color: #FF9900;"></i>
                                <h5 class="mb-3">Galeri Prestasi</h5>
                            </a>

                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <a href="data-pres.php">
                                <i class="fa fa-3x fa-calendar-check mb-4" style="color: #FF9900;"></i>
                                <h5 class="mb-3">Data Prestasi</h5>
                            </a>

                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-book-open mb-4" style="color: #FF9900;"></i>
                            <h5 class="mb-3">Informasi Lomba</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-chart-line mb-4" style="color: #FF9900;"></i>
                            <h5 class="mb-3">Grafik Data Prestasi</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Menu Utama End -->


    <!-- About Start -->
    <div class="container-xxl py-5" style="background-color: #003366;">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">

                        <video class="video-fluid position-absolute w-100 h-100" controls>
                            <source src="" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h1 class="mb-4 text-white">Selamat Datang Vokasioner !</h1>
                    <p class="mb-4 text-white">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                    <p class="mb-4 text-white">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu diam amet diam et eos. Clita erat ipsum et lorem et sit, sed stet lorem sit clita duo justo magna dolore erat amet</p>

                    <a class="btn py-3 px-5 mt-2" href="" style="background-color: #FF9900; color: #003366;">Read More</a>
                </div>
            </div>
        </div>
    </div>

    <!-- About End -->


    <!-- Categories Start -->
    <div class="container-xxl py-5 category">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Tentang</h6>
                <h1 class="mb-5">Prestasi Mahasiswa</h1>
            </div>
            <div>
                <img src="img/logo-vokasi.png" alt="" class="img-fluid float-end">
                <p class="float-start">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Aperiam culpa inventore iusto vel, minima, quae temporibus nulla accusamus quisquam magni ab. Magnam voluptates assumenda, hic fugiat expedita ex velit unde doloribus tempora consectetur harum, rerum laudantium non iste consequuntur numquam ab commodi, soluta quae eligendi asperiores quidem. Quidem odit ad voluptatem asperiores sint placeat excepturi pariatur eveniet. Laudantium, veniam perspiciatis tempore laboriosam culpa reprehenderit molestiae praesentium vel commodi ex voluptate voluptatibus sapiente eum impedit, iste nisi non cum sit eligendi?
                </p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis fugit, consequatur quaerat porro illo explicabo minima, nostrum molestiae nihil atque accusantium quibusdam nesciunt recusandae eaque eos earum ipsa cum? Incidunt nam delectus iure odit fugit suscipit culpa aperiam blanditiis, accusamus quasi harum rem saepe corporis natus pariatur quidem praesentium laborum mollitia debitis vero doloribus. Quas, at fugit sunt sed odit soluta eius non reiciendis blanditiis! Distinctio quo autem cupiditate aliquid pariatur fugiat iure dicta repellendus facilis iste nisi ut, nesciunt culpa, nostrum error aperiam earum doloribus hic sunt explicabo dolores odio itaque, tempora accusantium. Minima consequuntur aliquam doloribus nisi in?
                </p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt dolores facilis tempore autem ex nulla libero iusto rerum delectus quos atque reprehenderit molestiae nesciunt adipisci, cum voluptatem? Ducimus, fugiat? Nostrum perferendis quibusdam impedit quia quasi, distinctio quae ipsa harum explicabo provident eius atque sequi perspiciatis ipsam suscipit eos tenetur dolorum illum cum nobis eveniet! Ad at itaque natus soluta. Odio inventore sint, magni cum est, laborum molestias ipsa commodi enim tempore nulla eos optio possimus dignissimos laboriosam a praesentium, accusantium sequi totam omnis amet ea officiis cupiditate consequuntur! Non voluptates quod impedit pariatur tempore eaque, ratione id placeat dignissimos suscipit.</p>
            </div>
        </div>
    </div>
    <!-- Categories Start -->


    <!-- Courses Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Alur</h6>
                <h1 class="mb-5">Pengajuan Prestasi Mahasiswa</h1>
            </div>

            <div class="container pt-5">

                <div class="row">
                    <div class="col">
                        <div class="timeline-steps aos-init aos-animate" data-aos="fade-up">
                            <div class="timeline-step">
                                <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2003">
                                    <div class="inner-circle"></div>
                                    <p class="h6 mt-3 mb-1">1</p>
                                    <p class="h6 text-muted mb-0 mb-lg-0">Login Akun</p>
                                </div>
                            </div>
                            <div class="timeline-step">
                                <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2004">
                                    <div class="inner-circle"></div>
                                    <p class="h6 mt-3 mb-1">2</p>
                                    <p class="h6 text-muted mb-0 mb-lg-0">Isi Data dan Upload Berkas</p>
                                </div>
                            </div>
                            <div class="timeline-step">
                                <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2005">
                                    <div class="inner-circle"></div>
                                    <p class="h6 mt-3 mb-1">3</p>
                                    <p class="h6 text-muted mb-0 mb-lg-0">Verifikasi Data</p>
                                </div>
                            </div>
                            <div class="timeline-step">
                                <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2010">
                                    <div class="inner-circle"></div>
                                    <p class="h6 mt-3 mb-1">4</p>
                                    <p class="h6 text-muted mb-0 mb-lg-0">Validasi Data</p>
                                </div>
                            </div>
                            <div class="timeline-step mb-0">
                                <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2020">
                                    <div class="inner-circle"></div>
                                    <p class="h6 mt-3 mb-1">5</p>
                                    <p class="h6 text-muted mb-0 mb-lg-0">Prestasi Terupload</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Grafik</h6>
                <h1 class="mb-5">Data Mahasiswa</h1>
            </div>

            <div class="row">
                <div class="d-grid gap-2">
                    <div class="card">
                        <div class="card-header">
                            Grafik data Prestasi
                        </div>
                        <div class="card-body">
                            <div id="chart2"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    </div>

    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">

                <div class="col-lg-3 col-md-6">
                </div>
                <div class="col-lg-3 col-md-6">
                    <img src="img/logo-vokasi.png" alt="">
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="mb-3" style="color: #FF9900;">Contact Us :</h4>
                    <p class="mb-2"><i class="fa fa-building me-3"></i>Gedung Akademik lt 1, Fakultas Vokasi</p>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Jl. Veteran No 12 – 14, Ketawanggede, Malang </p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>Phone: 0341-551-611</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>Email: vokasi@ub.ac.id</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#">2023,Universitas Brawijaya</a>. All Rights Reserved.
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="footer-menu">
                            <a href="">Home</a>
                            <a href="">Prestasi</a>
                            <a href="">Lainnya</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>


</body>

</html>

<script>
    $(document).ready(function() {
        var DataGrafik = <?php echo $dataGrafik; ?>;
        var jumlah_mahasiswa = DataGrafik.map(item => item.jumlah_mahasiswa);
        var tahun = DataGrafik.map(item => item.tahun);

        var options = {
            series: [{
                name: 'Mahasiswa Berprestasi',
                data: jumlah_mahasiswa
            }],
            chart: {
                type: 'bar',
                height: 400,
                background: '#003366',
                foreColor: '#FF9900'
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '15%',
                    endingShape: 'rounded',
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 5,
                colors: ['solid']
            },
            xaxis: {
                categories: tahun,
                labels: {
                    style: {
                        fontSize: '14px',
                        fontFamily: 'Heebo',
                        colors: '#FF9900'
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'Mahasiswa Berprestasi',
                    style: {
                        fontSize: '12px',
                        fontFamily: 'Heebo',
                        color: '#FF9900'
                    }
                },
                labels: {
                    style: {}
                }
            },
            fill: {
                colors: ['#FF9900'],
                fontFamily: 'Heebo',
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val;
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart2"), options);
        chart.render();
    });
</script>