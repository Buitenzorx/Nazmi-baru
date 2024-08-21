@extends('layouts.app')

@section('title', 'Contact')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card my-5">
                <!-- Card Header -->
                <div class="card-header" style="background-color: #343a40; color: white;">
                    <h1 style="font-size: 40px; font-weight: bold; margin: 0;">Form Layanan</h1>
                </div>

                <!-- Card Body -->
                <div class="card-body p-5">
                    <form action="{{ route('layanan.submit') }}" method="POST">
                        @csrf
                        <div class="mb-3" style="text-align: left">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3" style="text-align: left">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3" style="text-align: left">
                            <label for="address" class="form-label">Alamat Lengkap</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="mb-3" style="text-align: left">
                            <label for="phone" class="form-label">Nomor Telepon</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3" style="text-align: left">
                            <label for="service" class="form-label">Jenis Layanan</label>
                            <select class="form-select" id="service" name="service" required>
                                <option value="Pemasangan Baru">Pemasangan Baru</option>
                                <option value="Laporan Kerusakan">Laporan Kerusakan</option>
                                <option value="Penghentian Layanan">Penghentian Layanan</option>
                                <option value="Gangguan">Gangguan</option>
                                <option value="Lainnya">Lainnya (ketik di bawah)</option>
                            </select>
                        </div>
                        <div class="mb-3" style="text-align: left">
                            <label for="details" class="form-label">Detail Permintaan atau Laporan</label>
                            <textarea class="form-control" id="details" name="details" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
