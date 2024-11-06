<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/bootstrap/bootstrap.min.css">
    <script src="/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.14.3/dist/sweetalert2.all.min.js
"></script>
    <link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.14.3/dist/sweetalert2.min.css
" rel="stylesheet">
    <link rel="stylesheet" href="/style/card.css">
    <script src="/script/jquery-3.7.1.min.js"></script>

    <title><?= 'MaouNime | ' . $model['title'] ?? 'Maounime' ?></title>
</head>

<body>

<?php
use MoView\App\Flasher;
Flasher::FLASH();
?>