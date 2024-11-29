<?php
include_once __DIR__ . "/../Components/navbar.php";

$instagram = [
    [
        'name' => 'Sulthon',
        'link' => 'https://www.instagram.com/ahnafi.s'
    ], [
        'name' => 'Banati',
        'link' => 'https://www.instagram.com/nabilabanati'
    ], [
        'name' => 'Sholem',
        'link' => 'https://www.instagram.com/ime_shoukat'
    ],
];
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

    .review-text {
        text-align: justify;
    }

    .review-card {
        padding: 15px;
        border-style: groove;
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
        <div class="col-md-3 py-2 text-center">
            <h2 class="card-title">10K++</h2>
            <p class="card-text">Pengguna Aktif setiap minggunya</p>
        </div>
        <div class="col-md-3 py-2 text-center">
            <h2 class="card-title">3k++</h2>
            <p class="card-text">Anime Tersimpan</p>
        </div>
        <div class="col-md-3 py-2 text-center">
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

    <div class="row bg-dark text-white d-flex justify-content-center px-5 pt-5 pt-lg-0">
        <h2>Komentar Para Wibu</h2>
    </div>
    <div class="row bg-dark text-white d-flex justify-content-around pb-5 px-5">
        <!-- Review 1 -->
        <div class="col-md-3 rounded-3 my-2 review-card">
            <p class="card-text small review-text">“Pengalaman membaca sinopsis di Maounime sangat menyenangkan.
                Kualitas penayangan yang bagus, tapi saya berharap ada lebih banyak subtitle bahasa lain.”</p>
            <div class="row align-items-center">
                <div class="col-auto">
                    <img src="/images/ava1.jpeg" alt="User  avatar" class="img-fluid rounded-circle ratio-1x1"
                         width="50" height="50">
                </div>
                <div class="col">
                    <p class="card-title fs-6"><strong>Andi Perdana</strong></p>
                    <div class="d-flex align-items-center">
                        <p class="card-text small mb-0 me-2">4.5/5</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="#FFD700"
                             class="bi bi-star-fill" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <!-- Review 2 -->
        <div class="col-md-3 rounded-3 my-2 review-card">
            <p class="card-text small review-text">“Antarmuka Maounime user-friendly dan omniana aktif. Saya suka
                berdiskusi tentang anime favorit di sini!”</p>
            <div class="row align-items-center">
                <div class="col-auto">
                    <img src="/images/ava2.jpeg" alt="User avatar" class="img-fluid rounded-circle ratio-1x1" width="50"
                         height="50">
                </div>
                <div class="col">
                    <p class="card-title fs-6"><strong>Sekar Cahyanita</strong></p>
                    <div class="d-flex align-items-center">
                        <p class="card-text small mb-0 me-2">4.7/5</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="#FFD700"
                             class="bi bi-star-fill" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <!-- Review 3 -->
        <div class="col-md-3 rounded-3 my-2 review-card">
            <p class="card-text small review-text">"Koleksi anime luar biasa, tapi kadang buffering. Semoga bisa
                diperbaiki untuk pengalaman yang lebih baik."</p>
            <div class="row align-items-center">
                <div class="col-auto">
                    <img src="/images/ava3.jpeg" alt="User avatar" class="img-fluid rounded-circle ratio-1x1" width="50"
                         height="50">
                </div>
                <div class="col">
                    <p class="card-title fs-6"><strong>Bagas Irwanto</strong></p>
                    <div class="d-flex align-items-center">
                        <p class="card-text small mb-0 me-2">4.0/5</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="#FFD700"
                             class="bi bi-star-fill" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                        </svg>
                    </div>
                </div>
            </div>
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

    <div class="row bg-dark text-white d-flex justify-content-center px-5 pt-5 pt-lg-0">
        <h2 class="text-center">Tetap terhubung dengan Kami</h2>
    </div>
    <div class="row bg-dark text-white d-flex justify-content-around pb-5 px-5" align-items-center>
        <div class="d-flex justify-content-around w-auto pt-2">
            <?php foreach ($instagram as $person): ?>
                <a href="<?= $person['link'] ?>" data-person="<?= $person['name'] ?>" class="mx-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#FFFFFF"
                         class="bi bi-instagram"
                         viewBox="0 0 16 16">
                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
                    </svg>
                </a>
            <?php endforeach; ?>
        </div>
    </div>