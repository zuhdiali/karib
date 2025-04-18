@extends('layouts.app')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('select2/css/select2.min.css')}}" />
    <link rel="stylesheet" href="{{asset('select2/css/select2-bootstrap-5-theme.min.css')}}" />
@endsection

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form action="{{url('talak/update', $talak->id)}}" method="POST">
                        @csrf <!-- {{ csrf_field() }} -->
                        <div class="card-header">
                            <div class="card-title">Tambah TALAK</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group {{$errors->has('nama') ? 'has-error has-feedback' : ''}}">
                                        <label for="nama">Nama TALAK</label>
                                        <input
                                          type="text"
                                          class="form-control"
                                          id="nama"
                                          name="nama"
                                          placeholder="Masukkan nama TALAK"
                                          value="{{ old('nama') ? old('nama') : $talak->nama }}"
                                        />
                                        @if ($errors->has('nama'))
                                        <small class="form-text text-muted">{{ $errors->first('nama') }}</small>
                                        @else
                                        <small  class="form-text text-muted">
                                            Misal: TALAK 1.1, TALAK 1.2, TALAK 1.3, dst.
                                        </small>
                                        @endif
                                    </div> 

                                    <div class="form-group {{$errors->has("tgl_penilaian") ? 'has-error has-feedback' : ''}}">
                                        <label for="tgl_penilaian">Tanggal Penilaian TALAK</label>
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="tgl_penilaian"
                                            name="tgl_penilaian"
                                            value="{{ old("tgl_penilaian") ? old("tgl_penilaian") : $talak->tgl_penilaian }}"
                                        />
                                        @if ($errors->has("tgl_penilaian"))
                                        <small class="form-text text-muted">{{ $errors->first("tgl_penilaian") }}</small>
                                        @endif
                                    </div>

                                    <div class="form-group {{$errors->has('tahun') ? 'has-error has-feedback' : ''}}">
                                        <label for="tahun">Tahun</label>
                                        <input
                                          type="number"
                                          class="form-control"
                                          id="tahun"
                                          name="tahun"
                                          placeholder="Masukkan tahun TALAK"
                                          value="{{ old('tahun') ? old('tahun') : $talak->tahun }}"
                                        />
                                        @if ($errors->has('tahun'))
                                        <small class="form-text text-muted">{{ $errors->first('tahun') }}</small>
                                        @endif
                                    </div> 

                                    <div class="form-group {{$errors->has("triwulan") ? 'has-error has-feedback' : ''}}">
                                        <label for="triwulan">Triwulan</label>
                                        <select
                                            class="form-select"
                                            id="triwulan"
                                            name="triwulan"
                                        >
                                            <option value="" >(Pilih salah satu)</option>
                                            <option value="1" {{ $talak->triwulan == 1 ? 'selected' : '' }}>Triwulan I</option>
                                            <option value="2" {{ $talak->triwulan == 2 ? 'selected' : '' }}>Triwulan II</option>
                                            <option value="3" {{ $talak->triwulan == 3 ? 'selected' : '' }}>Triwulan III</option>
                                            <option value="4" {{ $talak->triwulan == 4 ? 'selected' : '' }}>Triwulan IV</option>
                                        </select>
                                        @if ($errors->has("triwulan"))
                                        <small class="form-text text-muted">{{ $errors->first("triwulan") }}</small>
                                        @endif
                                    </div>

                                </div>
                                
                                <div class="col-md-6">
                                    <div class="{{$errors->has('nominasiTalak[]') ? 'has-error has-feedback' : ''}}">
                                        <label for="nominasiTalak[]">Pegawai Yang Menjadi Nominasi</label>
                                        <select class="form-select" id="nominasiTalak" name="nominasiTalak[]" multiple="multiple">
                                            @foreach ($pegawais as $item)
                                            <option value="{{$item->id}}" {{ in_array($item->id, $nominasiTalaks) ? 'selected' : '' }}>
                                                {{$item->nama}}
                                            </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('nominasiTalak[]'))
                                        <small class="form-text text-muted">{{ $errors->first('nominasiTalak[]') }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Edit TALAK</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{asset('select2/js/select2.full.min.js')}}"></script>
<script>
    $('#nominasiTalak').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        closeOnSelect: false,
    });
</script>
@endsection