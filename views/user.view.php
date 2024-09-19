<?php
require 'views/components/header.php';
require 'views/components/navbar.php';
?>
<div id="User-container" class="container mx-auto">
    <div class="flex flex-row place-content-center lg:place-content-between">
        <div class="flex">
            <a href="/user" class="self-center"><img class="md:flex md:h-48 md:w-48 hidden" src="https://www.iconpacks.net/icons/2/free-user-icon-3296-thumb.png" alt=""></a>
            <div class="self-center">
                <h2 id="User-Role" class="text-4xl text-center md:text-left text-secondary font-semibold">User Role</h2>
                <h1 id="User" class="text-8xl text-primary font-extrabold">User</h1>
                <p id="User-Info" class="text-secondary">Registered in November 2024 Age: 24 years/p>
            </div>
        </div>
        <div id="User-Settings-Container" class="hidden lg:flex md:flex-row place-self-end w-auto  mb-2">
            <input type="button" class="mx-2 py-1 px-2 text-sm text-color bg-secondary rounded-md" value="Edit Profile"></input>
            <input type="button" class="mx-2 py-1 px-2 text-sm text-color bg-secondary rounded-md" onclick="location.href='/kardex';" value="Kardex"></input>
            <input type="button" class="mx-2 py-1 px-2 text-sm text-color bg-secondary rounded-md" onclick="location.href='/sales';" value="Sales"></input>
            <input type="button" class="ml-2 py-1 px-2 text-sm text-color bg-secondary rounded-md" onclick="location.href='/reporte';" value="Report"></input>
        </div>
    </div>
    <div class="w-full h-1 bg-comp-2"></div>

    <div class="w-full text-4xl text-secondary font-bold my-5">
        Recommended by User
    </div>
    <div id="Courses-container" class="w-full h-[500px] flex flex-col items-center sm:flex-row overflow-y-hidden overflow-x-scroll">
        <?php
        require 'views/components/courseCard.php';
        require 'views/components/courseCard.php';
        require 'views/components/courseCard.php';
        ?>
    </div>
</div>