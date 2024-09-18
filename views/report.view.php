<?php
require 'views/components/header.php';
require 'views/components/navbar.php';
?>
<div class="container mx-auto">
    <div id="Kardex-Title-Container" class="flex flex-row place-content-between">
        <div>
            <h2 class="text-4xl text-center md:text-left text-comp-1 font-semibold">Rol de Usuario</h2>
            <h1 class="text-8xl text-primary font-extrabold">Reporte</h1>
        </div>
        <div class="self-end text-primary">
            <button>Descargar</button>
        </div>
    </div>

    <div class="h-1 w-full bg-secondary my-6"></div>
        <div id="UserReports-Table-Container">
            <table id="Full-Students-Reports" class="table-auto w-full">
                <thead class="bg-primary text-color">
                    <tr>
                        <th class="rounded-tl-lg py-2">Usuario</th>
                        <th>Nombre</th>
                        <th>Fecha de Alta</th>
                        <th>Cursos Inscritos</th>
                        <th class=" rounded-tr-lg">Cursos Terminados</th>
                    </tr>
                </thead>
                <tbody class="text-center font-semibold">
                    <tr class="bg-comp-1 text-primary">
                        <td class="py-2">Curso 1</td>
                        <td>540</td>
                        <td>7</td>
                        <td>25/04/2022</td>
                        <td>25/04/2022</td>
                    </tr>
                    <tr class="bg-comp-2 text-primary">
                    <td class="py-2">Curso 1</td>
                        <td>540</td>
                        <td>7</td>
                        <td>25/04/2022</td>
                        <td>25/04/2022</td>
                    </tr>

                    <tr class="bg-comp-1 text-primary">
                    <td class="py-2">Curso 1</td>    
                    <td>540</td>
                        <td>7</td>
                        <td>25/04/2022</td>
                        <td>25/04/2022</td>
                    </tr>
                    <tr class="bg-comp-2 text-primary">
                        <td class="py-2 rounded-bl-lg">Curso 1</td>

                        <td>540</td>
                        <td>7</td>
                        <td>25/04/2022</td>
                        <td class="rounded-br-lg">25/04/2022</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="TeacherReports-Table-Container" class="mt-6">
            <table id="Full-Teachers-Reports" class="table-auto w-full">
                <thead class="bg-primary text-color">
                    <tr>
                        <th class="rounded-tl-lg py-2">Usuario</th>
                        <th>Nombre</th>
                        <th>Fecha de Alta</th>
                        <th>Cursos Creados</th>
                        <th class=" rounded-tr-lg">Ganancias</th>
                    </tr>
                </thead>
                <tbody class="text-center font-semibold">
                    <tr class="bg-comp-1 text-primary">
                        <td class="py-2">Roberto Carlos</td>
                        <td>540</td>
                        <td>25/04/2022</td>
                        <td>7</td>
                        <td>500$</td>
                    </tr>
                    <tr class="bg-comp-2 text-primary">
                        <td class="py-2 rounded-bl-lg">Max Andrés</td>
                        <td>540</td>
                        <td>25/04/2022</td>
                        <td>7</td>
                        <td class="rounded-br-lg">500$</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>