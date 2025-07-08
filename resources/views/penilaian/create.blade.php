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
                    <form action="{{route('penilaian.store')}}" method="POST">
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
                                            value="{{ old("tanggal_penilaian") ? old("tanggal_penilaian") : date('Y-m-d') }}"
                                        />
                                        @if ($errors->has("tanggal_penilaian"))
                                        <small class="form-text text-muted">{{ $errors->first("tanggal_penilaian") }}</small>
                                        @else
                                        <small class="form-text text-muted">Tanggal di atas sudah terisi otomatis. Bisa dilewati.</small>
                                        @endif
                                        <hr/>
                                    </div>

                                    <div class="form-group {{$errors->has("pegawai_yang_dinilai") ? 'has-error has-feedback' : ''}}">
                                        <label for="pegawai_yang_dinilai">Pegawai yang dinilai</label>
                                        <select
                                            class="form-select"
                                            id="pegawai_yang_dinilai"
                                            name="pegawai_yang_dinilai"
                                        >
                                            <option value="" >(Pilih salah satu)</option>
                                            @foreach ($pegawais as $item)
                                                {{-- Validasi ini digunakan untuk melakukan penilaian di sore hari. Ketika sudah ada penilaian maka akan dicek apakah sekarang sudah pukul 16.00WIB --}}
                                                {{-- Jika belum pukul 16.00 WIB maka penilaian terhadap pegawai ini tidak dapat dilakukan --}}
                                                {{-- kuncinya adalah  'now()->hour >= 9'. Harusnya  'now()->hour >= 16' tetapi karena server menggunakan UTC+0, sedangkan WIB adalah UTC+7 jadi harus disesuaikan --}}
                                                @if($item->tanggal_terakhir_penilaian == null || ($item->tanggal_terakhir_penilaian != null && now()->hour >= 9))
                                                <option value="{{$item->id}}" {{ old("pegawai_yang_dinilai") == $item->id ? "selected" : ""}}>
                                                    {{$item->total_penilaian}} - {{$item->nama}} 
                                                </option>
                                                @endif

                                            @endforeach
                                        </select>
                                        @if ($errors->has("pegawai_yang_dinilai"))
                                        <small class="form-text text-muted">{{ $errors->first("pegawai_yang_dinilai") }}</small>
                                        @else
                                        <small class="form-text text-muted">Angka di sebelah kiri nama pegawai menunjukkan jumlah penilaian yang sudah dilakukan minggu ini.</small>
                                        <hr/>
                                        @endif
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
                                            value="{{ old("kebersihan") }}"
                                            oninput="this.nextElementSibling.value = this.value"
                                        />
                                        Nilai Kebersihan:
                                        <output>{{ old("kebersihan") }}</output>
                                        @if ($errors->has("kebersihan"))
                                        <small class="form-text text-muted">{{ $errors->first("kebersihan") }}</small>
                                        @endif
                                        <hr/>
                                    </div>
                                    {{-- <div class="form-group {{$errors->has("penampilan") ? 'has-error has-feedback' : ''}}">
                                        <label for="penampilan"><h3>Penampilan</h3></label>
                                        <ul>
                                            <li>Kerapian berpakaian, baju layak dipakai (tidak luntur, tidak sobek, pas di badan)</li>
                                            <li>Penggunaan seragam lengkap sesuai jadwal (Senin, Selasa, KORPRI)</li>
                                            <li>Kelengkapan atribut (ID Card)</li>
                                            <li>Bersepatu di jam kerja</li>
                                            <li>Rambut rapi</li>
                                            <li>Keserasian berpakaian (atasan dan bawahan enak dipandang)</li>
                                        </ul>
                                        <input
                                            type="range"
                                            min="0"
                                            max="10"
                                            class="form-range"
                                            id="penampilan"
                                            name="penampilan"
                                            value="{{ old("penampilan") }}"
                                            oninput="this.nextElementSibling.value = this.value"
                                        />
                                        Nilai Penampilan:
                                        <output>{{ old("penampilan") }}</output>
                                        @if ($errors->has("penampilan"))
                                        <small class="form-text text-muted">{{ $errors->first("penampilan") }}</small>
                                        @endif
                                    </div> --}}

                                </div>
                                <div class="col-md-6">
                                    

                                    <div class="form-group {{$errors->has("keindahan") ? 'has-error has-feedback' : ''}}">
                                        <label for="keindahan">
                                            <h3>Keindahan</h3>
                                        </label>
                                        <ul>
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
                                            value="{{ old("keindahan") }}"
                                            oninput="this.nextElementSibling.value = this.value"
                                        />
                                        Nilai Keindahan:
                                        <output>{{ old("keindahan") }}</output>
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
                                            value="{{ old("kerapian") }}"
                                            oninput="this.nextElementSibling.value = this.value"
                                        />
                                        Nilai Kerapian:
                                        <output>{{ old("kerapian") }}</output>
                                        @if ($errors->has("kerapian"))
                                        <small class="form-text text-muted">{{ $errors->first("kerapian") }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Tambah Penilaian</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function(){
        $("#tanggal_penilaian").change(function(){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{url('penilaian/list-pegawai-belum-dinilai')}}",
                data: {
                    id_penilai: {{Auth::user()->id}}, 
                    tanggal: $("#tanggal_penilaian").val()
                },
                success: function(msg){
                    // console.log(new Date().toLocaleString());
                    $("#pegawai_yang_dinilai").empty();
                    $("#pegawai_yang_dinilai").append('<option value="">(Pilih salah satu)</option>');
                    if(msg.length > 0){
                        msg.forEach(function(p){
                            $("#pegawai_yang_dinilai").append('<option value="'+p.id+'">'+p.total_penilaian+' - '+p.nama+'</option>');
                        });
                    }

                },
                error: function(msg){
                    console.log(msg);
                }

            });
        });
    });
</script>
@endsection