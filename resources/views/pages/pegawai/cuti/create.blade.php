@extends('layouts.master')

@section('content')
    <div class="page-heading mb-4">
        <h3>Ajukan Cuti</h3>
    </div>

    <div class="page-content">
        <section class="row">
            <div class="card shadow rounded">
                <div class="card-body">
                    <form action="{{ route('cuti.pegawai.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="id_jenis_cuti" class="form-label">Jenis Cuti</label>
                            <select name="id_jenis_cuti" id="id_jenis_cuti" class="form-select @error('id_jenis_cuti') is-invalid @enderror" required>
                                <option value="">-- Pilih Jenis Cuti --</option>
                                @foreach ($jenisCutiTersedia as $cuti)
                                    <option value="{{ $cuti->id }}" {{ old('id_jenis_cuti') == $cuti->id ? 'selected' : '' }}>
                                        {{ $cuti->nama_cuti }} (Max: {{ $cuti->max_cuti }} hari)
                                    </option>
                                @endforeach
                            </select>
                            @error('id_jenis_cuti')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                                class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                value="{{ old('tanggal_mulai') }}" required>
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                                class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                value="{{ old('tanggal_selesai') }}" required>
                            @error('tanggal_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="alasan_cuti" class="form-label">Alasan Cuti</label>
                            <textarea name="alasan_cuti" id="alasan_cuti" rows="4"
                                class="form-control @error('alasan_cuti') is-invalid @enderror"
                                placeholder="Tulis alasan cuti (opsional)">{{ old('alasan_cuti') }}</textarea>
                            @error('alasan_cuti')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('cuti.pegawai.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send"></i> Ajukan Cuti
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
