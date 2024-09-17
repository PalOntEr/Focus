<?php
    require 'views/components/header.php';
    require 'views/components/navbar.php';
?>
<div class="container mx-auto">
    <h2 class="text-xl text-center font-semibold mt-2">Bienvenido a</h2>
    <h1 class="text-5xl text-center font-bold">Focus</h1>
    <h1 class="text-7xl text-center font-bold">Education</h1>
    <div class="w-full text-lg text-center mt-5">Tu mejor versión, a un curso de distancia</div>
    <div class="w-full text-4xl font-semibold my-5">
        Los mas vendidos
    </div>
    <div class="w-full h-[500px] flex overflow-y-hidden overflow-x-scroll">
        <?php
            require 'views/components/courseCard.php';
            require 'views/components/courseCard.php';
            require 'views/components/courseCard.php';
        ?>
    </div>
</div>