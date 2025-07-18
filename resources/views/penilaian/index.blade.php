@extends('layouts.app')

@section('content')

<div class="container">
  <div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4" >
      <div>
        <h3 class="fw-bold mb-3">Penilaian Pegawai</h3>
        <h6 class="op-7 mb-2">Daftar Penilaian Pegawai</h6>
      </div>
      <div class="ms-md-auto py-2 py-md-0">
        @if (Auth::user()->role == 'Penilai' && count($pegawaiBelumDinilai) > 0)
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-label-info btn-round me-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Lihat Pegawai Yang Belum Dinilai
          </button>
        @endif
        <a href="{{route('penilaian.create')}}" class="btn btn-primary btn-round">Tambah Penilaian</a>
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
                <i class="fas fa-user-check"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">
                      Pegawai Selesai Dinilai
                  </p>
                  <h4 class="card-title">{{$totalPenilaianKomplit}}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @if (Auth::user()->role == 'Penilai')
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div
                  class="icon-big text-center icon-danger bubble-shadow-small"
                >
                <i class="fas fa-user-check"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">Pegawai Belum Selesai Dinilai</p>
                  <h4 class="card-title">{{count($pegawaiBelumDinilai)}}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-3">
          <div class="card">
            
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Pegawai Belum Selesai Dinilai Minggu Ini</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    @foreach($pegawaiBelumDinilai as $pegawai)
                    <p>{{$pegawai->nama}}</p>
                    @endforeach
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      @endif


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
                      Total Penilaian Minggu Ini
                  </p>
                  <h4 class="card-title">{{$totalPenilaian}}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      @if (Auth::user()->role == 'Penilai')
      {{-- <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div
                  class="icon-big text-center icon-danger bubble-shadow-small"
                >
                <i class="fas fa-clipboard-check"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">Total Penilaian Yang Belum Dilakukan</p>
                  <h4 class="card-title">{{$totalPenilaianYangBelumDilakukan}}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> --}}
      @endif
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Riwayat Penilaian</h4>
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
                    <th>Penilai</th>
                    <th>Pegawai</th>
                    <th>Kerapian</th>
                    <th>Keindahan</th>
                    <th>Kebersihan</th>
                    {{-- <th>Penampilan</th> --}}
                    <th>Total Nilai</th>
                    <th>Tanggal Dinilai</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Aksi</th>
                    <th>Penilai</th>
                    <th>Pegawai</th>
                    <th>Kerapian</th>
                    <th>Keindahan</th>
                    <th>Kebersihan</th>
                    {{-- <th>Penampilan</th> --}}
                    <th>Total Nilai</th>
                    <th>Tanggal Dinilai</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach($penilaians as $nilai)
                    <!-- Modal -->
                    <div class="modal fade" id="{{'exampleModal'.$nilai->id}}" tabindex="-1" aria-labelledby="{{'exampleModalLabel'.$nilai->id}}" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5" id="{{'exampleModalLabel'.$nilai->id}}">Hapus Penilaian</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            Apakah Anda yakin ingin menghapus Penilaian <strong>{{$nilai->nama}}</strong> ?
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                            <form action="{{url('penilaian/destroy/'.$nilai->id)}}">
                              <button type="submit" class="btn btn-danger">Hapus Penilaian</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <tr>
                      <td>
                        <div class="form-button-action">
                          <form action="{{url('penilaian/edit', $nilai->id)}}">
                            <button
                              type="submit"
                              data-bs-toggle="tooltip"
                              title=""
                              class="btn btn-link btn-primary btn-lg"
                              data-original-title="Edit Nilai"
                            >
                            <i class="fa fa-edit"></i>
                          </form>
                          </button>

                          <button
                            type="button"
                            title="Hapus"
                            class="btn btn-link btn-danger"
                            data-bs-toggle="modal" 
                            data-bs-target="{{'#exampleModal'.$nilai->id}}"
                            data-original-title="Hapus"
                          >
                            <i class="fa fa-times"></i>
                          </button>
                        </div>
                      </td>
                      <td>{{$nilai->penilai->nama}}</td>
                      <th scope="row">{{$nilai->pegawai->nama}}</th>
                      <td>{{$nilai->kerapian}}</td>
                      <td>{{$nilai->keindahan}}</td>
                      <td>{{$nilai->kebersihan}}</td>
                      {{-- <td>{{$nilai->penampilan}}</td> --}}
                      <td>{{$nilai->total_nilai}}</td>
                      <td>{{\Carbon\Carbon::parse($nilai->tanggal_penilaian)->translatedFormat('d M Y')}}</td>
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
