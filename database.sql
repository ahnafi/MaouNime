-- Membuat database moview
CREATE DATABASE maounime;

-- CREATE DATABASE maounime_test;

-- Menggunakan database moview
USE maounime;

-- Tabel users untuk menyimpan data pengguna
CREATE TABLE users (
    id VARCHAR(255) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
) ENGINE InnoDB;

-- Tabel sessions untuk menyimpan sesi pengguna
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id VARCHAR(255) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE InnoDB;

-- Tabel anime untuk menyimpan data penting anime yang dikomentari atau di-watchlist
CREATE TABLE animes (
    id INT PRIMARY KEY,
    title VARCHAR(255) NOT NULL
) ENGINE InnoDB;

-- Tabel comments untuk menyimpan komentar pengguna pada anime
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(255) NOT NULL,
    anime_id INT NOT NULL,
    comment TEXT NOT NULL,
    commented_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (anime_id) REFERENCES animes(id) ON DELETE CASCADE
) ENGINE InnoDB;

-- Tabel watchlist untuk menyimpan anime yang di-watchlist oleh pengguna
CREATE TABLE watchlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(255) NOT NULL,
    anime_id INT NOT NULL,
    status varchar(30) NOT NULL,
    img varchar(255) NOT NULL ,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (anime_id) REFERENCES animes(id) ON DELETE CASCADE,
    UNIQUE (user_id, anime_id) -- Agar user tidak menambahkan anime yang sama lebih dari sekali
) ENGINE InnoDB;

-- Tabel ratings untuk menyimpan rating yang diberikan pengguna pada anime
CREATE TABLE ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(255) NOT NULL,
    anime_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 10), -- Rating antara 1 sampai 5
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (anime_id) REFERENCES animes(id) ON DELETE CASCADE,
    UNIQUE (user_id, anime_id) -- Agar seorang user hanya dapat memberikan rating sekali pada anime yang sama
) ENGINE InnoDB;
