
<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{ url('') }}/assets/images/logos/favicon.png" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <!-- Core Css -->
    <link rel="stylesheet" href="{{ url('') }}/assets/css/styles.css" />

    <title>Login Mita</title>
</head>

<body>
    <!-- Preloader -->
      {{-- <div class="preloader">
        <img src="./assets/images/logos/logo-linkbit.png" class="preloader-img" alt="loader" />

    </div> --}}
    @include('layouts.welcome-preloader')
    <div id="main-wrapper" class="auth-customizer-none">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 w-100">
            <div class="position-relative z-index-5">
                <div class="row">
                    <div class="col-xl-7 col-xxl-8">
                        <a href="{{ url('/') }}" class="text-nowrap logo-img d-block px-4 py-9 w-100">
                            <img src="../assets/images/logos/logo-linkbit.png" class="dark-logo" alt="Logo-Dark"
                                width="150px" />
                            <img src="../assets/images/logos/logo-linkbit.png" class="light-logo"
                                alt="Logo-light"width="150px" />
                        </a>
                        <div class="d-none d-xl-flex align-items-center justify-content-center h-n80">
                            <img src="../assets/images/backgrounds/login-security.svg" alt="modernize-img"
                                class="img-fluid" width="500">
                        </div>
                    </div>
                    <div class="col-xl-5 col-xxl-4">
                        <div
                            class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
                            <div class="auth-max-width col-sm-8 col-md-6 col-xl-7 px-4">

                                <h2 class="mb-1 fs-7 fw-bolder">Welcome to Modernize</h2>
                                <img src="../assets/images/logos/logo-linkbit.png" class="light-logo"
                                    alt="Logo-light"width="150px" />
                                <p class="mb-7">Your Admin Dashboard d</p>
                                <h2 class="mb-1 fs-7 fw-bolder">


                                </h2>


                                <form action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control"
                                            id="exampleInputEmail1" aria-describedby="emailHelp">
                                    </div>
                                    <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control"
                                            id="exampleInputPassword1">
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input primary" type="checkbox" value=""
                                                id="flexCheckChecked" checked>
                                            <label class="form-check-label text-dark fs-3" for="flexCheckChecked">
                                                Remeber this Device
                                            </label>
                                        </div>
                                        <a class="text-primary fw-medium fs-3"
                                            href="{{ url('') }}/main/authentication-forgot-password.html">Forgot Password ?</a>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Sign
                                        In</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function handleColorTheme(e) {
                document.documentElement.setAttribute("data-color-theme", e);
            }
        </script>
        <button
            class="btn btn-primary p-3 rounded-circle d-flex align-items-center justify-content-center customizer-btn"
            type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
            aria-controls="offcanvasExample">
            <i class="icon ti ti-settings fs-7"></i>
        </button>

        <div class="offcanvas customizer offcanvas-end" tabindex="-1" id="offcanvasExample"
            aria-labelledby="offcanvasExampleLabel">
            <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
                <h4 class="offcanvas-title fw-semibold" id="offcanvasExampleLabel">
                    Settings
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body h-n80" data-simplebar>
                <h6 class="fw-semibold fs-4 mb-2">Theme</h6>

                <div class="d-flex flex-row gap-3 customizer-box" role="group">
                    <input type="radio" class="btn-check light-layout" name="theme-layout" id="light-layout"
                        autocomplete="off" />
                    <label class="btn p-9 btn-outline-primary rounded-2" for="light-layout">
                        <i class="icon ti ti-brightness-up fs-7 me-2"></i>Light
                    </label>

                    <input type="radio" class="btn-check dark-layout" name="theme-layout" id="dark-layout"
                        autocomplete="off" />
                    <label class="btn p-9 btn-outline-primary rounded-2" for="dark-layout">
                        <i class="icon ti ti-moon fs-7 me-2"></i>Dark
                    </label>
                </div>

                <h6 class="mt-5 fw-semibold fs-4 mb-2">Theme Direction</h6>
                <div class="d-flex flex-row gap-3 customizer-box" role="group">
                    <input type="radio" class="btn-check" name="direction-l" id="ltr-layout"
                        autocomplete="off" />
                    <label class="btn p-9 btn-outline-primary" for="ltr-layout">
                        <i class="icon ti ti-text-direction-ltr fs-7 me-2"></i>LTR
                    </label>

                    <input type="radio" class="btn-check" name="direction-l" id="rtl-layout"
                        autocomplete="off" />
                    <label class="btn p-9 btn-outline-primary" for="rtl-layout">
                        <i class="icon ti ti-text-direction-rtl fs-7 me-2"></i>RTL
                    </label>
                </div>

                <h6 class="mt-5 fw-semibold fs-4 mb-2">Theme Colors</h6>

                <div class="d-flex flex-row flex-wrap gap-3 customizer-box color-pallete" role="group">
                    <input type="radio" class="btn-check" name="color-theme-layout" id="Blue_Theme"
                        autocomplete="off" />
                    <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
                        onclick="handleColorTheme('Blue_Theme')" for="Blue_Theme" data-bs-toggle="tooltip"
                        data-bs-placement="top" data-bs-title="BLUE_THEME">
                        <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-1">
                            <i class="ti ti-check text-white d-flex icon fs-5"></i>
                        </div>
                    </label>

                    <input type="radio" class="btn-check" name="color-theme-layout" id="Aqua_Theme"
                        autocomplete="off" />
                    <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
                        onclick="handleColorTheme('Aqua_Theme')" for="Aqua_Theme" data-bs-toggle="tooltip"
                        data-bs-placement="top" data-bs-title="AQUA_THEME">
                        <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-2">
                            <i class="ti ti-check text-white d-flex icon fs-5"></i>
                        </div>
                    </label>

                    <input type="radio" class="btn-check" name="color-theme-layout" id="Purple_Theme"
                        autocomplete="off" />
                    <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
                        onclick="handleColorTheme('Purple_Theme')" for="Purple_Theme" data-bs-toggle="tooltip"
                        data-bs-placement="top" data-bs-title="PURPLE_THEME">
                        <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-3">
                            <i class="ti ti-check text-white d-flex icon fs-5"></i>
                        </div>
                    </label>

                    <input type="radio" class="btn-check" name="color-theme-layout" id="green-theme-layout"
                        autocomplete="off" />
                    <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
                        onclick="handleColorTheme('Green_Theme')" for="green-theme-layout" data-bs-toggle="tooltip"
                        data-bs-placement="top" data-bs-title="GREEN_THEME">
                        <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-4">
                            <i class="ti ti-check text-white d-flex icon fs-5"></i>
                        </div>
                    </label>

                    <input type="radio" class="btn-check" name="color-theme-layout" id="cyan-theme-layout"
                        autocomplete="off" />
                    <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
                        onclick="handleColorTheme('Cyan_Theme')" for="cyan-theme-layout" data-bs-toggle="tooltip"
                        data-bs-placement="top" data-bs-title="CYAN_THEME">
                        <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-5">
                            <i class="ti ti-check text-white d-flex icon fs-5"></i>
                        </div>
                    </label>

                    <input type="radio" class="btn-check" name="color-theme-layout" id="orange-theme-layout"
                        autocomplete="off" />
                    <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
                        onclick="handleColorTheme('Orange_Theme')" for="orange-theme-layout" data-bs-toggle="tooltip"
                        data-bs-placement="top" data-bs-title="ORANGE_THEME">
                        <div class="color-box rounded-circle d-flex align-items-center justify-content-center skin-6">
                            <i class="ti ti-check text-white d-flex icon fs-5"></i>
                        </div>
                    </label>
                </div>

                <h6 class="mt-5 fw-semibold fs-4 mb-2">Layout Type</h6>
                <div class="d-flex flex-row gap-3 customizer-box" role="group">
                    <div>
                        <input type="radio" class="btn-check" name="page-layout" id="vertical-layout"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary" for="vertical-layout">
                            <i class="icon ti ti-layout-sidebar-right fs-7 me-2"></i>Vertical
                        </label>
                    </div>
                    <div>
                        <input type="radio" class="btn-check" name="page-layout" id="horizontal-layout"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary" for="horizontal-layout">
                            <i class="icon ti ti-layout-navbar fs-7 me-2"></i>Horizontal
                        </label>
                    </div>
                </div>

                <h6 class="mt-5 fw-semibold fs-4 mb-2">Container Option</h6>

                <div class="d-flex flex-row gap-3 customizer-box" role="group">
                    <input type="radio" class="btn-check" name="layout" id="boxed-layout" autocomplete="off" />
                    <label class="btn p-9 btn-outline-primary" for="boxed-layout">
                        <i class="icon ti ti-layout-distribute-vertical fs-7 me-2"></i>Boxed
                    </label>

                    <input type="radio" class="btn-check" name="layout" id="full-layout" autocomplete="off" />
                    <label class="btn p-9 btn-outline-primary" for="full-layout">
                        <i class="icon ti ti-layout-distribute-horizontal fs-7 me-2"></i>Full
                    </label>
                </div>

                <h6 class="fw-semibold fs-4 mb-2 mt-5">Sidebar Type</h6>
                <div class="d-flex flex-row gap-3 customizer-box" role="group">
                    <a href="javascript:void(0)" class="fullsidebar">
                        <input type="radio" class="btn-check" name="sidebar-type" id="full-sidebar"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary" for="full-sidebar">
                            <i class="icon ti ti-layout-sidebar-right fs-7 me-2"></i>Full
                        </label>
                    </a>
                    <div>
                        <input type="radio" class="btn-check " name="sidebar-type" id="mini-sidebar"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary" for="mini-sidebar">
                            <i class="icon ti ti-layout-sidebar fs-7 me-2"></i>Collapse
                        </label>
                    </div>
                </div>

                <h6 class="mt-5 fw-semibold fs-4 mb-2">Card With</h6>

                <div class="d-flex flex-row gap-3 customizer-box" role="group">
                    <input type="radio" class="btn-check" name="card-layout" id="card-with-border"
                        autocomplete="off" />
                    <label class="btn p-9 btn-outline-primary" for="card-with-border">
                        <i class="icon ti ti-border-outer fs-7 me-2"></i>Border
                    </label>

                    <input type="radio" class="btn-check" name="card-layout" id="card-without-border"
                        autocomplete="off" />
                    <label class="btn p-9 btn-outline-primary" for="card-without-border">
                        <i class="icon ti ti-border-none fs-7 me-2"></i>Shadow
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="dark-transparent sidebartoggler"></div>
    <!-- Import Js Files -->
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="../assets/js/theme/app.init.js"></script>
    <script src="../assets/js/theme/theme.js"></script>
    <script src="../assets/js/theme/app.min.js"></script>


    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <script src="../assets/js/plugins/toastr-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="{{ asset('assets/js/plugins/toastr-init.js') }}"></script>
    <script src="./assets/js/vendor.min.js"></script>
    <!-- Import Js Files -->
    <script src="./assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="./assets/js/theme/app.init.js"></script>
    <script src="./assets/js/theme/theme.js"></script>
    <script src="./assets/js/theme/app.min.js"></script>
    <script src="./assets/js/theme/sidebarmenu.js"></script>

    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <script src="./assets/libs/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="./assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="./assets/js/dashboards/dashboard.js"></script>
    <script src="../assets/js/plugins/toastr-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        };

        @foreach (['success', 'error', 'info', 'warning'] as $msg)
            @if (session($msg))
                toastr.{{ $msg }}("{{ session($msg) }}");
            @endif
        @endforeach
    </script>



</body>

</html>
