@extends('layouts.app')

@section('title', 'Log-layanan')

@section('content')
<div class="container">
    <h2 style="color: white">Log Layanan</h2>
    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
        <table class="table table-bordered table-striped mt-2">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Nomer Hp</th>
                    <th>Layanan</th>
                    <th>Detail</th>
                    <th>Waktu</th> <!-- New Column for Time -->
                </tr>
            </thead>
            <tbody>
                @foreach($services as $service)
                    <tr>
                        <td>{{ $service->name }}</td>
                        <td>{{ $service->email }}</td>
                        <td>{{ $service->phone }}</td>
                        <td>{{ $service->service }}</td>
                        <td>{{ $service->details }}</td>
                        <td>{{ $service->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB</td> <!-- Displaying Time in WIB -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
