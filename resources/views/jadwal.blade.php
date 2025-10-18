@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center fw-bold">Atur Jadwal Konsultasi</h2>

    {{-- Blade Component Form Jadwal --}}
    <x-form-jadwal :jadwal="$jadwal ?? null" />

    <hr class="my-5">

    <h3 class="mb-3 text-center">Daftar Jadwal Anda</h3>
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead class="table-danger">
                <tr>
                    <th>No</th>
                    <th>Nama Konsultan</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($daftarJadwal as $j)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $j->nama_konsultan }}</td>
                        <td>{{ $j->tanggal }}</td>
                        <td>{{ $j->waktu }}</td>
                        <td>{{ $j->catatan }}</td>
                        <td>
                            <form action="{{ route('hapus.jadwal', $j->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Belum ada jadwal konsultasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection