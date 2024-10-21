<!DOCTYPE html>
<!-- beautify ignore:start -->
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{{asset('assets/')}}" data-template="vertical-menu-template-free">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" /> 
        <title>Dashboard - 24x7 PG</title> 
        <meta name="description" content="" /> 
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{asset('/public/favicon.png')}}" /> 
        <!-- Fonts -->

        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet"/>
        <!-- Icons. Uncomment required icon fonts -->
        <link rel="stylesheet" href="{{asset('public/assets/vendor/fonts/boxicons.css')}}" />

        <!-- Core CSS -->
        <link rel="stylesheet" href="{{asset('public/assets/vendor/css/core.css')}}" class="template-customizer-core-css" />
        <link rel="stylesheet" href="{{asset('public/assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
        <link rel="stylesheet" href="{{asset('public/assets/css/demo.css')}}" />

        <!-- Vendors CSS -->
        <link rel="stylesheet" href="{{asset('public/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" /> 
        <link rel="stylesheet" href="{{asset('public/assets/vendor/libs/apex-charts/apex-charts.css')}}" /> 
        <!-- Page CSS -->

        <!-- Helpers -->
        <script src="{{asset('public/assets/vendor/js/helpers.js')}}"></script> 
        <script src="{{asset('public/assets/js/config.js')}}"></script>

        <!-- Jquery & axios cdn ------->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

        <!-- include summernote css/js -->
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

        <!-- include plugin -->
        <script src="[folder where script is located]/[plugin script].js"></script>
        <style>
            body {
                font-family: 'New Font', sans-serif;
                /*font-size: 15px;
                font-family: math;
                font-variant: all-small-caps;*/
            }
            .table{
                color:black;
            }
            @media (max-width: 768px) {
                .hide-on-mobile {
                    display: none;
                }
            }
        </style>

    </head>

    <body>
        <!-- Layout wrapper -->
        <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <!-- Menu -->
            @include('Admin.sidebar')
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar --> 
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                        <i class="bx bx-menu bx-sm"></i>
                    </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                    <!-- Search -->
                    <div class="navbar-nav align-items-center">
                        <h6 class="m-0">24x7 Payment Gateway Admin-Panel</h6>
                    </div>

                    @if(Auth::guard('user')->user()->role == 'warehousemanager' || Auth::guard('user')->user()->role == 'user')
                    @php
                        $agent = App\Models\Agent::where('id',Auth::guard('user')->user()->id)->first();
                    @endphp
                    <div class="navbar-nav align-items-center mx-5 hide-on-mobile">
                        Auth Key-  <h6 class="m-0" id="myText">{{$agent->password}}</h6>
                        <button class="btn btn-sm btn-success mx-3 copyBtn"  onclick="copyContent()">Copy</button>
                    </div>
                    @else
                    <h6 class="m-0" id="myText"></h6>
                    @endif
                    <!-- /Search -->
                    
                    <ul class="navbar-nav flex-row align-items-center ms-auto">
                        <!-- Place this tag where you want the button to render. -->
                        <li class="nav-item lh-1 me-3"></li>

                        <!-- User -->
                        <li class="nav-item navbar-dropdown dropdown-user dropdown">
                        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                            <div class="avatar avatar-online">
                            <img src="{{asset('public/assets/img/avatars/1.png')}}" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                    <img src="{{asset('public/assets/img/avatars/1.png')}}" alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block">{{Auth::guard('user')->user()->name}}</span>
                                    <small class="text-muted">{{Auth::guard('user')->user()->role == 'warehousemanager' ? 'company login' : 'Admin Login'}}</small>
                                </div>
                                </div>
                            </a>
                            </li>
                            <li>
                            <div class="dropdown-divider"></div>
                            </li>
                            {{-- <li>
                            <a class="dropdown-item" href="#">
                                <i class="bx bx-user me-2"></i>
                                <span class="align-middle">My Profile</span>
                            </a>
                            </li> --}}
                            {{-- <li>
                            <div class="dropdown-divider"></div>
                            </li> --}}
                            <li>
                            <a class="dropdown-item" href="{{route('logout')}}">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">Log Out</span>
                            </a>
                            </li>
                        </ul>
                        </li>
                        <!--/ User -->
                    </ul>
                    </div>
                </nav> 
                <!-- / Navbar -->
                <main style="height: 82%;">
                    @yield('content') 
                </main>

                {{-- @include('Admin.Modal.modal') --}}

                <!-- Footer -->
                <footer class="content-footer footer bg-footer-theme">
                    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                        <div class="mb-2 mb-md-0">
                        ©
                        <script>
                            document.write(new Date().getFullYear());
                        </script>
                        , made with ❤️ by
                        <a href="# " target="_blank" class="footer-link fw-bolder">Atomic</a>
                        </div>
                        <div>
                        </div>
                    </div>
                </footer>
                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
        </div>
        <!-- build:js assets/vendor/js/core.js -->
        <script src="{{asset('public/assets/vendor/libs/jquery/jquery.js')}}"></script>
        <script src="{{asset('public/assets/vendor/libs/popper/popper.js')}}"></script>
        <script src="{{asset('public/assets/vendor/js/bootstrap.js')}}"></script>
        <script src="{{asset('public/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>

        <script src="{{asset('public/assets/vendor/js/menu.js')}}"></script>
        <!-- endbuild -->

        <!-- Vendors JS -->
        <script src="{{asset('public/assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>

        <!-- Main JS -->
        <script src="{{asset('public/assets/js/main.js')}}"></script>

        <!-- Page JS -->
        <script src="{{asset('public/assets/js/dashboards-analytics.js')}}"></script>

        <!-- Place this tag in your head or just before your close body tag. -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <script>
            setTimeout(function(){
                $('.alert-success,.alert-danger').remove();
            },5000);
        </script>
        <script>
            let text = document.getElementById('myText').innerHTML;
            const copyContent = async () => {
                try {
                await navigator.clipboard.writeText(text);
                console.log('Content copied to clipboard');
                $('.copyBtn').html('copied !');

                setTimeout(function(){
                    $('.copyBtn').html('copy');
                },3000);
                } catch (err) {
                console.error('Failed to copy: ', err);
                }
            }
        </script>
    </body>
</html>
