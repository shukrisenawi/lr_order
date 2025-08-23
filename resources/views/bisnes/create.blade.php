@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Tambah Bisnes Baru</h5>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('bisnes.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="nama_bines" class="form-label">Nama Bisnes *</label>
                                <input type="text" class="form-control @error('nama_bines') is-invalid @enderror"
                                    id="nama_bines" name="nama_bines" value="{{ old('nama_bines') }}" required>
                                @error('nama_bines')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nama_syarikat" class="form-label">Nama Syarikat *</label>
                                <input type="text" class="form-control @error('nama_syarikat') is-invalid @enderror"
                                    id="nama_syarikat" name="nama_syarikat" value="{{ old('nama_syarikat') }}" required>
                                @error('nama_syarikat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="no_pendaftaran" class="form-label">No Pendaftaran *</label>
                                <input type="text" class="form-control @error('no_pendaftaran') is-invalid @enderror"
                                    id="no_pendaftaran" name="no_pendaftaran" value="{{ old('no_pendaftaran') }}" required>
                                @error('no_pendaftaran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="jenis_bisnes" class="form-label">Jenis Bisnes *</label>
                                <input type="text" class="form-control @error('jenis_bisnes') is-invalid @enderror"
                                    id="jenis_bisnes" name="jenis_bisnes" value="{{ old('jenis_bisnes') }}" required>
                                @error('jenis_bisnes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="exp_date" class="form-label">Tarikh Tamat *</label>
                                <input type="date" class="form-control @error('exp_date') is-invalid @enderror"
                                    id="exp_date" name="exp_date" value="{{ old('exp_date') }}" required>
                                @error('exp_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat *</label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3"
                                    required>{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="poskod" class="form-label">Poskod *</label>
                                <input type="text" class="form-control @error('poskod') is-invalid @enderror"
                                    id="poskod" name="poskod" value="{{ old('poskod') }}" required>
                                @error('poskod')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="no_tel" class="form-label">No Telefon *</label>
                                <input type="tel" class="form-control @error('no_tel') is-invalid @enderror"
                                    id="no_tel" name="no_tel" value="{{ old('no_tel') }}" required>
                                @error('no_tel')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="gambar" class="form-label">Gambar (Optional)</label>
                                <input type="file" class="form-control @error('gambar') is-invalid @enderror"
                                    id="gambar" name="gambar" accept="image/*">
                                @error('gambar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('bisnes.index') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
