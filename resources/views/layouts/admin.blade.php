<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Laravel SB Admin 2">
    <meta name="author">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>GO-UMA Administrator</title>

    <!-- Fonts -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link href="{{asset('img/logo2.png')}}" rel="icon">
    <!-- <link href="{{ asset('img/favicon.png') }}" rel="icon" type="image/png"> -->

    @stack('css')
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('layouts.components.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('layouts.components.header')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @stack('notif')
                    @yield('main-content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('layouts.components.footer')
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Ready to Leave?') }}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Anda yakin ingin Logout?</div>
                <div class="modal-footer">
                    <button class="btn btn-link" type="button" data-dismiss="modal">{{ __('Batal') }}</button>
                    <a class="btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    <script>
        function showHideLevel() {
            var level = $(".user-level").val();
            if (level == "1") {
                $(".show-level").show();
            } else {
                $(".show-level").hide();
            }
        }
        $(function() {
            showHideLevel();
            $(".user-level").change(function() {
                showHideLevel();
            });
        });

        function imagePreview(fileInput) {
            if (fileInput.files && fileInput.files[0]) {
                var fileReader = new FileReader();
                fileReader.onload = function(event) {
                    $('#preview').html('<img src="' + event.target.result + '" class="rounded-circle" width="300px" height="300px"/>');
                    $('#preview-product').html('<img src="' + event.target.result + '" width="300px" height="300px"/>');
                    $('#preview-kurir').html('<img src="' + event.target.result + '" width="200px" height="250"/>');
                };
                fileReader.readAsDataURL(fileInput.files[0]);
            }
        }
        $(".preview-image").change(function() {
            imagePreview(this);
        });

        function showHideProduct() {
            var branches = [];
            <?php if (isset($products)) { ?>
                branches = <?php echo json_encode($products); ?>;
                var level = $(".product-branch").val();
                if (level != "") {
                    branches.forEach(element => {
                        if (level == element['id']) {
                            $(".product-information").show();
                            $("#kode").val(element['kode']);
                            $("#nama").val(element['nama']);
                            $("#harga").val(element['harga']);
                            $("#gambar").attr("src", "{{ asset('storage/') }}/" + element['foto']);

                        }
                    });
                } else {
                    $(".product-information").hide();
                }

            <?php } ?>;
        }
        $(function() {
            showHideProduct();
            $(".product-branch").change(function() {
                showHideProduct();
            });
        });
    </script>
    @stack('js')
</body>

</html>