@extends('layouts.app')

@section('content')

<div class="container">
  <div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4" >
      <div>
        <h3 class="fw-bold mb-3">Penilaian ONAR</h3>
        <h6 class="op-7 mb-2">Riwayat Penilaian ONAR (Outsourcing Bersinar)</h6>
      </div>
      <div class="ms-md-auto py-2 py-md-0">
        {{-- <a href="{{route('onar.create')}}" class="btn btn-primary btn-round">Tambah ONAR</a> --}}
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
                      Jumlah Penilaian ONAR
                  </p>
                  <h4 class="card-title">{{$totalPenilaianOnar}}</h4>
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
            <h4 class="card-title">Daftar ONAR</h4>
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
                    <th>Nama ONAR</th>
                    <th>Penilai</th>
                    <th>Nominasi</th>
                    <th>Total Nilai</th>
                    <th>Tanggung Jawab</th>
                    <th>Disiplin</th>
                    <th>Loyal</th>
                    <th>Ramah</th>
                    <th>Melayani</th>
                    <th>Cekatan</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Aksi</th>
                    <th>Nama ONAR</th>
                    <th>Penilai</th>
                    <th>Nominasi</th>
                    <th>Total Nilai</th>
                    <th>Tanggung Jawab</th>
                    <th>Disiplin</th>
                    <th>Loyal</th>
                    <th>Ramah</th>
                    <th>Melayani</th>
                    <th>Cekatan</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach($penilaianOnars as $penilaian)
                    <!-- Modal -->
                    <div class="modal fade" id="{{'exampleModal'.$penilaian->id}}" tabindex="-1" aria-labelledby="{{'exampleModalLabel'.$penilaian->id}}" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5" id="{{'exampleModalLabel'.$penilaian->id}}">Hapus Penilaian ONAR</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            Apakah Anda yakin ingin menghapus <strong>{{$penilaian->id_pegawai}}</strong> ?
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                            <form action="{{url('penilaian-onar/destroy/'.$penilaian->id)}}">
                              <button type="submit" class="btn btn-danger">Hapus Penilaian ONAR</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <tr>
                      <td>
                        <div class="form-button-action">
                          <form action="{{url('penilaian-onar/edit', $penilaian->id)}}">
                            <button
                              type="submit"
                              data-bs-toggle="tooltip"
                              title=""
                              class="btn btn-link btn-primary btn-lg"
                              data-original-title="Edit Penilaian ONAR"
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
                      {{-- {{dd($penilaianOnars)}} --}}
                        <th scope="row">{{$penilaian->nominasiOnar->onar->nama}}</th>
                        <td>{{$penilaian->penilai->nama}}</td>
                        <td>{{$penilaian->nominasiOnar->outsourcing->nama}}</td>
                        <td>{{$penilaian->total_nilai}}</td>
                        <td>{{$penilaian->tanggung_jawab}}</td>
                        <td>{{$penilaian->disiplin}}</td>
                        <td>{{$penilaian->loyal}}</td>
                        <td>{{$penilaian->ramah}}</td>
                        <td>{{$penilaian->melayani}}</td>
                        <td>{{$penilaian->cekatan}}</td>
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
