@extends('layouts.app')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Filter Penilaian</h4>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-pills nav-secondary nav-pills-no-bd" id="pills-tab-without-border"
                                role="tablist">
                                <li class="nav-item opsi-mingguan-klik">
                                    <a class="nav-link active" id="opsi-mingguan" data-bs-toggle="pill"
                                        href="#pills-home-nobd" role="tab" aria-controls="pills-home-nobd"
                                        aria-selected="true">Mingguan</a>
                                </li>
                                <li class="nav-item opsi-bulanan-klik">
                                    <a class="nav-link" id="opsi-bulanan" data-bs-toggle="pill" href="#pills-profile-nobd"
                                        role="tab" aria-controls="pills-profile-nobd" aria-selected="false">Bulanan</a>
                                </li>
                                <li class="nav-item opsi-triwulanan-klik">
                                    <a class="nav-link" id="opsi-triwulanan" data-bs-toggle="pill"
                                        href="#pills-contact-nobd" role="tab" aria-controls="pills-contact-nobd"
                                        aria-selected="false">Triwulanan</a>
                                </li>
                            </ul>
                            <div class="tab-content mt-2 mb-3" id="pills-without-border-tabContent">
                                <div class="tab-pane fade show active" id="pills-home-nobd" role="tabpanel"
                                    aria-labelledby="opsi-mingguan">
                                    {{-- <form action="{{route('filter-mingguan')}}" method="POST">
                      @csrf --}}
                                    <div class="form-group">
                                        <label for="filter-mingguan">Filter mingguan:</label>
                                        <select class="form-control" id="filter-mingguan" name="filter-mingguan">
                                            <option value="">-- Pilih Minggu ---</option>
                                            @if (count($penilaians) == 0)
                                                <option value="{{ \Carbon\Carbon::now()->startOfWeek()->format('Y-m-d') }}"
                                                    selected>Minggu ini
                                                    ({{ \Carbon\Carbon::now()->startOfWeek()->locale('id')->format('d M') }}
                                                    - {{ \Carbon\Carbon::now()->endOfWeek()->locale('id')->format('d M') }})
                                                </option>
                                            @endif
                                            @foreach ($filterMingguan as $minggu)
                                                <?php
                                                $date = Carbon\Carbon::now();
                                                $dateRaw = $date->setISODate($minggu->Tahun, $minggu->Minggu);
                                                $date = $date->setISODate($minggu->Tahun, $minggu->Minggu)->startOfWeek()->format('Y-m-d');
                                                ?>
                                                @if ($dateRaw->isCurrentWeek())
                                                    <option
                                                        value="{{ Carbon\Carbon::now()->startOfWeek()->format('Y-m-d') }}"
                                                        selected>Minggu Sekarang
                                                        ({{ $dateRaw->startOfweek()->locale('id')->format('d M Y') }} s/d
                                                        {{ $dateRaw->endOfweek()->locale('id')->format('d M Y') }})
                                                    </option>
                                                @else
                                                    <option value="{{ $date }}"> Minggu {{ $minggu->Minggu }}, Tahun
                                                        {{ $minggu->Tahun }}
                                                        ({{ $dateRaw->startOfweek()->locale('id')->format('d M') }} -
                                                        {{ $dateRaw->endOfweek()->locale('id')->format('d M') }})</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- <hr /> --}}
                                </div>
                                <div class="tab-pane fade" id="pills-profile-nobd" role="tabpanel"
                                    aria-labelledby="opsi-bulanan">
                                    <div class="form-group">
                                        <label for="filter-bulanan">Filter bulanan:</label>
                                        <select class="form-control" id="filter-bulanan">
                                            <option value="">-- Pilih Bulan ---</option>
                                            @foreach ($filterBulanan as $bulan)
                                                <?php
                                                $dateRaw = Carbon\Carbon::create($bulan->Tahun, $bulan->Bulan, 1);
                                                $date = $dateRaw->format('Y-m-01');
                                                ?>
                                                <option value="{{ $date }}">
                                                    {{ $dateRaw->locale('id')->translatedFormat('F Y') }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-contact-nobd" role="tabpanel"
                                    aria-labelledby="opsi-triwulanan">
                                    <div class="form-group">
                                        <label for="filter-triwulan">Filter triwulan:</label>
                                        <select class="form-control" id="filter-triwulan">
                                            <option value="">-- Pilih Triwulan ---</option>
                                            @foreach ($filterTriwulanan as $triwulan)
                                                <?php
                                                $dateRaw = Carbon\Carbon::create($triwulan->Tahun, $triwulan->Triwulan * 3 - 2, 1);
                                                $date = $dateRaw->format('Y-m-01');
                                                ?>
                                                <option value="{{ $date }}">Triwulan {{ $triwulan->Triwulan }},
                                                    Tahun {{ $triwulan->Tahun }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{-- <h5>Juara Ruangan: <strong class="juara_ruangan_mingguan_nama">{{$nilai_ruang_tinggi_nama}}</strong></h5>
                <h5>Nilai: <strong class="juara_ruangan_mingguan">{{$nilai_ruang_tinggi}}</strong></h5>
                <hr />
                <h5>Juara Pegawai: <strong class="juara_pegawai_mingguan_nama">{{$nilai_pegawai_tinggi_nama}}</strong></h5>
                <h5>Nilai: <strong class="juara_pegawai_mingguan">{{$nilai_pegawai_tinggi}}</strong></h5> --}}
                        </div>
                    </div>
                </div>

                {{-- Rekap Juara Per Ruangan --}}
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Rekap Juara Per Ruangan</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="basic-datatables-2" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Ruangan</th>
                                            <th>Nama Pemenang</th>
                                            {{-- <th>Keindahan</th>
                        <th>Kebersihan</th> --}}
                                            <th>Total Nilai</th>
                                            {{-- <th>Nilai rata-rata Pegawai</th>
                        <th>Nilai Akhir</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($penilaian_ruangans as $nilai)
                                            <tr>
                                                <th scope="row">{{ $nilai->ruangan->nama }}</th>
                                                <td>{{ $nilai->juara_ruangan->nama }}</td>
                                                {{-- <td>{{$nilai->rerata_keindahan}}</td>
                          <td>{{$nilai->rerata_kebersihan}}</td> --}}
                                                <td>{{ $nilai->juara_ruangan->nilai }}</td>
                                                {{-- <td>{{$nilai->rerata_pegawai->rerata_nilai}}</td>
                          <td>{{$nilai->nilai_akhir}}</td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Rekap Penilaian Ruangan Lama --}}
                {{-- <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Rekap Penilaian Ruangan</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table
                    id="basic-datatables-2"
                    class="display table table-striped table-hover"
                  >
                    <thead>
                      <tr>
                        <th>Ruangan</th>
                        <th>Kerapian</th>
                        <th>Keindahan</th>
                        <th>Kebersihan</th>
                        <th>Total Nilai</th>
                        <th>Nilai rata-rata Pegawai</th>
                        <th>Nilai Akhir</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($penilaian_ruangans as $nilai)
                        <tr>
                          <th scope="row">{{$nilai->ruangan->nama}}</th>
                          <td>{{$nilai->rerata_kerapian}}</td>
                          <td>{{$nilai->rerata_keindahan}}</td>
                          <td>{{$nilai->rerata_kebersihan}}</td>
                          <td>{{$nilai->rerata_total_nilai}}</td>
                          <td>{{$nilai->rerata_pegawai->rerata_nilai}}</td>
                          <td>{{$nilai->nilai_akhir}}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div> --}}

                {{-- Rekap Penilaian Pegawai --}}
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Rekap Penilaian Pegawai</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="basic-datatables" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Pegawai</th>
                                            <th>Kerapian</th>
                                            <th>Keindahan</th>
                                            <th>Kebersihan</th>
                                            {{-- <th>Penampilan</th> --}}
                                            <th>Total Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($penilaians as $nilai)
                                            <tr>
                                                <th scope="row">{{ $nilai->pegawai->nama }}</th>
                                                <td>{{ $nilai->rerata_kerapian }}</td>
                                                <td>{{ $nilai->rerata_keindahan }}</td>
                                                <td>{{ $nilai->rerata_kebersihan }}</td>
                                                {{-- <td>{{$nilai->rerata_penampilan}}</td> --}}
                                                <td>{{ $nilai->rerata_total_nilai }}</td>
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
        $(document).ready(function() {

            function populate(msg) {
                console.log(msg);
                const tableIds = [
                    "#basic-datatables",
                    "#basic-datatables-2",
                ];

                // Destroy and empty all tables
                tableIds.forEach((id) => {
                    $(id).DataTable().destroy();
                    $(`${id} tbody`).empty();
                });

                // Populate multi-filter-select
                if (msg.penilaians) {
                    msg.penilaians.forEach(function(nilai) {
                        $("#basic-datatables tbody").append(`
                <tr>
                  <th scope="row">${nilai.pegawai.nama}</th>
                  <td>${nilai.rerata_kerapian}</td>
                  <td>${nilai.rerata_keindahan}</td>
                  <td>${nilai.rerata_kebersihan}</td>
                  <td>${nilai.rerata_total_nilai}</td>
                </tr>
              `);
                    });
                }

                // Populate basic-data-tables-3
                if (msg.penilaian_ruangans) {
                    msg.penilaian_ruangans.forEach(function(nilai) {
                        if (!nilai.juara_ruangan) {
                            nilai.juara_ruangan = {
                                nama: '-',
                                nilai: '-'
                            };
                        };
                        $("#basic-datatables-2 tbody").append(`
                <tr>
                  <th scope="row">${nilai.ruangan.nama}</th>
                  <td>${nilai.juara_ruangan.nama}</td>
                  <td>${nilai.juara_ruangan.nilai}</td>
                </tr>
              `);
                    });
                }

                // Reinitialize DataTables
                tableIds.forEach((id) => {
                    $(id).DataTable({});
                });

                // Update juara ruangan
                $(".juara_ruangan_mingguan_nama ").text(`${msg.nilai_ruang_tinggi_nama}`);
                $(".juara_ruangan_mingguan ").text(`${msg.nilai_ruang_tinggi}`);

                // Update juara pegawai
                $(".juara_pegawai_mingguan_nama ").text(`${msg.nilai_pegawai_tinggi_nama}`);
                $(".juara_pegawai_mingguan ").text(`${msg.nilai_pegawai_tinggi}`);
            }

            function kosonginTabel() {
                const tableIds = [
                    "#basic-datatables",
                    "#basic-datatables-2",
                ];

                tableIds.forEach((id) => {
                    $(id).DataTable().destroy();
                    $(`${id} tbody`).empty();
                });

                // Reinitialize DataTables
                tableIds.forEach((id) => {
                    $(id).DataTable({});
                });

            }

            $("#filter-mingguan").change(function() {
                if ($("#filter-mingguan").val() != "") {
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        type: "POST",
                        url: "{{ route('rekap-mingguan') }}",
                        data: {
                            tanggal_awal_mingguan: $("#filter-mingguan").val(),
                        },
                        success: function(msg) {
                            populate(msg);
                        },
                        error: function(msg) {
                            console.log(msg);
                        },
                    });
                }
            });

            $("#filter-bulanan").change(function() {
                if ($("#filter-bulanan").val() != "") {
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        type: "POST",
                        url: "{{ route('rekap-bulanan') }}",
                        data: {
                            tanggal_awal_bulanan: $("#filter-bulanan").val(),
                        },
                        success: function(msg) {
                            populate(msg);
                        },
                        error: function(msg) {
                            console.log(msg);
                        },
                    });
                }
            })

            $("#filter-triwulan").change(function() {
                if ($("#filter-triwulan").val() != "") {
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        type: "POST",
                        url: "{{ route('rekap-triwulan') }}",
                        data: {
                            tanggal_awal_triwulan: $("#filter-triwulan").val(),
                        },
                        success: function(msg) {
                            populate(msg);
                        },
                        error: function(msg) {
                            console.log(msg);
                        },
                    })
                }
            })
        });
    </script>
@endsection
