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
      href="{{asset('img/logo_only.png')}}"
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
                src="{{asset('img/logo_blederan.png')}}"
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
                        <p>Beranda</p>
                    </a>
                </li>

                @if (Auth::check() && (Auth::user()->role == 'Penilai'))
                <li class="nav-section">
                  <span class="sidebar-mini-icon">
                    <i class="fa fa-ellipsis-h"></i>
                  </span>
                  <h4 class="text-section">Penilaian</h4>
                </li>

                <li class="nav-item {{ Request::path() ==  'penilaian' ? 'active' : ''  }}">
                  <a href="{{route('penilaian.index')}}">
                      <i class="fas fa-user-check"></i>
                      <p>Pegawai</p>
                  </a>
                </li>

                <li class="nav-item {{ Request::path() ==  'penilaian/ruangan' ? 'active' : ''  }}">
                  <a href="{{route('penilaian.ruangan.index')}}">
                      <i class="fas fa-user-check"></i>
                      <p>Ruangan</p>
                  </a>
                </li>
                {{-- @endif --}}

                {{-- @if (Auth::check() && (Auth::user()->role == 'Admin')) --}}
                
                <li class="nav-section">
                  <span class="sidebar-mini-icon">
                    <i class="fa fa-ellipsis-h"></i>
                  </span>
                  <h4 class="text-section">Manajemen</h4>
                </li>

                <li class="nav-item {{ Request::path() ==  'pegawai' ? 'active' : ''  }}">
                  <a href="{{route('pegawai.index')}}">
                      <i class="fas fa-users"></i>
                      <p>Manajemen Pegawai</p>
                  </a>
              </li>

                <li class="nav-item {{ Request::path() ==  'user' ? 'active' : ''  }}">
                    <a href="{{route('user.index')}}">
                        <i class="fas fa-users"></i>
                        <p>Manajemen Pengguna</p>
                    </a>
                </li>
                @endif

                {{-- <li class="nav-item {{ Request::path() ==  'admin-akomodasi' ? 'active' : ''  }}">
                  <a href="{{route('admin-akomodasi')}}">
                      <i class="fas fa-home"></i>
                      <p>Akomodasi</p>
                  </a>
                </li> --}}
                {{-- <li class="nav-section">
                  <span class="sidebar-mini-icon">
                    <i class="fa fa-ellipsis-h"></i>
                  </span>
                  <h4 class="text-section">Informasi {{ getenv('NAMA_DESA') }}</h4>
                </li> --}}
                {{-- <li class="nav-item {{ Request::path() ==  'admin-kabar' ? 'active' : ''  }}">
                  <a href="{{route('admin-kabar')}}">
                      <i class="fas fa-globe"></i>
                      <p>Kabar</p>
                  </a>
                </li> --}}
                {{-- <li class="nav-item {{ Request::path() ==  'admin-eduwisata' ? 'active' : ''  }}">
                  <a href="{{route('admin-eduwisata')}}">
                      <i class="fas fa-graduation-cap"></i>
                      <p>Eduwisata</p>
                  </a>
                </li> --}}

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
                  src="{{asset('img/logo_blederan.png')}}"
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
                      <span class="op-7">Hi,</span>
                      <span class="fw-bold">
                        {{Auth::user()->nama}}
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
                              {{Auth::user()->nama}}
                            </h4>
                            <p class="text-muted">
                              {{Auth::user()->role}}
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
                        <a class="dropdown-item" href="{{route('logout')}}">Logout</a>
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

        $("#multi-filter-select").DataTable({
          pageLength: 5,
          initComplete: function () {
            this.api()
              .columns()
              .every(function () {
                var column = this;
                var select = $(
                  '<select class="form-select"><option value=""></option></select>'
                )
                  .appendTo($(column.footer()).empty())
                  .on("change", function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column
                      .search(val ? "^" + val + "$" : "", true, false)
                      .draw();
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

        // Add Row
        $("#add-row").DataTable({
          pageLength: 5,
        });

        var action =
          '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

        $("#addRowButton").click(function () {
          $("#add-row")
            .dataTable()
            .fnAddData([
              $("#addName").val(),
              $("#addPosition").val(),
              $("#addOffice").val(),
              action,
            ]);
          $("#addRowModal").modal("hide");
        });
      });
    </script>
  </body>
</html>
