@extends('layouts.app')

@section('content')
    <div class="container">
      <div class="page-inner">
        <div class="row">
          
          {{-- Progress penilaian pegawai --}}
          <div class="col col-lg-6">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Progress Penilaian Pegawai Minggu Ini</h4>
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
                        <th>Jumlah Pegawai Belum Dinilai</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($penilais as $p)
                        @if($p->id != 0)
                          <tr>
                            <th scope="row">{{$p->nama}}</th>
                            <td>{{$p->jumlah_penilaian}}</td>
                            <td>{{$jumlah_pegawai - $p->jumlah_penilaian}}</td>
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
                <h4 class="card-title">Progress Penilaian Ruangan Minggu Ini</h4>
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
          
          {{-- Rekap Penilaian Pegawai --}}
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Rekap Penilaian Pegawai Minggu Ini</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table
                    id="multi-filter-select"
                    class="display table table-striped table-hover"
                  >
                    <thead>
                      <tr>
                        <th>Pegawai</th>
                        <th>Kerapian</th>
                        <th>Keindahan</th>
                        <th>Kebersihan</th>
                        <th>Penampilan</th>
                        <th>Total Nilai</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Pegawai</th>
                        <th>Kerapian</th>
                        <th>Keindahan</th>
                        <th>Kebersihan</th>
                        <th>Penampilan</th>
                        <th>Total Nilai</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      @foreach($penilaians as $nilai)
                        <tr>
                          <th scope="row">{{$nilai->pegawai->nama}}</th>
                          <td>{{$nilai->rerata_kerapian}}</td>
                          <td>{{$nilai->rerata_keindahan}}</td>
                          <td>{{$nilai->rerata_kebersihan}}</td>
                          <td>{{$nilai->rerata_penampilan}}</td>
                          <td>{{$nilai->rerata_total_nilai}}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
            
          {{-- Rekap Penilaian Ruangan --}}
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Rekap Penilaian Ruangan Minggu Ini</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table
                    id="basic-data-tables-3"
                    class="display table table-striped table-hover"
                  >
                    <thead>
                      <tr>
                        <th>Ruangan</th>
                        <th>Kerapian</th>
                        <th>Keindahan</th>
                        <th>Kebersihan</th>
                        <th>Total Nilai</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($penilaian_ruangans as $nilai)
                        <tr>
                          <th scope="row">{{$nilai->ruangan->nama}}</th>
                          <td>{{$nilai->rerata_kerapian}}</td>
                          <td>{{$nilai->rerata_keindahan}}</td>
                          <td>{{$nilai->rerata_kebersihan}}</td>
                          <td>{{$nilai->rerata_total_nilai}}</td>
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