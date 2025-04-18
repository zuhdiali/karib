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
                    <form action="{{route('onar.store')}}" method="POST">
                        @csrf <!-- {{ csrf_field() }} -->
                        <div class="card-header">
                            <div class="card-title">Tambah ONAR</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group {{$errors->has('nama') ? 'has-error has-feedback' : ''}}">
                                        <label for="nama">Nama ONAR</label>
                                        <input
                                          type="text"
                                          class="form-control"
                                          id="nama"
                                          name="nama"
                                          placeholder="Masukkan nama ONAR"
                                          value="{{ old('nama') }}"
                                        />
                                        @if ($errors->has('nama'))
                                        <small class="form-text text-muted">{{ $errors->first('nama') }}</small>
                                        @else
                                        <small  class="form-text text-muted">
                                            Misal: ONAR 1.1, ONAR 1.2, ONAR 1.3, dst.
                                        </small>
                                        @endif
                                    </div> 

                                    <div class="form-group {{$errors->has("tgl_penilaian") ? 'has-error has-feedback' : ''}}">
                                        <label for="tgl_penilaian">Tanggal Penilaian ONAR</label>
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="tgl_penilaian"
                                            name="tgl_penilaian"
                                            value="{{ old("tgl_penilaian") ? old("tgl_penilaian") : date('Y-m-d') }}"
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
                                          placeholder="Masukkan tahun ONAR"
                                          value="{{ old('tahun') ? old('tahun') : date('Y') }}"
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
                                            <option value="1" {{ old("triwulan") == 1 ? 'selected' : '' }}>Triwulan I</option>
                                            <option value="2" {{ old("triwulan") == 2 ? 'selected' : '' }}>Triwulan II</option>
                                            <option value="3" {{ old("triwulan") == 3 ? 'selected' : '' }}>Triwulan III</option>
                                            <option value="4" {{ old("triwulan") == 4 ? 'selected' : '' }}>Triwulan IV</option>
                                        </select>
                                        @if ($errors->has("triwulan"))
                                        <small class="form-text text-muted">{{ $errors->first("triwulan") }}</small>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="{{$errors->has('nominasiOnar[]') ? 'has-error has-feedback' : ''}}">
                                        <label for="nominasiOnar[]">Outsourcing Yang Menjadi Nominasi</label>
                                        <select class="form-select" id="nominasiOnar" name="nominasiOnar[]" multiple="multiple">
                                            @foreach ($outsourcings as $item)
                                            <option value="{{$item->id}}" >
                                                {{$item->nama}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('nominasiOnar[]'))
                                        <small class="form-text text-muted">{{ $errors->first('nominasiOnar[]') }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Tambah ONAR</button>
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
    $('#nominasiOnar').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        closeOnSelect: false,
    });
</script>
@endsection