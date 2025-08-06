@extends('layouts.master')

@section('content')
    <div class="page-heading mb-4">
        <h3>Presensi Harian</h3>
    </div>

    <div class="page-content">
        <section class="row">
            <div class="card shadow rounded">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Presensi Hari Ini</h4>
                    <div>
                        <form action="{{ route('pegawai_presensi.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="latitude" id="latitude">
                            <input type="hidden" name="longitude" id="longitude">

                            <button type="submit" name="jenis" value="datang" class="btn btn-success me-2"
                                {{ $sudahPresensiDatang ? 'disabled' : '' }}>
                                <i class="bi bi-door-open"></i> Presensi Datang
                            </button>

                            <button type="submit" name="jenis" value="pulang" class="btn btn-danger"
                                {{ !$sudahPresensiDatang || $sudahPresensiPulang ? 'disabled' : '' }}>
                                <i class="bi bi-door-closed"></i> Presensi Pulang
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }}</p>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Jam Datang</th>
                                    <th>Jam Pulang</th>
                                    <th>Koordinat Datang</th>
                                    <th>Koordinat Pulang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($presensiHariIni as $index => $item)
                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item['tanggal'])->translatedFormat('l, d F Y') }}</td>
                                        <td>
                                            {{ $item['datang'] ? \Carbon\Carbon::parse($item['datang']->waktu)->format('H:i:s') : '-' }}
                                        </td>
                                        <td>
                                            {{ $item['pulang'] ? \Carbon\Carbon::parse($item['pulang']->waktu)->format('H:i:s') : '-' }}
                                        </td>
                                        <td>
                                            @if ($item['datang'])
                                                <a href="https://www.google.com/maps?q={{ $item['datang']->latitude }},{{ $item['datang']->longitude }}"
                                                    target="_blank" class="text-decoration-underline">
                                                    <i class="bi bi-geo-alt-fill"><b>Lihat Maps</b></i>
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item['pulang'])
                                                <a href="https://www.google.com/maps?q={{ $item['pulang']->latitude }},{{ $item['pulang']->longitude }}"
                                                    target="_blank" class="text-decoration-underline">
                                                    <i class="bi bi-geo-alt-fill"><b>Lihat Maps</b></i>
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada presensi hari ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- Script untuk mengambil koordinat --}}
    <script>
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                document.getElementById('latitude').value = position.coords.latitude;
                document.getElementById('longitude').value = position.coords.longitude;
            }, function(error) {
                alert('Gagal mengambil lokasi, pastikan GPS aktif!');
            });
        } else {
            alert('Browser tidak mendukung Geolocation');
        }
    </script>
@endsection
