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
    <div class="w-full h-[500px] py-2 flex flex-col items-center sm:flex-row overflow-y-hidden overflow-x-auto">
        <?php
            require 'views/components/courseCard.php';
            require 'views/components/courseCard.php';
            require 'views/components/courseCard.php';
        ?>
    </div>
    <div class="w-full text-4xl text-primary font-bold my-5">
        Categories
    </div>
    
</div>