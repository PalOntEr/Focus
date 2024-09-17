<?php
    require 'views/components/header.php';
    require 'views/components/navbar.php';
?>
<div class="container mx-auto">
    <h1 class="text-5xl text-center font-bold">Focus</h1>
    <h1 class="text-7xl text-center font-bold">Education</h1>
    <div class="w-full text-lg text-center mt-5">A better you, one course away</div>
    <div class="w-full text-4xl font-semibold my-5">
        Best seller
    </div>
    <div class="w-full h-[500px] flex overflow-y-hidden overflow-x-scroll">
        <?php
            require 'views/components/courseCard.php';
            require 'views/components/courseCard.php';
            require 'views/components/courseCard.php';
        ?>
    </div>
</div>