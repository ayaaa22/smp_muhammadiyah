@extends('layouts.master')

@section('content')
    <div class="page-heading mb-4">
        <h3>Persetujuan Cuti Pegawai</h3>
    </div>

    <div class="page-content">
        <section class="row">
            <div class="card shadow rounded">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pegawai</th>
                                    <th>Jenis Cuti</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pengajuanCuti as $item)
                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->pegawai->user->name }}</td>
                                        <td>{{ $item->jenisCuti->nama_cuti }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }} -
                                            {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                                        </td>
                                        <td>
                                            @if ($item->status === 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif ($item->status === 'disetujui')
                                                <span class="badge bg-success">Disetujui</span>
                                            @else
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-info text-white" data-bs-toggle="modal"
                                                data-bs-target="#detailModal{{ $item->id }}">
                                                <i class="bi bi-search"></i> Detail
                                            </button>
                                        </td>
                                    </tr>

                                    {{-- Modal Detail Pengajuan --}}
                                    <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1"
                                        aria-labelledby="detailModalLabel{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="detailModalLabel{{ $item->id }}">Detail
                                                        Pengajuan Cuti</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-start">
                                                    <p><strong>Nama Pegawai:</strong> {{ $item->pegawai->user->name }}</p>
                                                    <p><strong>Jenis Cuti:</strong> {{ $item->jenisCuti->nama_cuti }}</p>
                                                    <p><strong>Tanggal Mulai:</strong>
                                                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d F Y') }}
                                                    </p>
                                                    <p><strong>Tanggal Selesai:</strong>
                                                        {{ \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d F Y') }}
                                                    </p>
                                                    <p><strong>Durasi:</strong>
                                                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($item->tanggal_selesai)) + 1 }}
                                                        hari
                                                    </p>
                                                    <p><strong>Alasan Cuti:</strong> {{ $item->alasan_cuti ?? '-' }}</p>
                                                    @if ($item->alasan_penolakan)
                                                        <p><strong>Alasan Penolakan:</strong> {{ $item->alasan_penolakan }}
                                                        </p>
                                                    @endif
                                                    <p><strong>Status:</strong>
                                                        @if ($item->status === 'pending')
                                                            <span class="badge bg-warning text-dark">Pending</span>
                                                        @elseif ($item->status === 'disetujui')
                                                            <span class="badge bg-success">Disetujui</span>
                                                        @else
                                                            <span class="badge bg-danger">Ditolak</span>
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    @if ($item->status === 'pending')
                                                        <div class="w-100">
                                                            {{-- Tombol Setujui --}}
                                                            <form
                                                                action="{{ route('cuti.kepsek.persetujuan', $item->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-success">
                                                                    <i class="bi bi-check-circle"></i> Setujui
                                                                </button>
                                                            </form>

                                                            {{-- Tombol Tolak --}}
                                                            <button type="button" class="btn btn-danger"
                                                                onclick="toggleTolakForm({{ $item->id }})">
                                                                <i class="bi bi-x-circle"></i> Tolak
                                                            </button>

                                                            {{-- Form Tolak (Awalnya tersembunyi) --}}
                                                            <div class="form-tolak-wrapper mt-2 w-100 d-none">
                                                                <form id="formTolak{{ $item->id }}"
                                                                    action="{{ route('cuti.kepsek.penolakan', $item->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <div class="input-group mb-2">
                                                                        <input type="text" name="alasan_penolakan"
                                                                            class="form-control"
                                                                            placeholder="Masukkan alasan penolakan"
                                                                            required>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-danger w-100">
                                                                        Kirim Penolakan
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada pengajuan cuti yang menunggu
                                            persetujuan.</td>
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

@section('js')
    <script>
        function toggleTolakForm(id) {
            // Ubah selector untuk mencari div wrapper yang mengandung form
            const formWrapper = document.querySelector(`#detailModal${id} .form-tolak-wrapper`);
            formWrapper.classList.toggle('d-none');

            // Scroll ke form jika ditampilkan
            if (!formWrapper.classList.contains('d-none')) {
                formWrapper.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            }
        }
    </script>
@endsection
