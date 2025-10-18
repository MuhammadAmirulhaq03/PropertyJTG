@extends('layouts.app') {{-- Sesuaikan dengan layout project kamu --}}

@section('content')
<div class="container">
    <h2 class="mb-4">Booking Contractor</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('contractor.store') }}" method="POST">
        @csrf

        <fieldset style="border: 1px solid #e74c3c; padding: 20px; border-radius: 10px;">
            <legend><strong style="color:#e74c3c;">Identitas Pelanggan</strong></legend>

            <div class="form-group mb-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label>Alamat Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label>Nomor Telepon</label>
                <input type="text" name="phone" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-control" required>
            </div>
        </fieldset>

        <fieldset class="mt-4" style="border: 1px solid #e74c3c; padding: 20px; border-radius: 10px;">
            <legend><strong style="color:#e74c3c;">Deskripsi Kebutuhan Proyek</strong></legend>

            <div class="row">
                <div class="form-group mb-3 col-md-6">
                    <label>Luas Bangunan/Lahan</label>
                    <input type="text" name="luas_bangunan_lahan" class="form-control">
                </div>

                <div class="form-group mb-3 col-md-6">
                    <label>Titik Lokasi</label>
                    <input type="text" name="titik_lokasi" class="form-control">
                </div>
            </div>

            <div class="form-group mb-3">
                <label>Pesan Singkat</label>
                <textarea name="pesan" class="form-control" rows="3"></textarea>
            </div>
        </fieldset>

        <button type="submit" class="btn btn-danger mt-3">Submit</button>
    </form>
</div>
@endsection
