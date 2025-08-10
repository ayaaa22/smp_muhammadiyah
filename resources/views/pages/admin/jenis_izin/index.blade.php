@extends('layouts.master')

@section('content')
    <div class="page-heading mb-4">
        <h3>Daftar Jenis Izin</h3>
    </div>

    <div class="page-content">
        <section class="row">
            <div class="card shadow rounded">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Daftar Jenis Izin</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahIzin">
                        <i class="bi bi-plus-circle"></i> Tambah Jenis Izin
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped align-middle">
                            <thead class="table-primary">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Perlu Bukti?</th>
                                    <th>Izin Dinas?</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jenisIzin as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $item->kode }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td class="text-center">
                                            @if ($item->perlu_bukti)
                                                <span class="badge bg-success">Ya</span>
                                            @else
                                                <span class="badge bg-secondary">Tidak</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($item->is_dinas)
                                                <span class="badge bg-info">Ya</span>
                                            @else
                                                <span class="badge bg-secondary">Tidak</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <!-- Tombol Edit -->
                                            <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal"
                                                data-bs-target="#modalEditIzin{{ $item->id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('jenis-izin.destroy', $item->id) }}" method="POST"
                                                style="display:inline-block" id="formDelete{{ $item->id }}">
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
                                        <td colspan="6" class="text-center">Tidak ada data jenis izin.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal Tambah Jenis Izin -->
        <div class="modal fade" id="modalTambahIzin" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('jenis-izin.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Jenis Izin</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Kode <small>(Huruf Kapital)</small></label>
                                <input type="text" name="kode" class="form-control text-uppercase" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Jenis Izin</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="form-check mb-3">
                                <input type="checkbox" name="perlu_bukti" id="perlu_bukti" class="form-check-input">
                                <label for="perlu_bukti" class="form-check-label">Perlu Upload Bukti?</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" name="is_dinas" id="is_dinas" class="form-check-input">
                                <label for="is_dinas" class="form-check-label">Termasuk Izin Dinas?</label>
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

        <!-- Modal Edit Jenis Izin -->
        @foreach ($jenisIzin as $item)
            <div class="modal fade" id="modalEditIzin{{ $item->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="{{ route('jenis-izin.update', $item->id) }}" method="POST">
                            @csrf @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Jenis Izin</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Tampilkan error validasi -->
                                @if ($errors->any())
                                    <div class="alert alert-danger mb-3">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <!-- Field Kode -->
                                <div class="mb-3">
                                    <label class="form-label">Kode <small>(3 karakter)</small></label>
                                    <input type="text" name="kode" class="form-control text-uppercase"
                                        value="{{ old('kode', $item->kode) }}" required maxlength="3">
                                </div>

                                <!-- Field Nama -->
                                <div class="mb-3">
                                    <label class="form-label">Nama Jenis Izin</label>
                                    <input type="text" name="nama" class="form-control"
                                        value="{{ old('nama', $item->nama) }}" required>
                                </div>

                                <!-- Field Deskripsi -->
                                <div class="mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $item->deskripsi) }}</textarea>
                                </div>

                                <!-- Checkbox Perlu Bukti -->
                                <div class="form-check mb-3">
                                    <input type="hidden" name="perlu_bukti" value="0">
                                    <input type="checkbox" name="perlu_bukti" id="perlu_bukti_edit{{ $item->id }}"
                                        class="form-check-input" value="1"
                                        {{ old('perlu_bukti', $item->perlu_bukti) ? 'checked' : '' }}>
                                    <label for="perlu_bukti_edit{{ $item->id }}" class="form-check-label">Perlu
                                        Upload Bukti?</label>
                                </div>

                                <!-- Checkbox Izin Dinas -->
                                <div class="form-check mb-3">
                                    <input type="hidden" name="is_dinas" value="0">
                                    <input type="checkbox" name="is_dinas" id="is_dinas_edit{{ $item->id }}"
                                        class="form-check-input" value="1"
                                        {{ old('is_dinas', $item->is_dinas) ? 'checked' : '' }}>
                                    <label for="is_dinas_edit{{ $item->id }}" class="form-check-label">Termasuk Izin
                                        Dinas?</label>
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
