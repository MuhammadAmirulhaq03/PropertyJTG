<div class="card shadow-sm p-4">
    <form action="{{ route('simpan.jadwal') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Konsultan</label>
            <input type="text" name="nama_konsultan" class="form-control" value="{{ old('nama_konsultan', $jadwal->nama_konsultan ?? '') }}" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $jadwal->tanggal ?? '') }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Waktu</label>
                <input type="time" name="waktu" class="form-control" value="{{ old('waktu', $jadwal->waktu ?? '') }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Catatan</label>
            <textarea name="catatan" rows="3" class="form-control">{{ old('catatan', $jadwal->catatan ?? '') }}</textarea>
        </div>

        <button type="submit" class="btn btn-danger w-100 fw-semibold">Simpan Jadwal</button>
    </form>
</div>