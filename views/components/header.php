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
    function addToCart(id) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        if (cart.includes(id)) {
            swal('The course is already in your cart.', {
                title: '😵‍💫',
                icon: 'info',
            });
        } else {
            swal({
            icon: 'info',
            title: '🧐',
            text: 'Do you want to add this course to your cart?',
            buttons: true,
            dangerMode: true,
            }).then((willAdd) => {
            if (willAdd) {
                cart.push(id);
                localStorage.setItem('cart', JSON.stringify(cart));
                swal('The course has been added to your cart.', {
                    title: '💸',
                    icon: 'success',
                });
            }
            });
        }
    };
</script>