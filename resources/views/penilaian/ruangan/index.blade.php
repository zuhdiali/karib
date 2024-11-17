@extends('layouts.app')

@section('content')

<div class="container">
  <!-- Jika ada session succes -->
  @if (session('success'))
  <div class="alert alert-success alert-dismissible fade show w-50 my-2 mx-5" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif
  <!-- Jika ada session succes -->

  <!-- Jika ada session error-->
  @if (session('error'))
  <div class="alert alert-warning alert-dismissible fade show w-50 my-2 mx-5" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif
  <!-- Jika ada session error-->

  <div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4" >
      <div>
        <h3 class="fw-bold mb-3">Manajemen Penilaian</h3>
        <h6 class="op-7 mb-2">Daftar Penilaian website KARIB</h6>
      </div>
      <div class="ms-md-auto py-2 py-md-0">
        @if (Auth::user()->role == 'Penilai' && $ruanganBelumDinilai != null)
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-label-info btn-round me-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
          Lihat Ruangan Yang Belum Dinilai
        </button>
        @endif
        <a href="{{route('penilaian.ruangan.create')}}" class="btn btn-primary btn-round">Tambah Penilaian</a>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-4">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div
                  class="icon-big text-center icon-primary bubble-shadow-small"
                >
                  <i class="fas fa-users"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">Ruangan Yang Sudah Dinilai Minggu Ini</p>
                  <h4 class="card-title">{{$totalPenilaian}}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @if (Auth::user()->role == 'Penilai')
      <div class="col-sm-6 col-md-4">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div
                  class="icon-big text-center icon-primary bubble-shadow-small"
                >
                  <i class="fas fa-users"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">Ruangan Yang Belum Dinilai Minggu Ini</p>
                  <h4 class="card-title">{{count($ruanganBelumDinilai)}}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="card">
          
          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Ruangan Belum Dinilai Minggu Ini</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  @foreach($ruanganBelumDinilai as $Ruangan)
                  <p>{{$Ruangan->nama}}</p>
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
                    <th>Ruangan</th>
                    <th>Kerapian</th>
                    <th>Keindahan</th>
                    <th>Kebersihan</th>
                    <th>Total Nilai</th>
                    <th>Tanggal Dinilai</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Aksi</th>
                    <th>Penilai</th>
                    <th>Ruangan</th>
                    <th>Kerapian</th>
                    <th>Keindahan</th>
                    <th>Kebersihan</th>
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
                            <form action="{{url('penilaian.ruangan/destroy/'.$nilai->id)}}">
                              <button type="submit" class="btn btn-danger">Hapus Penilaian</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <tr>
                      <td>
                        <div class="form-button-action">
                          <form action="{{url('penilaian/ruangan/edit', $nilai->id)}}">
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
                      <th scope="row">{{$nilai->ruangan->nama}}</th>
                      <td>{{$nilai->kerapian}}</td>
                      <td>{{$nilai->keindahan}}</td>
                      <td>{{$nilai->kebersihan}}</td>
                      <td>{{$nilai->total_nilai}}</td>
                      <td>{{$nilai->tanggal_penilaian}}</td>
                      
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
