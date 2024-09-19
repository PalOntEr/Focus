<?php
    require 'views/components/header.php';
?>
<div class="w-screen h-screen overflow-x-hidden">
<?php
    require 'views/components/navbar.php';
?>
<div class="container flex flex-col mx-auto">
<h1 class="text-8xl text-primary text-center font-extrabold tracking-wide">Carrito </h1>
<div class="flex flex-row my-5">
    <div class="w-1/4 flex flex-col">
        <div id="Cart-Container" class="h-auto bg-primary rounded-md p-4">
            <div>
                <div class="font-bold text-comp-1 text-sm my-3">Total de Cursos: <span class="font-normal text-color">7</span></div>
                <div class="font-bold text-comp-1 text-sm my-3">SUBTOTAL: <span class="font-normal text-color">$524.00 MXN</span></div>
                <div class="font-bold text-comp-1 text-sm my-3">TOTAL: <span class="font-normal text-color">$480.00 MXN</span></div>
                <div class="h-px w-full bg-comp-2 my-4"></div>   
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