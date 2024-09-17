<?php
    require 'views/components/header.php';
    require 'views/components/navbar.php';
?>
<div class="container mx-auto">
    <h1 class="text-8xl text-secondary text-center font-extrabold tracking-wide">FOCUS</h1>
    <div class="w-full text-lg text-color font-semibold text-center mt-5">A better you, one course away</div>
    <div class="w-full text-4xl text-secondary font-bold my-5">
        Best seller
    </div>
    <div class="w-full h-[500px] flex flex-col items-center sm:flex-row overflow-y-hidden overflow-x-auto">
        <?php
            require 'views/components/courseCard.php';
            require 'views/components/courseCard.php';
            require 'views/components/courseCard.php';
        ?>
    </div>
</div>