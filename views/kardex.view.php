<?php
require 'views/components/header.php';
require 'views/components/navbar.php';
?>
<div class="container mx-auto">
    <div id="Kardex-Title-Container" class="flex flex-row place-content-between">
        <div>
            <h2 class="text-4xl text-center md:text-left text-comp-1 font-semibold">Usuario</h2>
            <h1 class="text-8xl text-primary font-extrabold">Kardex</h1>
        </div>
        <div class="self-end text-primary">
            <p>Cursos Inscritos: 3</p>
        </div>
    </div>

    <div class="h-1 w-full bg-secondary"></div>

    <div id="Kardex-Container" class="my-4">
        <div id="Kardex-Query-Container" class="bg-primary rounded-lg flex flex-row place-content-between my-12 p-2">
            <div class="w-1/3 self-center">
                <select class="w-1/2 bg-comp-1 text-color py-1 outline-none rounded-md border-0">
                    <option>Any</option>
                    <option>Computer Science</option>
                    <option>Languages</option>
                    <option>Engineering</option>
                </select>
            </div>

            <div class="flex w-1/3 justify-between">
                <input type="date" id="DateStart" class="w-1/3 bg-comp-1 text-color outline-none rounded-md border-0">
                <div class="h-0.5 w-2 bg-primary self-center"></div>
                <input type="date" id="DateFinish"  class="w-1/3 bg-comp-1 text-color outline-none rounded-md border-0">
            </div>

            <div class="flex w-1/3 justify-end self-center">
                <input id="Finished" type="checkbox" class="checked:bg-secondary">
                <label for="Finished" class=""> Finished</label>
            </div>
        </div>
        <div id="Kardex-Table-Container">
            <table class="table-auto w-full">
                <thead class="bg-primary text-color">
                    <tr>
                        <th class="rounded-tl-lg py-2">Curso</th>
                        <th>Progreso</th>
                        <th>Fecha de inscripción</th>
                        <th>Fecha de finalización</th>
                        <th>Ultima vez visitado</th>
                        <th class=" rounded-tr-lg">Completado</th>
                    </tr>
                </thead>
                <tbody class="text-center font-semibold">
                    <tr class="bg-comp-1 text-primary">
                        <td class="py-2">Curso 1</td>
                        <td>97%</td>
                        <td>24/05/2024</td>
                        <td>24/05/2028</td>
                        <td>26/07/2025</td>
                        <td><input type="checkbox" checked></td>
                    </tr>
                    <tr class="bg-comp-2 text-primary">
                        <td class="py-2">Curso 1</td>
                        <td>97%</td>
                        <td>24/05/2024</td>
                        <td>24/05/2028</td>
                        <td>26/07/2025</td>
                        <td><input type="checkbox" checked></td>
                    </tr>
                    <tr class="bg-comp-1 text-comp-2">
                        <td class="py-2 rounded-bl-lg">Curso 1</td>
                        <td>97%</td>
                        <td>24/05/2024</td>
                        <td>24/05/2028</td>
                        <td>26/07/2025</td>
                        <td class="rounded-br-lg"><input type="checkbox" checked></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>