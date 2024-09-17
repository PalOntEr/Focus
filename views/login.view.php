<?php
require 'views/components/header.php';
?>

<div class="h-screen w-screen container mx-auto flex flex-col lg:flex-row items-center justify-center">
    <div id="Title-Container" class="lg:hidden mb-12"> 
        <h1 class="text-8xl font-extrabold tracking-wider text-secondary">FOCUS</h1>
    </div>
    <div class="bg-secondary flex w-5/6 md:w-1/2 place-content-evenly rounded-xl">
        <div id="Form-Container" class="flex flex-col mx-4 2xl:mx-6 my-12">
            <h2 class="text-primary text-3xl text-center w-full mb-6 font-bold">Iniciar Sesión</h2>
            <form class="flex flex-col justify-between h-52 font-semibold mb-4" action="/home" method="GET">
                <div>
                    <p class="text-comp-1">Usuario:</p>
                    <input type="text" class="w-full bg-transparent border-t-transparent border-b-2 outline-none text-primary" />
                </div>
                <div>
                    <p class="text-comp-1">Contraseña:</p>
                    <input type="password" class="w-full bg-transparent border-t-transparent border-b-2 outline-none text-primary" />
                </div>
                <input type="submit" value="Ingresar" class="w-1/2 self-center bg-comp-1 text-secondary rounded-md p-1" />
            </form>
            <div class="text-center text-xs w-full text-comp-1">¿No tienes cuenta? <a class="text-primary visited:text-color font-bold" href="/register">Registrarse</a></div>
        </div>

        <div class="bg-primary w-0.5 my-12 hidden lg:flex"></div>

        <div class="self-center mx-6 my-12 hidden lg:flex">
            <div id="Card-Title-Container" class="text-center">
                <h1 class="text-4xl xl:text-6xl 2xl:text-8xl font-extrabold tracking-wider text-primary">FOCUS</h1>
            </div>
        </div>
    </div>
</div>

</html>