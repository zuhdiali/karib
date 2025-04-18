@extends('layouts.app')

@section('content')

<div class="container">
  <div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4" >
      <div>
        <h3 class="fw-bold mb-3">Penilaian TALAK</h3>
        <h6 class="op-7 mb-2">Riwayat Penilaian TALAK (Triwulan BerAKHLAK)</h6>
      </div>
      <div class="ms-md-auto py-2 py-md-0">
        {{-- <a href="{{route('talak.create')}}" class="btn btn-primary btn-round">Tambah TALAK</a> --}}
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div
                  class="icon-big text-center icon-success bubble-shadow-small"
                >
                <i class="fas fa-clipboard-check"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">
                      Jumlah Penilaian TALAK
                  </p>
                  <h4 class="card-title">{{$totalPenilaianTalak}}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Daftar TALAK</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table
                id="multi-filter-select"
                class="display table table-striped table-hover"
              >
                <thead>
                  <tr>
                    <th>Aksi</th>
                    <th>Nama TALAK</th>
                    <th>Penilai</th>
                    <th>Nominasi</th>
                    <th>Total Nilai</th>
                    <th>Berorientasi Layanan</th>
                    <th>Akuntabel</th>
                    <th>Kompeten</th>
                    <th>Harmonis</th>
                    <th>Loyal</th>
                    <th>Adaptif</th>
                    <th>Kolaboratif</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Aksi</th>
                    <th>Nama TALAK</th>
                    <th>Penilai</th>
                    <th>Nominasi</th>
                    <th>Total Nilai</th>
                    <th>Berorientasi Layanan</th>
                    <th>Akuntabel</th>
                    <th>Kompeten</th>
                    <th>Harmonis</th>
                    <th>Loyal</th>
                    <th>Adaptif</th>
                    <th>Kolaboratif</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach($penilaianTalaks as $penilaian)
                    <!-- Modal -->
                    <div class="modal fade" id="{{'exampleModal'.$penilaian->id}}" tabindex="-1" aria-labelledby="{{'exampleModalLabel'.$penilaian->id}}" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5" id="{{'exampleModalLabel'.$penilaian->id}}">Hapus Penilaian TALAK</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            Apakah Anda yakin ingin menghapus <strong>{{$penilaian->id_pegawai}}</strong> ?
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                            <form action="{{url('penilaian-talak/destroy/'.$penilaian->id)}}">
                              <button type="submit" class="btn btn-danger">Hapus Penilaian TALAK</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <tr>
                      <td>
                        <div class="form-button-action">
                          <form action="{{url('penilaian-talak/edit', $penilaian->id)}}">
                            <button
                              type="submit"
                              data-bs-toggle="tooltip"
                              title=""
                              class="btn btn-link btn-primary btn-lg"
                              data-original-title="Edit Penilaian TALAK"
                            >
                            <i class="fa fa-edit"></i>
                          </form>
                          </button>

                          <button
                            type="button"
                            title="Hapus"
                            class="btn btn-link btn-danger"
                            data-bs-toggle="modal" 
                            data-bs-target="{{'#exampleModal'.$penilaian->id}}"
                            data-original-title="Hapus"
                          >
                            <i class="fa fa-times"></i>
                          </button>
                        </div>
                      </td>
                      {{-- {{dd($penilaianTalaks)}} --}}
                        <th scope="row">{{$penilaian->nominasiTalak->talak->nama}}</th>
                        <td>{{$penilaian->penilai->nama}}</td>
                        <td>{{$penilaian->nominasiTalak->pegawai->nama}}</td>
                        <td>{{$penilaian->total_nilai}}</td>
                        <td>{{$penilaian->orientasi_layanan}}</td>
                        <td>{{$penilaian->akuntabel}}</td>
                        <td>{{$penilaian->kompeten}}</td>
                        <td>{{$penilaian->harmonis}}</td>
                        <td>{{$penilaian->loyal}}</td>
                        <td>{{$penilaian->adaptif}}</td>
                        <td>{{$penilaian->kolaboratif}}</td>
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
