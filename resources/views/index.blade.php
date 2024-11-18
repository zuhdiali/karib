@extends('layouts.app')

@section('content')
    <div class="container">
      <div class="page-inner">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Rekap Penilaian Minggu Ini</h4>
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
        </div>
      </div>
    </div>
@endsection