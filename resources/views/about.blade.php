@extends('layouts.app')

@section('title', 'About')

@section('content')
    <div class="container">
        <!-- Judul Halaman -->
        <header>
            <h1 style="font-size: 50px; font-weight: bold; color: white; text-align: center;">Alat Pendeteksi Ketinggian Air Sumur</h1>
        </header>
        
        <!-- Logo -->
        <div class="row text-center mb-2">
            <div class="col-md-6">
                <img src="{{ asset('img/Alat.png') }}" alt="Alat" class="img-fluid">
            </div>
            <div class="col-md-6">
                <img src="{{ asset('img/Alat-4.png') }}" alt="Alat" class="img-fluid">
            </div>
        </div>
        
        <!-- Alamat -->
        <p style="font-size: 20px; font-weight: bold; color: white; text-align: center; margin-bottom: 20px;">
            Alamat: Desa Sindangkerta, Kecamatan Sindangkerta, Kabupaten Bandung Barat, Jawa Barat, Indonesia
        </p>
        
        <!-- Informasi Organisasi -->
        <section class="info-section mt-4">
            <p style="font-size: 20px; font-weight: bold; color: white; text-align: justify;">
                Sistem monitoring ketinggian air sumur menggunakan beberapa komponen utama untuk memastikan pengukuran yang akurat dan efisien. Sensor Infrared SEN0366 adalah perangkat yang mengukur jarak dengan menggunakan sinar laser, memungkinkan pemantauan kedalaman air sumur dengan presisi tinggi, bahkan dalam kondisi pencahayaan yang bervariasi. Mikrokontroler ESP32 bertindak sebagai pusat pengolahan data, mengumpulkan informasi dari sensor dan mengirimkannya ke server melalui koneksi Wi-Fi atau Bluetooth, berkat kemampuannya yang kuat dan konektivitas yang handal. Layar LCD I2C menampilkan data level air secara real-time, terhubung dengan mikrokontroler melalui antarmuka I2C, sehingga memudahkan pemantauan visual tanpa perangkat tambahan. Untuk menyuplai daya, adapter 5V 2A mengkonversi listrik dari sumber utama menjadi 5V DC yang stabil, memastikan semua komponen sistem beroperasi dengan lancar dan efisien.
            </p>
        </section>
        <div class="col-md-12">
            <img src="{{ asset('img/alat-5.png') }}" alt="Alat" class="img-fluid">
        </div>
        <section class="info-section mt-4">
            <p style="font-size: 20px; font-weight: bold; color: white; text-align: justify;">
                Alat kualitas air yang digunakan dalam sistem ini terdiri dari dua sensor utama: sensor pH dan sensor kekeruhan. Sensor pH berfungsi untuk mengukur tingkat keasaman atau kebasaan air, yang sangat penting untuk memastikan air berada dalam kondisi yang aman dan sesuai untuk penggunaan. Sementara itu, sensor kekeruhan mengukur tingkat kejernihan air dengan mendeteksi jumlah partikel padat tersuspensi, yang dapat menunjukkan adanya kontaminasi atau masalah kualitas air lainnya. Kedua sensor ini bekerja bersama untuk memberikan gambaran menyeluruh tentang kondisi air, sehingga tindakan yang diperlukan dapat segera diambil jika ada indikasi masalah.    
            </p>
        </section>
    </div>
@endsection
