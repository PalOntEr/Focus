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
    <div class="w-full h-1/2 py-5 flex flex-col justify-center items-center space-x-0 md:space-x-12 md:flex-row overflow-y-hidden overflow-x-auto">
    
    <div class="flex-col justify-center w-1/2 h-1/2 md:w-1/5 md:h-1/5 mb-5 bg-color rounded-2xl">
        <a href="/advSearch">
        <h2 class="text-center font-extrabold text-secondary text-4xl mb-3">Computer Science</h2>
        <p class="text-center text-primary text-lg font-semibold">Computer related stuff</p>
        </a>
    </div>
    <div class="flex-col justify-center w-1/2 h-1/2 md:w-1/5 md:h-1/5 mb-5 bg-color rounded-2xl">
        <a href="/advSearch">
        <h2 class="text-center font-extrabold text-secondary text-4xl mb-3">Languages</h2>
        <p class="text-center text-primary text-lg font-semibold">Languages related stuff</p>
        </a>
    </div>
    <div class="flex-col justify-center w-1/2 h-1/2 md:w-1/5 md:h-1/5 mb-5 bg-color rounded-2xl">
    <a href="/advSearch">    
    <h2 class="text-center font-extrabold text-secondary text-4xl mb-3">Engineering</h2>
        <p class="text-center text-primary text-lg font-semibold">Engineering related stuff</p>
    </a>
    </div>
    </div>
</div>