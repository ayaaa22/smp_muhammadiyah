@extends('layouts.master')

@section('content')
    <div class="page-heading mb-4">
        <h3>Data Presensi Pegawai</h3>
    </div>

    <div class="page-content">
        <section class="row">
            <div class="card shadow rounded">
                <div class="card-header">
                    <form method="GET" class="row g-2">
                        <div class="col-md-3">
                            <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                        </div>
                        <div class="col-md-4">
                            <select name="pegawai_id" class="form-control">
                                <option value="">-- Semua Pegawai --</option>
                                @foreach ($pegawaiList as $p)
                                    <option value="{{ $p->id }}"
                                        {{ request('pegawai_id') == $p->id ? 'selected' : '' }}>
                                        {{ $p->user->name ?? '-' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary">Filter</button>
                        </div>
                    </form>
                </div>

                <div class="card-body table-responsive">
                    @if (request('pegawai_id'))
                        @php
                            $pegawaiTerpilih = $pegawaiList->firstWhere('id', request('pegawai_id'));
                        @endphp
                        <div class="px-3 pb-2">
                            <h5 class="mt-4">
                                {{ $pegawaiTerpilih?->user?->name ?? 'Tidak Diketahui' }}
                            </h5>
                        </div>
                    @endif

                    @forelse ($presensi as $pegawaiId => $presensiTanggal)
                        @if (!request('pegawai_id'))
                            <h5 class="mt-4">{{ $pegawai?->user?->name ?? 'Seluruh Pegawai' }}</h5>
                        @endif

                        <table class="table table-bordered">
                            <thead class="table-secondary">
                                <tr class="text-center">
                                    <th>Tanggal</th>
                                    <th>Jam Datang</th>
                                    <th>Jam Pulang</th>
                                    <th>Koordinat Datang</th>
                                    <th>Koordinat Pulang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($presensiTanggal as $tanggal => $data)
                                    @php
                                        $datang = $data->firstWhere('jenis', 'datang');
                                        $pulang = $data->firstWhere('jenis', 'pulang');
                                    @endphp
                                    <tr class="text-center">
                                        <td>{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}</td>
                                        <td>{{ $datang ? \Carbon\Carbon::parse($datang->waktu)->format('H:i:s') : '-' }}
                                        </td>
                                        <td>{{ $pulang ? \Carbon\Carbon::parse($pulang->waktu)->format('H:i:s') : '-' }}
                                        </td>
                                        <td>
                                            @if ($datang)
                                                <a href="https://www.google.com/maps?q={{ $datang->latitude }},{{ $datang->longitude }}"
                                                    target="_blank">
                                                    <i class="bi bi-geo-alt-fill"><b>Lihat Maps</b></i>
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($pulang)
                                                <a href="https://www.google.com/maps?q={{ $pulang->latitude }},{{ $pulang->longitude }}"
                                                    target="_blank">
                                                    <i class="bi bi-geo-alt-fill"><b>Lihat Maps</b></i>
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @empty
                        <div class="text-center">Tidak ada data presensi.</div>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
@endsection
