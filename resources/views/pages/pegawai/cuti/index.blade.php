@extends('layouts.master')

@section('content')
    <div class="page-heading mb-4">
        <h3>Pengajuan Cuti</h3>
    </div>

    <div class="page-content">
        <section class="row">
            <div class="card shadow rounded">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Riwayat Pengajuan Cuti</h4>
                    <a href="{{ route('cuti.pegawai.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Ajukan Cuti
                    </a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Cuti</th>
                                    <th>Tanggal</th>
                                    <th>Alasan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cuti as $index => $item)
                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->jenisCuti->nama_cuti }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}
                                            s.d
                                            {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                                        </td>
                                        <td>{{ Str::limit($item->alasan_cuti, 30) ?? '-' }}</td>
                                        <td>
                                            @if ($item->status == 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif ($item->status == 'disetujui')
                                                <span class="badge bg-success">Disetujui</span>
                                            @else
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->status === 'ditolak' && $item->alasan_penolakan)
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#alasanModal{{ $item->id }}">
                                                    <i class="bi bi-exclamation-circle"></i> Lihat Alasan
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="alasanModal{{ $item->id }}" tabindex="-1" aria-labelledby="alasanModalLabel{{ $item->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header text-white">
                                                                <h5 class="modal-title" id="alasanModalLabel{{ $item->id }}">Alasan Penolakan</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body text-start">
                                                                {{ $item->alasan_penolakan }}
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada pengajuan cuti.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
