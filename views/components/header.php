<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Focus</title>
    <link rel="icon" href="https://static.wikia.nocookie.net/ultra-custom-night/images/f/f6/Purple_Freddy.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <style>
        <?php require 'views/css/global.css'; ?>
    </style>
</head>
<script>
    function addToCart() {
        swal({
            icon: 'success',
            title: '🎉',
            text: 'The course has been added to your cart.',
            confirmButtonText: 'OK'
        });
    };
</script>