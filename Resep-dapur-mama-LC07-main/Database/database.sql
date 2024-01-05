CREATE DATABASE IF NOT EXISTS resep_dapur_mama;
USE resep_dapur_mama;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    session_id VARCHAR(255),
    UNIQUE KEY unique_username (username),
    UNIQUE KEY unique_email (email)
);

CREATE TABLE IF NOT EXISTS resep (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    gambar VARCHAR(255) NOT NULL,
    rating DECIMAL(3,1) NOT NULL,
    daerah_asal VARCHAR(100) NOT NULL,
    rasa VARCHAR(100) NOT NULL,
    halal BOOLEAN NOT NULL,
    vegetarian BOOLEAN NOT NULL
);

INSERT INTO resep (judul, gambar, rating, daerah_asal, rasa, halal, vegetarian) 
VALUES 
    ('Nasi Babi', 'nasi_babi.jpg', 4.5, 'Indonesia', 'Gurih', false, false),
    ('Ayam Bakar Taliwang', 'ayam_bakar.jpg', 4.2, 'Lombok', 'Pedas', true, false),
    ('Mie Goreng Jawa', 'mie_goreng.jpg', 4.0, 'Jawa', 'Gurih', true, false),
    ('Capcay Kuah', 'capcay.jpg', 4.8, 'Tiongkok', 'Gurih', true, true),
    ('Sate Ayam Madura', 'sate_ayam.jpg', 4.7, 'Madura', 'Pedas', true, false);