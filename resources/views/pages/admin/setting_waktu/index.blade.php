@extends('layouts.master')

@section('content')
    <div class="page-heading mb-4">
        <h3>Pengaturan Waktu Presensi</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="card shadow rounded">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Daftar Waktu Presensi</h4>
                    <div>
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahWaktu">
                            <i class="bi bi-plus-circle"></i> Tambah Waktu Presensi
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped align-middle">
                            <!-- Bagian tabel -->
                            <thead class="table-primary text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Hari</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($settingWaktu as $item)
                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->hari }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->jam_pulang)->format('H:i') }}</td>
                                        <td>{{ $item->keterangan ?? '-' }}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary me-1"
                                                data-bs-toggle="modal" data-bs-target="#modalEditWaktu{{ $item->id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form id="formDelete{{ $item->id }}"
                                                action="{{ route('waktu.destroy', $item->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    onclick="confirmDelete({{ $item->id }})">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada data pengaturan waktu.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal Tambah -->
        <div class="modal fade" id="modalTambahWaktu" tabindex="-1" aria-labelledby="modalTambahWaktuLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('waktu.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahWaktuLabel">Tambah Waktu Presensi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="hari" class="form-label">Hari</label>
                                <select name="hari" id="hari" class="form-control" required>
                                    @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $hari)
                                        <option value="{{ $hari }}">{{ $hari }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="jam_masuk" class="form-label">Jam Masuk</label>
                                <input type="time" name="jam_masuk" id="jam_masuk" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="jam_pulang" class="form-label">Jam Pulang</label>
                                <input type="time" name="jam_pulang" id="jam_pulang" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <input type="text" name="keterangan" id="keterangan" class="form-control"
                                    placeholder="Contoh: Masuk / Pulang">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        @foreach ($settingWaktu as $item)
            <div class="modal fade" id="modalEditWaktu{{ $item->id }}" tabindex="-1"
                aria-labelledby="modalEditWaktuLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="{{ route('waktu.update', $item->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalEditWaktuLabel{{ $item->id }}">Edit Waktu Presensi
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="hari{{ $item->id }}" class="form-label">Hari</label>
                                    <select name="hari" id="hari{{ $item->id }}" class="form-control" required>
                                        @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $hari)
                                            <option value="{{ $hari }}"
                                                @if ($item->hari == $hari) selected @endif>{{ $hari }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="jam_masuk{{ $item->id }}" class="form-label">Jam Masuk</label>
                                    <input type="time" name="jam_masuk" id="jam_masuk{{ $item->id }}"
                                        class="form-control"
                                        value="{{ \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="jam_pulang{{ $item->id }}" class="form-label">Jam Pulang</label>
                                    <input type="time" name="jam_pulang" id="jam_pulang{{ $item->id }}"
                                        class="form-control"
                                        value="{{ \Carbon\Carbon::parse($item->jam_pulang)->format('H:i') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="keterangan{{ $item->id }}" class="form-label">Keterangan</label>
                                    <input type="text" name="keterangan" id="keterangan{{ $item->id }}"
                                        class="form-control" value="{{ $item->keterangan }}">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
