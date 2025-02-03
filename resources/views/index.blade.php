@extends('layouts.app')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="container">
      <div class="page-inner">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Filter Penilaian</h4>
              </div>
              <div class="card-body">
                <ul class="nav nav-pills nav-secondary nav-pills-no-bd" id="pills-tab-without-border" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab-nobd" data-bs-toggle="pill" href="#pills-home-nobd" role="tab" aria-controls="pills-home-nobd" aria-selected="true">Mingguan</a>
                  </li>
                </ul>
                <div class="tab-content mt-2 mb-3" id="pills-without-border-tabContent">
                  <div class="tab-pane fade show active" id="pills-home-nobd" role="tabpanel" aria-labelledby="pills-home-tab-nobd">
                      <div class="form-group">
                        <label for="filter-mingguan">Pilih minggu penilaian:</label>
                        <select class="form-control" id="filter-mingguan" name="filter-mingguan">
                          @if(!$apakah_ada_penilaian)
                            <option value="{{ \Carbon\Carbon::now()->startOfWeek()->format('Y-m-d') }}">Minggu ini ({{ \Carbon\Carbon::now()->startOfWeek()->locale('id')->format('d M Y') }} s/d {{ \Carbon\Carbon::now()->endOfWeek()->locale('id')->format('d M Y') }})</option>
                          @endif
                          @foreach($filterMingguan as $minggu)
                            <?php 
                            $date = Carbon\Carbon::now();
                            $dateRaw = $date->setISODate($minggu->Tahun,$minggu->Minggu);
                            $date = ($date->setISODate($minggu->Tahun,$minggu->Minggu))->startOfWeek()->format('Y-m-d');
                            ?>
                            <option value="{{$date}}"> 
                              @if($dateRaw->isCurrentWeek())
                                Minggu sekarang ({{$dateRaw->startOfweek()->locale('id')->format('d M Y')}} s/d {{$dateRaw->endOfweek()->locale('id')->format('d M Y')}})
                              @else
                                Minggu {{$minggu->Minggu}}, Tahun {{$minggu->Tahun}} ({{$dateRaw->startOfweek()->locale('id')->format('d M Y')}} s/d {{$dateRaw->endOfweek()->locale('id')->format('d M Y')}})
                              @endif
                            </option>
                          @endforeach
                        </select>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- Progress penilaian pegawai --}}
          <div class="col col-lg-6">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Progress Penilaian Pegawai</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table
                    id="basic-datatables"
                    class="display table table-striped table-hover"
                  >
                    <thead>
                      <tr>
                        <th>Penilai</th>
                        <th>Jumlah Penilaian</th>
                        <th>Penilaian Yang Kurang</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($penilais as $p)
                        @if($p->id != 0)
                          <tr>
                            <th scope="row">{{$p->nama}}</th>
                            <td>{{$p->jumlah_penilaian}}</td>
                            <td>{{$jumlah_pegawai*3 - $p->jumlah_penilaian}}</td>
                          </tr>
                        @endif
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          {{-- Progress penilaian pegawai --}}
          <div class="col col-lg-6">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Progress Penilaian Ruangan</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table
                    id="basic-datatables-2"
                    class="display table table-striped table-hover"
                  >
                    <thead>
                      <tr>
                        <th>Penilai</th>
                        <th>Jumlah Penilaian</th>
                        <th>Jumlah Ruangan Belum Dinilai</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($penilais as $p)
                        <tr>
                          <th scope="row">{{$p->nama}}</th>
                          <td>{{$p->jumlah_penilaian_ruangan}}</td>
                          <td>{{$jumlah_ruangan - $p->jumlah_penilaian_ruangan}}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection

@section('script')
  <script>

$(document).ready(function () {
    $("#filter-mingguan").change(function () {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "POST",
            url: "{{route('filter-mingguan')}}",
            data: {
                tanggal_awal_mingguan: $("#filter-mingguan").val(),
            },
            success: function (msg) {
                const tableIds = [
                    "#basic-datatables",
                    "#basic-datatables-2"
                ];

                // Destroy and empty all tables
                tableIds.forEach((id) => {
                    $(id).DataTable().destroy();
                    $(`${id} tbody`).empty();
                });

                // Populate basic-datatables
                var jumlah_pegawai = @json($jumlah_pegawai);
                var jumlah_ruangan = @json($jumlah_ruangan);
                if (msg.penilais) {
                    msg.penilais.forEach(function (p) {
                        if (p.id != 0) {
                          $("#basic-datatables tbody").append(`
                            <tr>
                              <th scope="row">${p.nama}</th>
                              <td>${p.jumlah_penilaian}</td>
                              <td>${jumlah_pegawai*3 - p.jumlah_penilaian}</td>
                            </tr>
                          `);
                        }
                        $("#basic-datatables-2 tbody").append(`
                            <tr>
                                <th scope="row">${p.nama}</th>
                                <td>${p.jumlah_penilaian_ruangan}</td>
                                <td>${jumlah_ruangan - p.jumlah_penilaian_ruangan}</td>
                            </tr>
                        `);
                    });
                }

                

                // Reinitialize DataTables
                tableIds.forEach((id) => {
                    $(id).DataTable();
                });
            },
            error: function (msg) {
                console.log(msg);
            },
        });
    });
});

  </script>
@endsection