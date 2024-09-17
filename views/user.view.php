<?php
require 'views/components/header.php';
require 'views/components/navbar.php';
?>
<div id="User-container" class="container mx-auto">
    <div class="flex flex-row place-content-center lg:place-content-between">
        <div class="flex">
            <a href="/user" class="self-center"><img class="md:flex md:h-48 md:w-48 hidden" src="https://www.iconpacks.net/icons/2/free-user-icon-3296-thumb.png" alt=""></a>
            <div class="self-center">
                <h2 id="User-Role" class="text-4xl text-center md:text-left text-comp-2 font-semibold">Rol de Usuario</h2>
                <h1 id="User" class="text-8xl text-secondary font-extrabold">Usuario</h1>
                <p id="User-Info" class="text-color">Registrado en noviembre del 2024 Edad: 24 años</p>
            </div>
        </div>
        <div id="User-Settings-Container" class="hidden lg:flex md:flex-row place-self-end w-auto  mb-2">
            <input type="button" class="mx-2 py-1 px-2 text-sm text-primary bg-secondary rounded-md" value="Editar Perfil"></input>
            <input type="button" class="mx-2 py-1 px-2 text-sm text-primary bg-secondary rounded-md" onclick="location.href='/kardex';" value="Kardex"></input>
            <input type="button" class="mx-2 py-1 px-2 text-sm text-primary bg-secondary rounded-md" value="Ventas"></input>
            <input type="button" class="ml-2 py-1 px-2 text-sm text-primary bg-secondary rounded-md" value="Reporte"></input>
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