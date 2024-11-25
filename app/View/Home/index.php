<?php
include_once __DIR__ . "/../Components/navbar.php";
?>

<style>
    #jumbotron {
        background-size: cover;
        background: rgb(8, 8, 109);
        background: linear-gradient(74deg, rgba(8, 8, 109, 0.6111694677871149) 0%, rgba(46, 154, 228, 0.0985644257703081) 100%), url("/images/jumbotron-about.webp") no-repeat center center fixed;
        height: 70vh;
    }

    .koro-sensei {
        transform: scalex(-1);
    }

</style>

<div class="container-fluid">
    <div class="row" id="jumbotron">
        <div class="col-12 col-md-6 d-flex justify-content-center align-items-center">
            <div class="col-10 py-3 py-lg-0">
                <h1 class="text-white  fw-bold">Jelajahi <span class="text-primary"> Anime </span>Bersama
                    Kami!</h1>
                <p class="fw-semibold text-white">Koleksi Terlengkap, Pengalaman Terbaik</p>
                <p class="card-text text-white ">Di <span class="fw-semibold  text-primary"> Maounime</span>, kami
                    berkomitmen untuk memberikan pengalaman membaca dan memberikan informasi yang luar
                    biasa dengan koleksi anime terlengkap dan fitur-fitur menarik. Temukan anime favorit Anda dan
                    bergabunglah dalam komunitas kami yang penuh semangat!</p>
                <a href="/anime/search" class="btn btn-primary fw-semibold ">Jelajahi Sekarang</a>
            </div>
        </div>
        <div class="col-md-6 d-none d-md-block text-center align-content-center px-2 py-2">
            <img src="/images/arima.gif" alt="arima gif" class="img-fluid w-100 opacity-25">
        </div>
    </div>
    <div class="row row-cols-1 row-cols-md-3 d-flex justify-content-center align-items-center px-md-5 py-5">
        <div class="col-md-3 py-2">
            <h2 class="card-title">10K++</h2>
            <p class="card-text">Pengguna Aktif setiap minggunya</p>
        </div>
        <div class="col-md-3 py-2">
            <h2 class="card-title">3k++</h2>
            <p class="card-text">Anime Tersimpan</p>
        </div>
        <div class="col-md-3 py-2">
            <h2 class="card-title">60++</h2>
            <p class="card-text ">Kategori dari berbagai anime</p>
        </div>
    </div>
    <div class="row bg-dark text-white d-flex justify-content-center pt-5">
        <div class="col-md-10 col-12 d-flex align-items-center">
            <div class="col-md-4 col-2 d-none d-md-block">
                <img src="/images/koro.png" alt="koro sensei" class="img-fluid koro-sensei">
            </div>
            <div class="col-12 col-md-8 d-flex justify-content-center justify-content-md-start px-3">
                <div class="col-md-8 col-12 rounded-3 bg-primary p-2">
                    <h1 class="card-title">Kenapa harus MAOUNIME?</h1>
                    <p class="card-text">Maounime adalah platform blog dan forum seputar anime yang menawarkan koleksi
                        lengkap dan berkualitas tinggi. Dengan antarmuka yang ramah pengguna, kalian dapat dengan mudah
                        menemukan dan membaca lebih lanjut mengenai anime favorit kalian kapan saja, di mana saja.
                        Bergabunglah dengan komunitas kami untuk mendapatkan rekomendasi dan berbagi pendapat. Temukan
                        dunia anime yang tak terbatas bersama Maounime!</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row bg-dark text-white d-flex justify-content-center px-5 pt-3 pt-lg-0">
        <h2>Fitur Utama</h2>
    </div>
    <div class="row bg-dark text-white d-flex justify-content-around pb-5 px-5">
        <div class="col-md-3 rounded-3 my-2 bg-primary py-2">
            <h2 class="card-title fs-5">Koleksi Anime Lengkap</h2>
            <p class="card-text small">Nikmati ribuan judul anime dari berbagai genre, mulai dari aksi, romansa, hingga
                fantasi. Selalu ada sesuatu untuk semua orang!</p>
        </div>
        <div class="col-md-3 rounded-3 my-2 bg-primary py-2">
            <h2 class="card-title fs-5">Antarmuka Ramah Pengguna</h2>
            <p class="card-text small">Navigasi yang mudah dan intuitif memungkinkan Anda menemukan anime dengan cepat
                dan nyaman.</p>
        </div>
        <div class="col-md-3 rounded-3 my-2 bg-primary py-2">
            <h2 class="card-title fs-5">Komunitas Aktif</h2>
            <p class="card-text small ">Bergabunglah dengan penggemar anime lainnya, diskusikan episode terbaru, dan
                berbagi rekomendasi dalam forum kami.</p>
        </div>
    </div>
    <div class="row d-flex justify-content-center align-items-center py-lg-5 bg-dark">
        <div class="col-md-10 col-lg-6 col-12 d-flex">
            <div class="bg-white text-dark rounded-3 py-2 px-3">
                <h1 class="card-title">Bergabunglah di Maounime!</h1>
                <p class="card-text">Temukan anime favorit Anda di Maounime! Daftar sekarang untuk menikmati informasi
                    dan fakta menarik seputar anime dan bergabung dengan komunitas penggemar yang seru!</p>
                <a href="/users/register" class="btn btn-primary ">Bergabung Sekarang</a>
            </div>
            <img src="/images/ghibli.png" alt="anime ghiblis" class="d-none d-md-block w-25 img-fluid">
        </div>
    </div>
</div>