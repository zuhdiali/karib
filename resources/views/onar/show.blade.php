@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Penilaian {{$onar->nama}}</h4>
                  </div>
                  <div class="card-body">
                    <ul class="nav nav-pills nav-secondary nav-pills-no-bd" id="pills-tab-without-border" role="tablist">
                      <li class="nav-item progress-klik">
                        <a class="nav-link active" id="progress" data-bs-toggle="pill" href="#pills-home-nobd" role="tab" aria-controls="pills-home-nobd" aria-selected="true">Progress</a>
                      </li>
                      <li class="nav-item hasil-klik">
                        <a class="nav-link" id="hasil" data-bs-toggle="pill" href="#pills-profile-nobd" role="tab" aria-controls="pills-profile-nobd" aria-selected="false">Hasil</a>
                      </li>
                    </ul>
                    <div class="tab-content mt-2 mb-3" id="pills-without-border-tabContent">
                      <div class="tab-pane fade show active" id="pills-home-nobd" role="tabpanel" aria-labelledby="progress">
                        <hr />
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Progress Penilaian</h4>
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
                                                  <th>Status Penilaian</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                                @foreach($pegawais as $p)
                                                    <tr>
                                                      <td scope="row">{{$p->nama}}</td>
                                                      <td>
                                                        @if( in_array($p->id, $arrayYangSudahMenilai)) 
                                                        <div class="icon-big text-center text-success bubble-shadow-small" >   
                                                            <i class="fas fa-check-circle"></i>
                                                        </div>
                                                        @else
                                                        <div class="icon-big text-center text-danger bubble-shadow-small" >   
                                                            <i class="fas fa-times-circle"></i>
                                                        </div>
                                                        @endif
                                                    </td>
                                                      {{-- <td>{{$p->nominasiOnar->outsourcing->nama}}</td> --}}
                                                    </tr>
                                                @endforeach
                                              </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Riwayat Penilaian</h4>
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
                                                  <th>Nominasi Yang Dinilai</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                                @foreach($penilaianOnars as $p)
                                                    <tr>
                                                      <td scope="row">{{$p->penilai->nama}}</td>
                                                      <td>{{$p->nominasiOnar->outsourcing->nama}}</td>
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
                      <div class="tab-pane fade" id="pills-profile-nobd" role="tabpanel" aria-labelledby="hasil">
                        <hr />
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title"> Hasil Penilaian</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table
                                              id="basic-datatables-3"
                                              class="display table table-striped table-hover"
                                            >
                                              <thead>
                                                <tr>
                                                  <th>Nominasi</th>
                                                  <th>Total Nilai</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                                @foreach($data as $d)
                                                    <tr>
                                                      <td scope="row">{{$d->nama}}</td>
                                                      <td>{{$d->total_nilai}}</td>
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
                  </div>
                </div>
              </div>
        </div>
    </div>
</div>
@endsection