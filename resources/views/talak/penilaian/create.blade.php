@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <form action="{{url('penilaian-talak/store', $talak->id)}}" method="POST">
                <div class="col-md-12">
                    <div class="card">
                        @csrf <!-- {{ csrf_field() }} -->
                        <div class="card-header">
                            <div class="card-title">Penilaian {{$talak->nama}}</div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-md-12">

                                    <div class="form-group {{$errors->has("id_penilai") ? 'has-error has-feedback' : ''}}">
                                        <label for="id_penilai">Nama Responden</label>
                                        <select
                                            class="form-select"
                                            id="id_penilai"
                                            name="id_penilai"
                                            required
                                        >
                                            <option value="" >(Pilih salah satu)</option>
                                            <option value="1">Kepala BPS</option>
                                            @foreach ($pegawais as $item)
                                            <option value="{{$item->id}}" {{ old("id_penilai") == $item->id ? "selected" : ""}}>
                                                {{$item->nama}} 
                                            </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has("id_penilai"))
                                        <small class="form-text text-muted">{{ $errors->first("id_penilai") }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                1. Berorientasi Pelayanan
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <ul>
                                                <li>
                                                    Memahami dan memenuhi kebutuhan masyarakat.
                                                </li>
                                                <li>
                                                    Ramah, cekatan, solutif, dan dapat diandalkan.
                                                </li>
                                                <li>
                                                    Melakukan perbaikan tiada henti.
                                                </li>
                                            </ul>

                                            @foreach($nominasiTalaks as $nominasiTalak)
                                            <hr />
                                            <div class="form-group {{$errors->has("orientasi_layanan[$nominasiTalak->id]") ? 'has-error has-feedback' : ''}}">
                                                <label>{{$nominasiTalak->pegawai->nama}}</label>
                                                <div class="d-flex">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                    <div class="form-check">
                                                        <input
                                                        class="form-check-input"
                                                        type="radio" name="orientasi_layanan[{{$nominasiTalak->id}}]" id="orientasi_layanan_{{$nominasiTalak->id}}_{{$i}}" value="{{$i}}" {{ old("orientasi_layanan[$nominasiTalak->id]") == $i ? 'checked' : '' }}
                                                        />
                                                        <label
                                                        class="form-check-label"
                                                        for="orientasi_layanan_{{$nominasiTalak->id}}_{{$i}}"
                                                        >
                                                        {{ $i }}
                                                        </label>
                                                    </div>
                                                    @endfor
                                                </div>
                                            </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                2. Akuntabel
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <ul>
                                                <li>
                                                    Melaksanakan tugas dengan jujur, bertanggung jawab, cermat, serta disiplin dan berintegritas tinggi.
                                                </li>
                                                <li>
                                                    Menggunakan kekayaan dan barang milik negara secara bertanggung jawab, efektif dan efisien.
                                                </li>
                                                <li>
                                                    Tidak menyalahgunakan kewenangan jabatan.
                                                </li>
                                            </ul>

                                            @foreach($nominasiTalaks as $nominasiTalak)
                                            <hr />
                                            <div class="form-group {{$errors->has("akuntabel[$nominasiTalak->id]") ? 'has-error has-feedback' : ''}}">
                                                <label>{{$nominasiTalak->pegawai->nama}}</label>
                                                <div class="d-flex">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                    <div class="form-check">
                                                        <input
                                                        class="form-check-input"
                                                        type="radio" name="akuntabel[{{$nominasiTalak->id}}]" id="akuntabel_{{$nominasiTalak->id}}_{{$i}}" value="{{$i}}" @if(old("akuntabel[$nominasiTalak->id]") == $i) checked @endif
                                                        />
                                                        <label
                                                        class="form-check-label"
                                                        for="akuntabel_{{$nominasiTalak->id}}_{{$i}}"
                                                        >
                                                        {{ $i }}
                                                        </label>
                                                    </div>
                                                    @endfor
                                                </div>
                                            </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                3. Kompeten
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <ul>
                                                <li>
                                                    Meningkatkan kompetensi diri untuk menjawab tantangan yang selalu berubah.
                                                </li>
                                                <li>
                                                    Membantu orang lain belajar.
                                                </li>
                                                <li>
                                                    Melaksanakan tugas dengan kualitas terbaik.
                                                </li>
                                            </ul>

                                            @foreach($nominasiTalaks as $nominasiTalak)
                                            <hr />
                                            <div class="form-group {{$errors->has("kompeten[$nominasiTalak->id]") ? 'has-error has-feedback' : ''}}">
                                                <label>{{$nominasiTalak->pegawai->nama}}</label>
                                                <div class="d-flex">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                    <div class="form-check">
                                                        <input
                                                        class="form-check-input"
                                                        type="radio" name="kompeten[{{$nominasiTalak->id}}]" id="kompeten_{{$nominasiTalak->id}}_{{$i}}" value="{{$i}}" @if(old("kompeten[$nominasiTalak->id]") == $i) checked @endif
                                                        />
                                                        <label
                                                        class="form-check-label"
                                                        for="kompeten_{{$nominasiTalak->id}}_{{$i}}"
                                                        >
                                                        {{ $i }}
                                                        </label>
                                                    </div>
                                                    @endfor
                                                </div>
                                            </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                4. Harmonis
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <ul>
                                                <li>
                                                    Menghargai setiap orang apapun latar belakangnya.
                                                </li>
                                                <li>
                                                    Suka menolong orang lain.
                                                </li>
                                                <li>
                                                    Membangun lingkungan kerja yang kondusif.
                                                </li>
                                            </ul>
                                            @foreach($nominasiTalaks as $nominasiTalak)
                                            <hr />
                                            <div class="form-group {{$errors->has("harmonis[$nominasiTalak->id]") ? 'has-error has-feedback' : ''}}">
                                                <label>{{$nominasiTalak->pegawai->nama}}</label>
                                                <div class="d-flex">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                    <div class="form-check">
                                                        <input
                                                        class="form-check-input"
                                                        type="radio" name="harmonis[{{$nominasiTalak->id}}]" id="harmonis_{{$nominasiTalak->id}}_{{$i}}" value="{{$i}}" @if(old("harmonis[$nominasiTalak->id]") == $i) checked @endif
                                                        />
                                                        <label
                                                        class="form-check-label"
                                                        for="harmonis_{{$nominasiTalak->id}}_{{$i}}"
                                                        >
                                                        {{ $i }}
                                                        </label>
                                                    </div>
                                                    @endfor
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                5. Loyal
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <ul>
                                                <li>
                                                    Memegang teguh ideologi Pancasila dan Undang-Undang Dasar Negara Republik Indonesia Tahun 1945.
                                                </li>
                                                <li>
                                                    Setia kepada NKRI serta pemerintahan yang sah.
                                                </li>
                                                <li>
                                                    Menjaga nama baik sesama ASN, pimpinan, instansi dan negara, serta menjaga rahasia jabatan dan negara.
                                                </li>
                                            </ul>

                                            @foreach($nominasiTalaks as $nominasiTalak)
                                            <hr />
                                            <div class="form-group {{$errors->has("loyal[$nominasiTalak->id]") ? 'has-error has-feedback' : ''}}">
                                                <label>{{$nominasiTalak->pegawai->nama}}</label>
                                                <div class="d-flex">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                    <div class="form-check">
                                                        <input
                                                        class="form-check-input"
                                                        type="radio" name="loyal[{{$nominasiTalak->id}}]" id="loyal_{{$nominasiTalak->id}}_{{$i}}" value="{{$i}}" @if(old("loyal[$nominasiTalak->id]") == $i) checked @endif
                                                        />
                                                        <label
                                                        class="form-check-label"
                                                        for="loyal_{{$nominasiTalak->id}}_{{$i}}"
                                                        >
                                                        {{ $i }}
                                                        </label>
                                                    </div>
                                                    @endfor
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                6. Adaptif
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <ul>
                                                <li>
                                                    Cepat menyesuaikan diri menghadapi perubahan.
                                                </li>
                                                <li>
                                                    Terus berinovasi dan mengembangkan kreativitas.
                                                </li>
                                                <li>
                                                    Bertindak proaktif.
                                                </li>
                                            </ul>

                                            @foreach($nominasiTalaks as $nominasiTalak)
                                            <hr />
                                            <div class="form-group {{$errors->has("adaptif[$nominasiTalak->id]") ? 'has-error has-feedback' : ''}}">
                                                <label>{{$nominasiTalak->pegawai->nama}}</label>
                                                <div class="d-flex">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                    <div class="form-check">
                                                        <input
                                                        class="form-check-input"
                                                        type="radio" name="adaptif[{{$nominasiTalak->id}}]" id="adaptif_{{$nominasiTalak->id}}_{{$i}}" value="{{$i}}" @if(old("adaptif[$nominasiTalak->id]") == $i) checked @endif
                                                        />
                                                        <label
                                                        class="form-check-label"
                                                        for="adaptif_{{$nominasiTalak->id}}_{{$i}}"
                                                        >
                                                        {{ $i }}
                                                        </label>
                                                    </div>
                                                    @endfor
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                7. Kolaboratif
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <ul>
                                                <li>
                                                    Memberi kesempatan kepada berbagai pihak untuk berkontribusi.
                                                </li>
                                                <li>
                                                    Terbuka dalam bekerja sama untuk menghasilkan nilai tambah.
                                                </li>
                                                <li>
                                                    Menggerakkan pemanfaatan berbagai sumber daya untuk tujuan bersama.
                                                </li>
                                            </ul>

                                            @foreach($nominasiTalaks as $nominasiTalak)
                                            <hr />
                                            <div class="form-group {{$errors->has("kolaboratif[$nominasiTalak->id]") ? 'has-error has-feedback' : ''}}">
                                                <label>{{$nominasiTalak->pegawai->nama}}</label>
                                                <div class="d-flex">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                    <div class="form-check">
                                                        <input
                                                        class="form-check-input"
                                                        type="radio" name="kolaboratif[{{$nominasiTalak->id}}]" id="kolaboratif_{{$nominasiTalak->id}}_{{$i}}" value="{{$i}}" @if(old("kolaboratif[$nominasiTalak->id]") == $i) checked @endif
                                                        />
                                                        <label
                                                        class="form-check-label"
                                                        for="kolaboratif_{{$nominasiTalak->id}}_{{$i}}"
                                                        >
                                                        {{ $i }}
                                                        </label>
                                                    </div>
                                                    @endfor
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Tambah Penilaian</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection