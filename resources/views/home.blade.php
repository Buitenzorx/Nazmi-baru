@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="container">
        <!-- Judul Halaman -->
        <header>
            <h1 style="font-size: 50px; font-weight: bold; color: white; text-align: center;">PAM SIMAS SAGARA</h1>
        </header>
        
        <!-- Logo -->
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="{{ asset('Nazmi-baru/public/img/logo-kpspams.png') }}" alt="Logo PAM SIMAS SAGARA" style="width: 200px;">
        </div>
        
        <!-- Peta -->
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="{{ asset('Nazmi-baru/public/img/Peta.jpeg') }}" alt="Peta Lokasi PAM SIMAS SAGARA" style="width: 350px;">
        </div>
        
        <!-- Alamat -->
        <p style="font-size: 20px; font-weight: bold; color: white; text-align: center; margin-bottom: 20px;">
            Alamat: Desa Sindangkerta, Kecamatan Sindangkerta, Kabupaten Bandung Barat, Jawa Barat, Indonesia
        </p>
        
        <!-- Tautan Google Maps -->
        <p style="font-size: 20px; font-weight: bold; color: white; text-align: center;">
            Lokasi kami: <a href="https://www.google.com/maps/search/?api=1&query=2C76+955%2C+Sindangkerta%2C+West+Bandung+Regency%2C+West+Java+40563" target="_blank" style="color: aqua;">Klik di sini untuk melihat lokasi di Google Maps</a>
        </p>
        
        <!-- Informasi Organisasi -->
        <section class="info-section" style="margin-top: 20px;">
            <p style="font-size: 20px; font-weight: bold; color: white; text-align: center;">
                PAM SIMAS SAGARA adalah organisasi penyedia air bersih di Desa Sindangkerta. Organisasi ini berkomitmen untuk memastikan akses air bersih yang berkualitas bagi masyarakat. Kami mengelola beberapa sumber air dan menggunakan teknologi terbaru untuk memastikan distribusi yang efisien dan berkelanjutan. Kami melayani daerah Kp Cibungur, Kp Peusinggirang, Kp bojongtangkalak, dan Kp Gandok dengan pannjang jaringan lebih dari 3 km.
            </p>
        </section>
    </div>
@endsection
