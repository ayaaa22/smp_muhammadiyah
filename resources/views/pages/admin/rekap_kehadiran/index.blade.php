@extends('layouts.master')

@section('content')
    <div class="page-heading mb-4">
        <h3>Rekap Kehadiran Pegawai</h3>
    </div>

    <div class="page-content">
        <section class="row">
            <div class="card shadow rounded">
                <div class="card-header">
                    <form method="GET" class="row g-2">
                        <div class="col-md-3">
                            <input type="month" name="bulan" class="form-control"
                                value="{{ request('bulan', \Carbon\Carbon::now()->format('Y-m')) }}">
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
                                {{ $pegawaiTerpilih?->user?->name ?? 'Seluruh Pegawai' }}
                            </h5>
                        </div>
                    @endif

                    @forelse ($rekapKehadiran as $pegawaiId => $rekapPerTanggal)
                        @if (!request('pegawai_id'))
                            <h5 class="mt-4">{{ $pegawai?->user?->name ?? 'Seluruh Pegawai' }}</h5>
                        @endif

                        <table class="table table-bordered">
                            <thead class="table-secondary">
                                <tr class="text-center">
                                    <th>Tanggal</th>
                                    <th>Jam Datang</th>
                                    <th>Jam Pulang</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rekapPerTanggal as $tanggal => $rekap)
                                    <tr class="text-center">
                                        <td>{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}</td>
                                        @php
                                            $rekapItem = $rekap->first(); // ambil satu data dari koleksi
                                        @endphp

                                        <td>{{ $rekapItem->jam_datang ?? '-' }}</td>
                                        <td>{{ $rekapItem->jam_pulang ?? '-' }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ match ($rekapItem->status) {
                                                    'hadir' => 'success',
                                                    'izin' => 'warning',
                                                    'cuti' => 'primary',
                                                    'dinas' => 'info',
                                                    'tidak masuk' => 'danger',
                                                    default => 'secondary',
                                                } }}">
                                                {{ ucfirst($rekapItem->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $rekapItem->keterangan ?? '-' }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @empty
                        <div class="text-center">Tidak ada data rekap kehadiran.</div>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
@endsection
