@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form action="{{url('penilaian/ruangan/update', $penilaian->id)}}" method="POST">
                        @csrf <!-- {{ csrf_field() }} -->
                        <div class="card-header">
                            <div class="card-title">Tambah Penilaian</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group {{$errors->has("tanggal_penilaian") ? 'has-error has-feedback' : ''}}">
                                        <label for="tanggal_penilaian">Tanggal</label>
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="tanggal_penilaian"
                                            name="tanggal_penilaian"
                                            placeholder="Masukkan username"
                                            value="{{ old("tanggal_penilaian") ? old("tanggal_penilaian") : $penilaian->tanggal_penilaian }}"
                                            disabled
                                        />
                                        @if ($errors->has("tanggal_penilaian"))
                                        <small class="form-text text-muted">{{ $errors->first("tanggal_penilaian") }}</small>
                                        @else
                                        <small class="form-text text-muted">Tanggal di atas sudah terisi otomatis. Bisa dilewati.</small>
                                        @endif
                                        <hr/>
                                    </div>

                                    <div class="form-group {{$errors->has("ruangan_yang_dinilai") ? 'has-error has-feedback' : ''}}">
                                        <label for="ruangan_yang_dinilai">Ruangan yang dinilai</label>
                                        <select
                                            class="form-select"
                                            id="ruangan_yang_dinilai"
                                            name="ruangan_yang_dinilai"
                                            disabled
                                        >
                                            <option value="">(Pilih salah satu)</option>
                                            @foreach ($ruangans as $item)
                                            <option value="{{$item->id}}" {{ $penilaian->ruangan_id == $item->id ? 'selected' : ''}}>{{$item->nama}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has("ruangan_yang_dinilai"))
                                        <small class="form-text text-muted">{{ $errors->first("ruangan_yang_dinilai") }}</small>
                                        @endif
                                        <hr/>
                                    </div>
                                    <div class="form-group {{$errors->has("kebersihan") ? 'has-error has-feedback' : ''}}">
                                        <label for="kebersihan">
                                            <h3>Kebersihan</h3>
                                        </label>
                                        <ul>
                                            <li>Meja tidak berdebu</li>
                                            <li>Bersih dari sampah (kertas bekas, tisu, sisa makanan, dll)</li>
                                        </ul>
                                        
                                        <input
                                            type="range"
                                            min="0"
                                            max="10"
                                            class="form-range"
                                            id="kebersihan"
                                            placeholder="Masukkan nilai kebersihan (0-10)"
                                            name="kebersihan"
                                            value="{{ old('kebersihan') ? old('kebersihan') : $penilaian->kebersihan }}"
                                            oninput="this.nextElementSibling.value = this.value"
                                        />
                                        Nilai Kebersihan:
                                        <output>{{ old("kebersihan") ? old("kebersihan") : $penilaian->kebersihan }}</output>
                                        @if ($errors->has("kebersihan"))
                                        <small class="form-text text-muted">{{ $errors->first("kebersihan") }}</small>
                                        @endif
                                    </div>

                                </div>
                                <div class="col-md-6">

                                    <div class="form-group {{$errors->has("keindahan") ? 'has-error has-feedback' : ''}}">
                                        <label for="keindahan">
                                            <h3>Keindahan</h3>
                                        </label>
                                        <ul>
                                            <li>Penempatan hiasan meja (bunga/vas bunga, foto, dll)</li>
                                            <li>Seni penataan barang</li>
                                        </ul>
                                        <input
                                            type="range"
                                            min="0"
                                            max="10"
                                            class="form-range"
                                            id="keindahan"
                                            placeholder="Masukkan nilai keindahan (0-10)"
                                            name="keindahan"
                                            value="{{ old("keindahan") ? old("keindahan") : $penilaian->keindahan }}"
                                            oninput="this.nextElementSibling.value = this.value"
                                        />
                                        Nilai Keindahan:
                                        <output>{{ old("keindahan") ? old("keindahan") : $penilaian->keindahan }}</output>
                                        @if ($errors->has("keindahan"))
                                        <small class="form-text text-muted">{{ $errors->first("keindahan") }}</small>
                                        @endif
                                        <hr/>
                                    </div>

                                    <div class="form-group {{$errors->has("kerapian") ? 'has-error has-feedback' : ''}}">
                                        <label for="kerapian">
                                            <h3>Kerapian</h3>
                                        </label>
                                        <ul>
                                            <li>Kabel tersusun rapi</li>
                                            <li>Dokumen rapi</li>
                                            <li>Meminimalisir barang yang tidak perlu (sendok, gelas, piring, ATK)</li>
                                            <li>Penempatan sepatu, sandal</li>
                                            <li>Penempatan jaket, tas, dll</li>
                                            <li>Komputer (selain server) dalam kondisi mati pada jam pulang <strong>(jika dalam kondisi hidup, nilai kerapian maksimal 5)</strong></li>
                                        </ul>
                                        <input
                                            type="range"
                                            min="0"
                                            max="10"
                                            class="form-range"
                                            id="kerapian"
                                            placeholder="Masukkan nilai kerapian (0-10)"
                                            name="kerapian"
                                            value="{{ old("kerapian") ? old("kerapian") : $penilaian->kerapian }}"
                                            oninput="this.nextElementSibling.value = this.value"
                                        />
                                        Nilai Kerapian:
                                        <output>{{ old("kerapian") ? old("kerapian") : $penilaian->kerapian }}</output>
                                        @if ($errors->has("kerapian"))
                                        <small class="form-text text-muted">{{ $errors->first("kerapian") }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Edit Penilaian</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
