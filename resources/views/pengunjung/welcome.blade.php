<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>GO - UMA</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{asset('img/logo2.png')}}" rel="icon">
    <!-- <link href="{{asset('SoftLand/assets/img/favicon.png')}}" rel="icon"> -->
    <!-- <link href="{{asset('SoftLand/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon"> -->

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{asset('SoftLand/assets/vendor/aos/aos.css')}}" rel="stylesheet">
    <link href="{{asset('SoftLand/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('SoftLand/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{asset('SoftLand/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{asset('SoftLand/assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{asset('SoftLand/assets/css/style.css')}}" rel="stylesheet">

    <!-- =======================================================
  * Template Name: SoftLand - v4.7.0
  * Template URL: https://bootstrapmade.com/softland-bootstrap-app-landing-page-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    @include('pengunjung.components.header')
    <!-- End Header -->

    <!-- ======= Hero Section ======= -->
    @include('pengunjung.components.hero')
    <!-- End Hero -->

    <main id="main">

        <!-- ======= Home Section ======= -->
        @include('pengunjung.components.about')

        <!-- ======= CTA Section ======= -->
        <section id="download" class="section cta-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 me-auto text-center text-md-start mb-5 mb-md-0">
                        <h2>Download aplikasi GO-UMA sekarang</h2>
                    </div>
                    <div class="col-md-5 text-center text-md-end">
                        <p><a href="https://drive.google.com/drive/folders/1eaPT43oTt4b4ke_kVQZEWJWDCd_w5eia?usp=sharing" class="btn d-inline-flex align-items-center"><i class="bx bxl-apple"></i><span>App store</span></a> <a href="https://drive.google.com/drive/folders/1eaPT43oTt4b4ke_kVQZEWJWDCd_w5eia?usp=sharing" class="btn d-inline-flex align-items-center"><i class="bx bxl-play-store"></i><span>Google play</span></a></p>
                    </div>
                </div>
            </div>
        </section>
        <!-- End CTA Section -->

        <!-- ======= Contact Section ======= -->
        @include('pengunjung.components.contact')
        <!-- End Contact Section -->

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    @include('pengunjung.components.footer')

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{asset('SoftLand/assets/vendor/aos/aos.js')}}"></script>
    <script src="{{asset('SoftLand/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('SoftLand/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
    <script src="{{asset('SoftLand/assets/vendor/php-email-form/validate.js')}}"></script>

    <!-- Template Main JS File -->
    <script src="{{asset('SoftLand/assets/js/main.js')}}"></script>
</body>

</html>
