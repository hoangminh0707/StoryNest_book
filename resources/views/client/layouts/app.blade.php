<!DOCTYPE html>
<html>
  <head>
    <title>Bookly - Bookstore eCommerce Website Template</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <!-- Hỗ trợ Android Chrome -->
        <meta name="mobile-web-app-capable" content="yes">

        <!-- Hỗ trợ Safari trên iOS (vẫn dùng được) -->
        <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('assetClient/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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
    });

    // Thông báo giỏ hàng 
    function showLoginAlert() {
        Swal.fire({
            title: 'Thông báo',
            text: 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!',
            icon: 'warning',
            showCancelButton: false,
            confirmButtonText: 'Đăng nhập',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('login') }}";
            }
        });
    }



</script>

 <body>
@include('client.layouts.header')
<div class="container mt-4">
    @yield('content')
</div>
@include('client.layouts.footer')
</body>
</html>
