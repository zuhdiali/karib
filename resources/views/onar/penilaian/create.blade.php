@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <form action="{{url('penilaian-onar/store', $onar->id)}}" method="POST">
                <div class="col-md-12">
                    <div class="card">
                        @csrf <!-- {{ csrf_field() }} -->
                        <div class="card-header">
                            <div class="card-title">Penilaian {{$onar->nama}}</div>
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
                                                1. Tanggung Jawab
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p>Tanggung jawab merupakan melakukan pekerjaan secara tuntas, tidak menunda-nunda waktu, sehingga pekerjaan lebih meningkat, bermutu dan dapat dipertanggung jawabkan secara kedinasan dan hukum.</p>

                                            @foreach($nominasiOnars as $nominasiOnar)
                                            <hr />
                                            <div class="form-group {{$errors->has("tanggung_jawab[$nominasiOnar->id]") ? 'has-error has-feedback' : ''}}">
                                                <label>{{$nominasiOnar->outsourcing->nama}}</label>
                                                <div class="d-flex">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                    <div class="form-check">
                                                        <input
                                                        class="form-check-input"
                                                        type="radio" name="tanggung_jawab[{{$nominasiOnar->id}}]" id="tanggung_jawab_{{$nominasiOnar->id}}_{{$i}}" value="{{$i}}" {{ old("tanggung_jawab[$nominasiOnar->id]") == $i ? 'checked' : '' }}
                                                        />
                                                        <label
                                                        class="form-check-label"
                                                        for="tanggung_jawab_{{$nominasiOnar->id}}_{{$i}}"
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
                                                2. Disiplin
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p>Disiplin merupakan keadaan yang menyebabkan atau memberi dorongan kepada pegawai untuk berbuat dan melakukan segala kegiatan sesuai dengan aturan yang telah ditetapkan.</p>

                                            @foreach($nominasiOnars as $nominasiOnar)
                                            <hr />
                                            <div class="form-group {{$errors->has("c[$nominasiOnar->id]") ? 'has-error has-feedback' : ''}}">
                                                <label>{{$nominasiOnar->outsourcing->nama}}</label>
                                                <div class="d-flex">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                    <div class="form-check">
                                                        <input
                                                        class="form-check-input"
                                                        type="radio" name="disiplin[{{$nominasiOnar->id}}]" id="disiplin_{{$nominasiOnar->id}}_{{$i}}" value="{{$i}}" @if(old("disiplin[$nominasiOnar->id]") == $i) checked @endif
                                                        />
                                                        <label
                                                        class="form-check-label"
                                                        for="disiplin_{{$nominasiOnar->id}}_{{$i}}"
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
                                                3. Loyal
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

                                            @foreach($nominasiOnars as $nominasiOnar)
                                            <hr />
                                            <div class="form-group {{$errors->has("loyal[$nominasiOnar->id]") ? 'has-error has-feedback' : ''}}">
                                                <label>{{$nominasiOnar->outsourcing->nama}}</label>
                                                <div class="d-flex">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                    <div class="form-check">
                                                        <input
                                                        class="form-check-input"
                                                        type="radio" name="loyal[{{$nominasiOnar->id}}]" id="loyal_{{$nominasiOnar->id}}_{{$i}}" value="{{$i}}" @if(old("loyal[$nominasiOnar->id]") == $i) checked @endif
                                                        />
                                                        <label
                                                        class="form-check-label"
                                                        for="loyal_{{$nominasiOnar->id}}_{{$i}}"
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
                                                4. Ramah
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p>Ramah adalah kata sifat yang baik hati, baik dalam tutur kata maupun sikapnya serta menyenangkan dalam pergaulan.</p>

                                            @foreach($nominasiOnars as $nominasiOnar)
                                            <hr />
                                            <div class="form-group {{$errors->has("ramah[$nominasiOnar->id]") ? 'has-error has-feedback' : ''}}">
                                                <label>{{$nominasiOnar->outsourcing->nama}}</label>
                                                <div class="d-flex">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                    <div class="form-check">
                                                        <input
                                                        class="form-check-input"
                                                        type="radio" name="ramah[{{$nominasiOnar->id}}]" id="ramah_{{$nominasiOnar->id}}_{{$i}}" value="{{$i}}" @if(old("ramah[$nominasiOnar->id]") == $i) checked @endif
                                                        />
                                                        <label
                                                        class="form-check-label"
                                                        for="ramah_{{$nominasiOnar->id}}_{{$i}}"
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
                                                5. Melayani
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p>Melayani adalah suatu kegiatan membantu orang lain atau memberikan diri untuk menolong orang lain.
                                            </p>

                                            @foreach($nominasiOnars as $nominasiOnar)
                                            <hr />
                                            <div class="form-group {{$errors->has("melayani[$nominasiOnar->id]") ? 'has-error has-feedback' : ''}}">
                                                <label>{{$nominasiOnar->outsourcing->nama}}</label>
                                                <div class="d-flex">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                    <div class="form-check">
                                                        <input
                                                        class="form-check-input"
                                                        type="radio" name="melayani[{{$nominasiOnar->id}}]" id="melayani_{{$nominasiOnar->id}}_{{$i}}" value="{{$i}}" @if(old("melayani[$nominasiOnar->id]") == $i) checked @endif
                                                        />
                                                        <label
                                                        class="form-check-label"
                                                        for="melayani_{{$nominasiOnar->id}}_{{$i}}"
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
                                                6. Cekatan
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p>Cekatan adalah cepat mengerti, pintar, cerdik.</p>

                                            @foreach($nominasiOnars as $nominasiOnar)
                                            <hr />
                                            <div class="form-group {{$errors->has("cekatan[$nominasiOnar->id]") ? 'has-error has-feedback' : ''}}">
                                                <label>{{$nominasiOnar->outsourcing->nama}}</label>
                                                <div class="d-flex">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                    <div class="form-check">
                                                        <input
                                                        class="form-check-input"
                                                        type="radio" name="cekatan[{{$nominasiOnar->id}}]" id="cekatan_{{$nominasiOnar->id}}_{{$i}}" value="{{$i}}" @if(old("cekatan[$nominasiOnar->id]") == $i) checked @endif
                                                        />
                                                        <label
                                                        class="form-check-label"
                                                        for="cekatan_{{$nominasiOnar->id}}_{{$i}}"
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