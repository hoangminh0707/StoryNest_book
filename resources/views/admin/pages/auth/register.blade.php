<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Sign Up | Velzon - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Layout config Js -->
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

</head>

<body>

    <!-- auth-page wrapper -->
    <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>
        <!-- auth-page content -->
        <div class="auth-page-content overflow-hidden pt-lg-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card overflow-hidden m-0">
                            <div class="row justify-content-center g-0">
                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4 auth-one-bg h-100">
                                        <div class="bg-overlay"></div>
                                        <div class="position-relative h-100 d-flex flex-column">
                                            <div class="mb-4">
                                                <a href="index.html" class="d-block">
                                                    <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="18">
                                                </a>
                                            </div>
                                            <div class="mt-auto">
                                                <div class="mb-3">
                                                    <i class="ri-double-quotes-l display-4 text-success"></i>
                                                </div>

                                                <div id="qoutescarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                                    <div class="carousel-indicators">
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                    </div>
                                                    <div class="carousel-inner text-center text-white-50 pb-5">
                                                        <div class="carousel-item active">
                                                            <p class="fs-15 fst-italic">" Great! Clean code, clean design, easy for customization. Thanks very much! "</p>
                                                        </div>
                                                        <div class="carousel-item">
                                                            <p class="fs-15 fst-italic">" The theme is really great with an amazing customer support."</p>
                                                        </div>
                                                        <div class="carousel-item">
                                                            <p class="fs-15 fst-italic">" Great! Clean code, clean design, easy for customization. Thanks very much! "</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end carousel -->

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <div>
                                            <h5 class="text-primary">Register Account</h5>
                                            <p class="text-muted">Get your Free Velzon account now.</p>
                                        </div>

                                        <div class="mt-4">
                                            <form class="needs-validation" method="POST" action="{{ route('register.admin') }}">
                                                @csrf

                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                                    <input type="text"  class="form-control" id="name" name="name" placeholder="Nhập họ và tên" 
                                                    value="{{ old('name') }}" required>
                                                    <div class="invalid-feedback">
                                                        Vui lòng nhập họ và tên!
                                                        @error('name')<div>{{ $message }}</div>@enderror
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                                    <input type="email"  class="form-control" id="email" name="email" 
                                                    placeholder="Nhập Email" value="{{ old('email') }}" required>
                                                    <div class="invalid-feedback">
                                                        Vui lòng nhập Email
                                                        @error('email')<div>{{ $message }}</div>@enderror
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">Mật Khẩu <span class="text-danger">*</span></label>
                                                    <input type="password"  class="form-control" id="password" name="password" 
                                                    placeholder="Nhập mật khẩu" required>
                                                    <div class="invalid-feedback">
                                                        Vui lòng nhập password
                                                        @error('password')<div>{{ $message }}</div>@enderror
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="password_confirmation" class="form-label">Nhập Lại Mật Khẩu <span class="text-danger">*</span></label>
                                                    <input type="password"  class="form-control" id="password_confirmation" name="password_confirmation" 
                                                    placeholder="Nhập mật khẩu" required>
                                                    <div class="invalid-feedback">
                                                        Vui lòng nhập mật khẩu xác nhận
                                                        @error('password_confirmation')<div>{{ $message }}</div>@enderror
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="gender" class="form-label">Giới tính <span class="text-danger">*</span></label>
                                                    <select class="form-select mb-3" id="gender" name="gender" required>
                                                        <option selected>Click Để Mở Menu</option>
                                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Nam</option>
                                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Nữ</option>
                                                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Khác</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        @error('gender')<div>{{ $message }}</div>@enderror
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="exampleInputdate" class="form-label">Ngày sinh</label>
                                                    <input type="date" class="form-control" id="birthdate" name="birthdate" value="{{ old('birthdate') }}" required>
                                                    <div class="invalid-feedback">
                                                        @error('birthdate')<div>{{ $message }}</div>@enderror
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="phone" class="form-label">Số Điện Thoại</label>
                                                    <input type="text" class="form-control" id="phone"  name="phone" value="{{ old('phone') }}" placeholder="(xxx)xxx-xxxx">
                                                    <div class="invalid-feedback">
                                                        @error('phone')<div>{{ $message }}</div>@enderror
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                                                    <input type="text"  class="form-control" id="address" name="address" value="{{ old('address') }}"
                                                     placeholder="Nhập địa chỉ" required>
                                                    <div class="invalid-feedback">
                                                        Vui lòng nhập Địa Chỉ
                                                        @error('address')<div>{{ $message }}</div>@enderror
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="customer_type" class="form-label">Loại Tài Khoản <span class="text-danger">*</span></label>
                                                    <select class="form-select mb-3" id="customer_type" name="customer_type" required>
                                                        <option value="guest" {{ old('customer_type') == 'guest' ? 'selected' : '' }}>guest</option>
                                                        <option value="registered" {{ old('customer_type') == 'registered' ? 'selected' : '' }}>registered</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        @error('customer_type')<div>{{ $message }}</div>@enderror
                                                    </div>
                                                </div>

                                                <div class="mt-4">
                                                    <button class="btn btn-success w-100" type="submit">Đăng Ký</button>
                                                </div>

                                                <div class="mt-4 text-center">
                                                    <div class="signin-other-title">
                                                        <h5 class="fs-13 mb-4 title text-muted">Create account with</h5>
                                                    </div>

                                                    <div>
                                                        <button type="button" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-facebook-fill fs-16"></i></button>
                                                        <button type="button" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-google-fill fs-16"></i></button>
                                                        <button type="button" class="btn btn-dark btn-icon waves-effect waves-light"><i class="ri-github-fill fs-16"></i></button>
                                                        <button type="button" class="btn btn-info btn-icon waves-effect waves-light"><i class="ri-twitter-fill fs-16"></i></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="mt-5 text-center">
                                            <p class="mb-0">Already have an account ? <a href="auth-signin-cover.html" class="fw-semibold text-primary text-decoration-underline"> Signin</a> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->

                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0">&copy;
                                <script>document.write(new Date().getFullYear())</script> Velzon. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>

    <!-- validation init -->
    <script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
    <!-- password create init -->
    <script src="{{ asset('assets/js/pages/passowrd-create.init.js') }}"></script>
</body>

</html>