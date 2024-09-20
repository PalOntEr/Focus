<?php
    require 'views/components/header.php';
    require 'views/components/navbar.php';
?>
<div class="container mx-auto">
    <h1 class="text-8xl text-primary text-center font-extrabold tracking-wide">FOC<span class="text-secondary">US</span></h1>
    <div class="w-full text-4xl text-primary font-bold my-5">
        Best seller
    </div>
    <div class="h-1 bg-secondary"></div>
    <div class="w-full h-1/2 py-2 flex flex-col items-center md:flex-row overflow-y-hidden overflow-x-auto">
        <?php
            require 'views/components/courseCard.php';
            require 'views/components/courseCard.php';
            require 'views/components/courseCard.php';
        ?>
    </div>
    <div class="w-full text-4xl text-primary font-bold my-5">
        Categories
    </div>
    <div class="h-1 bg-secondary"></div>
    <div class="w-full h-1/2 py-5 flex flex-col items-center space-x-12 md:flex-row overflow-y-hidden overflow-x-auto">
    <div class="flex-col justify-center w-1/2 h-1/2 md:w-1/3 md:h-1/3 h-1/3 mb-5 bg-color rounded-2xl">
        <a class="place-content-center flex" href="/advSearch"><img class="h-2/3 w-2/3 rounded-2xl" src="https://cdn-icons-png.flaticon.com/512/7903/7903652.png" alt="Course"></a>
        <h2 class="text-center font-extrabold text-secondary text-4xl">Computer Science</h2>
    </div>
    <div class="flex-col justify-center w-1/2 h-1/2 md:w-1/3 md:h-1/3 mb-5 bg-color rounded-2xl">
        <a class="place-content-center flex" href="/advSearch"><img class="h-2/3 w-2/3 rounded-2xl" src="https://cdn-icons-png.flaticon.com/512/484/484633.png" alt="Course"></a>
        <h2 class="text-center font-extrabold text-secondary text-4xl">Languages</h2>
    </div>
    <div class="flex-col justify-center w-1/2 h-1/2 md:w-1/3 md:h-1/3 mb-5 bg-color rounded-2xl">
        <a class="place-content-center flex" href="/advSearch"><img class="h-2/3 w-2/3 rounded-2xl" src="https://cdn-icons-png.flaticon.com/512/2201/2201555.png" alt="Course"></a>
        <h2 class="text-center font-extrabold text-secondary text-4xl">Engineering</h2>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
</div>