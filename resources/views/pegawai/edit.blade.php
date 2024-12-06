@extends('layouts.app')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form action="{{url('pegawai/update', $pegawai->id)}}" method="POST">
                        @csrf <!-- {{ csrf_field() }} -->
                        <div class="card-header">
                            <div class="card-title">Edit Pegawai</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group {{$errors->has('nama') ? 'has-error has-feedback' : ''}}">
                                        <label for="nama">Nama Pegawai</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="nama"
                                            name="nama"
                                            placeholder="Masukkan nama"
                                            value="{{ $pegawai->nama }}"
                                        />
                                        @if ($errors->has('nama'))
                                        <small class="form-text text-muted">{{ $errors->first('nama') }}</small>
                                        @else
                                        <small  class="form-text text-muted">
                                        </small>
                                        @endif
                                    </div>

                                    <div class="form-group {{$errors->has("ruangan") ? 'has-error has-feedback' : ''}}">
                                        <label for="ruangan">Pegawai yang dinilai</label>
                                        <select
                                            class="form-select"
                                            id="ruangan"
                                            name="ruangan"
                                        >
                                            <option value="" >(Pilih salah satu)</option>
                                            @foreach ($ruangans as $item)
                                            <option value="{{$item->id}}" {{ $pegawai->ruangan == $item->id ? "selected" : ""}}>
                                                {{$item->nama}} 
                                            </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has("ruangan"))
                                        <small class="form-text text-muted">{{ $errors->first("ruangan") }}</small>
                                        @endif
                                        <hr/>
                                    </div>

                                    <div class="form-group {{$errors->has("flag") ? 'has-error has-feedback' : ''}}">
                                        <label for="flag">Flag</label>
                                        <select
                                            class="form-select"
                                            id="flag"
                                            name="flag"
                                        >
                                            <option>(Pilih salah satu)</option>
                                            
                                            <option value="Aktif" {{ $pegawai->flag == null ? "selected" : ""}}>
                                                Aktif
                                            </option>
                                            <option value="Tidak Aktif" {{ $pegawai->flag != null ? "selected" : ""}}>
                                                Tidak Aktif
                                            </option>
                                        </select>
                                        @if ($errors->has("flag"))
                                        <small class="form-text text-muted">{{ $errors->first("flag") }}</small>
                                        @endif
                                        <hr/>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Tambah Pegawai</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

