<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">


<head>

    <meta charset="utf-8" />
    <title>Admin | @yield('title', 'Admin Panel')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/2.png') }}">



    {{--
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet"> --}}

    <link rel="stylesheet" href="{{ asset('assets/css/materialdesignicons.min.css') }}">

    <script src="{{ asset('assets/js/ckeditor.js') }}"></script>

    <!-- Sweet Alert css-->
    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- plugin css -->
    <link href="{{ asset('assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" />

    <!-- Thêm Link CSS -->
    {{--
    <link href="https://cdn.jsdelivr.net/npm/list.js@2.3.1/dist/list.min.css" rel="stylesheet"> --}}

    <!-- SimpleBar CSS -->
    <link href="{{ asset('assets/css/simplebar.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <!-- SimpleBar JS -->
    <script src="{{ asset('assets/js/simplebar.min.js') }}"></script>


</head>
<script>
    // Thông Báo Thành Công
    document.addEventListener('DOMContentLoaded', function () {


        @if (session('success'))
            Swal.fire({
                title: 'Thành công!',
                text: '{{ session("success") }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: '{{ session('error') }}',
                timer: 4000,
                showConfirmButton: false
            });
        @endif
});

</script>

<body>

    @include('admin.layouts.header')
    @yield('content')
    @include('admin.layouts.footer')
    @yield('scripts')

</body>

</html>