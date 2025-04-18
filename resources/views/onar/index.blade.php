@extends('layouts.app')

@section('content')

<div class="container">
  <div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4" >
      <div>
        <h3 class="fw-bold mb-3">ONAR</h3>
        <h6 class="op-7 mb-2">Daftar ONAR (Outsourcing Bersinar)</h6>
      </div>
      <div class="ms-md-auto py-2 py-md-0">
        @if(Auth::check() && Auth::user()->role == 'Admin')
        <a href="{{route('onar.create')}}" class="btn btn-primary btn-round">Tambah ONAR</a>
        @endif
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
                <i class="fas fa-trophy"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">
                      Jumlah ONAR
                  </p>
                  <h4 class="card-title">{{$totalOnar}}</h4>
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
                    <th>Tahun</th>
                    <th>Triwulan</th>
                    <th>Tanggal Penilaian</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Aksi</th>
                    <th>Nama ONAR</th>
                    <th>Tahun</th>
                    <th>Triwulan</th>
                    <th>Tanggal Penilaian</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach($onars as $onar)
                    <!-- Modal -->
                    <div class="modal fade" id="{{'exampleModal'.$onar->id}}" tabindex="-1" aria-labelledby="{{'exampleModalLabel'.$onar->id}}" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5" id="{{'exampleModalLabel'.$onar->id}}">Hapus ONAR</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            Apakah Anda yakin ingin menghapus <strong>{{$onar->nama}}</strong> ?
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                            <form action="{{url('onar/destroy/'.$onar->id)}}">
                              <button type="submit" class="btn btn-danger">Hapus ONAR</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <tr>
                      <td>
                        <div class="form-button-action">
                          <form action="{{url('penilaian-onar/create', $onar->id)}}">
                            <button
                              type="submit"
                              data-bs-toggle="tooltip"
                              title="Tautan Penilaian ONAR"
                              class="btn btn-link btn-primary btn-lg"
                              data-original-title="Tautan Penilaian ONAR"
                            >
                            <i class="fas fa-link"></i>
                          </button>
                          </form>

                          @if(Auth::check() && Auth::user()->role == 'Admin')
                          <form action="{{url('onar/show', $onar->id)}}">
                            <button
                              type="submit"
                              data-bs-toggle="tooltip"
                              title="Lihat ONAR"
                              class="btn btn-link btn-primary btn-lg"
                              data-original-title="Lihat ONAR"
                            >
                            <i class="fas fa-eye"></i>
                          </button>
                          </form>

                          <form action="{{url('onar/edit', $onar->id)}}">
                            <button
                              type="submit"
                              data-bs-toggle="tooltip"
                              title="Edit ONAR"
                              class="btn btn-link btn-primary btn-lg"
                              data-original-title="Edit ONAR"
                            >
                            <i class="fa fa-edit"></i>
                          </button>
                          </form>

                          <button
                            type="button"
                            title="Hapus"
                            class="btn btn-link btn-danger"
                            data-bs-toggle="modal" 
                            data-bs-target="{{'#exampleModal'.$onar->id}}"
                            data-original-title="Hapus"
                          >
                            <i class="fa fa-times"></i>
                          </button>
                        @endif
                        </div>
                      </td>
                        <th scope="row">{{$onar->nama}}</th>
                        <td>{{$onar->tahun}}</td>
                        <td>{{$onar->triwulan}}</td>
                        <td>{{date('d M Y', strtotime($onar->tgl_penilaian))}}</td>
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
