<?php
    require 'views/components/header.php';
?>
<div class="w-screen h-screen overflow-x-hidden">
<?php
    require 'views/components/navbar.php';
?>
<div class="container flex flex-col mx-auto">
<h1 class="text-8xl text-primary text-center font-extrabold tracking-wide">Carrito </h1>
<div class="flex flex-row">
    <div class="w-1/4 flex flex-col">
        <div id="Cart-Container" class="h-auto bg-primary rounded-md p-4">
            <div class="flex flex-row justify-between">
            <div class="text-sm p-3 text-left text-color p-4">PHP Course.-$550 MXN.</div>
            <button class="">Eliminar</button>
        </div>
        <div class="h-px w-full bg-comp-2"></div>
            <div>
            <div class="font-bold text-comp-1 text-sm my-4">Total de Cursos: <span class="font-normal text-color">7</span></div>
            <div class="font-bold text-comp-1 text-sm my-4">TOTAL: <span class="font-normal text-color">$480.00 MXN</span></div>
            <div class="font-bold text-comp-1 text-sm my-4">TOTAL + IVA: <span class="font-normal text-color">$524.00 MXN</span></div>
            <button class="w-full bg-comp-1 text-sm p-2 text-color rounded-md">Pagar.</button>
            </div>
        </div>
    </div>

    <div class="w-3/4 h-full flex flex-col ml-2 items-center overflow-y-auto overflow-x-hidden">
    <?php
            require 'views/components/buycourseCard.php';
            require 'views/components/buycourseCard.php';
            require 'views/components/buycourseCard.php';
        ?>
    </div>
</div>
</div>