<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>KARIB</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="{{asset('img/logo.svg')}}"
      type="image/x-icon"
    />

    <!-- Fonts and icons -->
    <script src="{{asset('js/plugin/webfont/webfont.min.js')}}"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["{{asset('css/fonts.min.css')}}"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/plugins.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/kaiadmin.min.css')}}" />

    {{-- <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="assets/css/demo.css" /> --}}

    @yield('meta')
  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="{{route('index')}}" class="logo">
              <img
                src="{{asset('img/logo_only.svg')}}"
                alt="navbar brand"
                class="navbar-brand"
                height="45"
              />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">

                <li class="nav-item {{ Request::path() ==  '/' ? 'active' : ''  }}">
                    <a href="{{route('index')}}">
                        <i class="fas fa-home"></i>
                        <p>Progress Penilaian</p>
                    </a>
                </li>
                
                
                @if(Auth::check())
                  @if (Auth::user()->role == 'Penilai')
                  <li class="nav-section">
                    <span class="sidebar-mini-icon">
                      <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Penilaian</h4>
                  </li>
                  {{-- Jika bukan Kepala BPS, maka bisa menilai --}}
                    @if (Auth::user()->id != 0)
                    <li class="nav-item {{ Request::path() ==  'penilaian' ? 'active' : ''  }}">
                      <a href="{{route('penilaian.index')}}">
                          <i class="fas fa-user-check"></i>
                          <p>Pegawai</p>
                      </a>
                    </li>
                    @endif

                  <!-- <li class="nav-item {{ Request::path() ==  'penilaian/ruangan' ? 'active' : ''  }}">
                    <a href="{{route('penilaian.ruangan.index')}}">
                        <i class="fas fa-clipboard-check"></i>
                        <p>Ruangan</p>
                    </a>
                  </li> -->
                  @endif
                  

                  @if (Auth::user()->role == 'Admin')
                  <li class="nav-item {{ Request::path() ==  'rekap' ? 'active' : ''  }}">
                    <a href="{{route('rekap')}}">
                        <i class="fas fa-clipboard-check"></i>
                        <p>Rekap</p>
                    </a>
                  </li>
                  <li class="nav-section">
                    <span class="sidebar-mini-icon">
                      <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Admin</h4>
                  </li>

                  <li class="nav-item {{ Request::path() ==  'pegawai' ? 'active' : ''  }}">
                    <a href="{{route('pegawai.index')}}">
                        <i class="fas fa-users"></i>
                        <p>Manajemen Pegawai</p>
                    </a>
                  </li>

                  <li class="nav-item {{ Request::path() ==  'ruangan' ? 'active' : ''  }}">
                    <a href="{{route('ruangan.index')}}">
                        <i class="fas fa-th-list"></i>
                        <p>Manajemen Ruangan</p>
                    </a>
                  </li>

                  <li class="nav-item {{ Request::path() ==  'user' ? 'active' : ''  }}">
                      <a href="{{route('user.index')}}">
                          <i class="fas fa-users-cog"></i>
                          <p>Manajemen Akun</p>
                      </a>
                  </li>
                  @endif
                @endif

                <li class="nav-section">
                  <span class="sidebar-mini-icon">
                    <i class="fa fa-ellipsis-h"></i>
                  </span>
                  <h4 class="text-section">TALAK</h4>
                </li>

                <li class="nav-item {{ str_contains(Request::path(), 'talak') && !str_contains(Request::path(), 'penilaian') ? 'active' : ''  }}">
                  <a href="{{route('talak.index')}}">
                      <i class="fas fa-trophy"></i>
                      <p>TALAK</p>
                  </a>
                </li>

                @if (Auth::check() && Auth::user()->role == 'Admin')
                <li class="nav-item {{ str_contains(Request::path(), 'penilaian-talak') ? 'active' : ''  }}">
                  <a href="{{route('penilaian-talak')}}">
                      <i class="fas fa-clipboard-check"></i>
                      <p>Penilaian TALAK</p>
                  </a>
                </li>
                @endif

                <li class="nav-section">
                  <span class="sidebar-mini-icon">
                    <i class="fa fa-ellipsis-h"></i>
                  </span>
                  <h4 class="text-section">ONAR</h4>
                </li>

                <li class="nav-item {{ str_contains(Request::path(), 'onar') && !str_contains(Request::path(), 'penilaian') ? 'active' : ''  }}">
                  <a href="{{route('onar.index')}}">
                      <i class="fas fa-trophy"></i>
                      <p>ONAR</p>
                  </a>
                </li>

                @if (Auth::check() && Auth::user()->role == 'Admin')
                <li class="nav-item {{ str_contains(Request::path(), 'penilaian-onar') ? 'active' : ''  }}">
                  <a href="{{route('penilaian-onar')}}">
                      <i class="fas fa-clipboard-check"></i>
                      <p>Penilaian ONAR</p>
                  </a>
                </li>
                @endif
            </ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->
      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
     
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
              <a href="index.html" class="logo">
                <img
                  src="{{asset('img/logo_only.svg')}}"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="20"
                />
              </a>
              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                  <i class="gg-menu-left"></i>
                </button>
              </div>
              <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
              </button>
            </div>
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
          <nav
            class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
          >
            <div class="container-fluid">

              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li class="nav-item topbar-user dropdown hidden-caret">
                  <a
                    class="dropdown-toggle profile-pic"
                    data-bs-toggle="dropdown"
                    href="#"
                    aria-expanded="false"
                  >
                    <div class="avatar-sm">
                      <img
                        src="{{asset('img/profile.jpg')}}"
                        alt="..."
                        class="avatar-img rounded-circle"
                      />
                    </div>
                    <span class="profile-username">
                      <span class="op-7">Hai,</span>
                      <span class="fw-bold">
                        @if(Auth::check())
                        {{Auth::user()->nama}}
                        @else
                        {{'Tamu'}}
                        @endif
                      </span>
                    </span>
                  </a>
                  <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                      <li>
                        <div class="user-box">
                          <div class="avatar-lg">
                            <img
                              src="{{asset('img/profile.jpg')}}"
                              alt="image profile"
                              class="avatar-img rounded"
                            />
                          </div>
                          <div class="u-text">
                            <h4>
                              @if(Auth::check()) {{Auth::user()->nama}} @else {{'Tamu'}} @endif
                            </h4>
                            <p class="text-muted">
                              @if(Auth::check()) {{Auth::user()->role}} @else {{'Tamu'}} @endif
                            </p>
                            {{-- <a
                              href="profile.html"
                              class="btn btn-xs btn-secondary btn-sm"
                              >View Profile</a
                            > --}}
                          </div>
                        </div>
                      </li>
                      <li>

                        <div class="dropdown-divider"></div>
                        @if (Auth::check())
                        <a class="dropdown-item" href="{{route('logout')}}">Logout</a>
                        @else
                        <a class="dropdown-item" href="{{route('login')}}">Login</a>
                        @endif
                      </li>
                    </div>
                  </ul>
                </li>
              </ul>

            </div>
          </nav>
          <!-- End Navbar -->
        </div>
        


        @yield('content')

        <footer class="footer">
          <div class="container-fluid d-flex justify-content-between">
            <nav class="pull-left">
              {{-- <ul class="nav">
                <li class="nav-item">
                  <a class="nav-link" href="http://www.themekita.com">
                    ThemeKita
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#"> Help </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#"> Licenses </a>
                </li>
              </ul> --}}
            </nav>
            <div class="copyright">
              2024, dikembangkan oleh
              <a href="https://wa.me/6282328839199">Zuhdi Ali Hisyam</a>
            </div>
            <div>
              Didesain oleh
              <a target="_blank" href="http://www.themekita.com">ThemeKita</a>.
            </div>
          </div>
        </footer>
      </div>

    </div>
    <!--   Core JS Files   -->
    <script src="{{asset('js/core/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('js/core/popper.min.js')}}"></script>
    <script src="{{asset('js/core/bootstrap.min.js')}}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{asset('js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>

    <!-- Chart JS -->
    <script src="{{asset('js/plugin/chart.js/chart.min.js')}}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{asset('js/plugin/jquery.sparkline/jquery.sparkline.min.js')}}"></script>

    <!-- Chart Circle -->
    <script src="{{asset('js/plugin/chart-circle/circles.min.js')}}"></script>

    <!-- Datatables -->
    <script src="{{asset('js/plugin/datatables/datatables.min.js')}}"></script>

    <!-- Bootstrap Notify -->
    <script src="{{asset('js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

    <!-- jQuery Vector Maps -->
    <script src="{{asset('js/plugin/jsvectormap/jsvectormap.min.js')}}"></script>
    <script src="{{asset('js/plugin/jsvectormap/world.js')}}"></script>

    <!-- Sweet Alert -->
    <script src="{{asset('js/plugin/sweetalert/sweetalert.min.js')}}"></script>

    <!-- Kaiadmin JS -->
    <script src="{{asset('js/kaiadmin.min.js')}}"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    {{-- <script src="assets/js/setting-demo.js"></script>
    <script src="assets/js/demo.js"></script> --}}
    <script>
      $(document).ready(function () {
        $("#basic-datatables").DataTable({});
        $("#basic-datatables-2").DataTable({});
        $("#basic-datatables-3").DataTable({});

        $("#multi-filter-select").DataTable({
          pageLength: 5,
          initComplete: function () {
            // Tambahkan baris filter di bawah header
            $("#multi-filter-select thead").append('<tr></tr>');
                var filterRow = $("#multi-filter-select thead tr").last();

            this.api()
              .columns()
              .every(function () {
                var column = this;

                // Tambahkan dropdown filter ke setiap kolom di baris filter
                var select = $('<select class="form-select"><option value=""></option></select>')
                            .appendTo($("<th></th>").appendTo(filterRow))
                            .on("change", function () {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());

                                column.search(val ? "^" + val + "$" : "", true, false).draw();
                            });

                column
                  .data()
                  .unique()
                  .sort()
                  .each(function (d, j) {
                    select.append(
                      '<option value="' + d + '">' + d + "</option>"
                    );
                  });
              });
          },
        });

        SessionSuccess.init();
      });
      //== Class definition
      var SessionSuccess = (function () {
        return {
          //== Init
          init: function () {
            @if(session('success'))
              swal({
                title: "Berhasil!",
                text: "{{ session('success') }}",
                type: "success",
                buttons: {
                  confirm: {
                    className: "btn btn-success",
                  },
                },
              });
            @endif

            @if(session('error'))
              swal({
                title: "Gagal!",
                text: "{{ session('error') }}",
                type: "error",
                buttons: {
                  confirm: {
                    className: "btn btn-danger",
                  },
                },
              });
            @endif
          },
        };
      })();
    </script>

    @yield('script')
  </body>
</html>
