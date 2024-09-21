<?php
require 'views/components/header.php';
require 'views/components/navbar.php';
?>
<div class="container mx-auto">
    <div id="Kardex-Title-Container" class="flex flex-row place-content-between">
        <div>
            <h2 class="text-4xl text-center md:text-left text-comp-1 font-semibold">Usuario</h2>
            <h1 class="text-8xl text-primary font-extrabold">Sales</h1>
        </div>
        <div class="self-end text-primary">
            <p>Cursos Creados: 3</p>
        </div>
    </div>

    <div class="h-1 w-full bg-secondary"></div>

    <div id="Kardex-Container" class="my-4">
        <div id="Kardex-Query-Container" class="bg-primary rounded-lg flex flex-row place-content-between my-2 p-2">
            <div class="w-1/3 self-center flex space-x-3">
                <input type="button" class="bg-comp-1 text-color p-1 rounded-lg" value="Clean">
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
                <input type="date" id="DateFinish" class="w-1/3 bg-comp-1 text-color outline-none rounded-md border-0">
            </div>

            <div class="flex w-1/3 justify-end self-center">
                <input id="Active" type="checkbox" class="checked:bg-secondary">
                <label for="Active" class="">Active</label>
            </div>

        </div>
        <div id="Sales-Table-Container">
            <table id="Full-Sales" class="table-auto w-full">
                <thead class="bg-primary text-color">
                    <tr>
                        <th class="rounded-tl-lg py-2">Curso</th>
                        <th>Alumnos Inscritos</th>
                        <th>Nivel Promedio</th>
                        <th class=" rounded-tr-lg">Ingresos</th>
                    </tr>
                </thead>
                <tbody class="text-center font-semibold">
                    <tr class="bg-comp-1 text-primary">
                        <td class="py-2">Curso 1</td>
                        <td>540</td>
                        <td>7</td>
                        <td>$420.00 MXN.</td>
                    </tr>
                    <tr class="bg-comp-2 text-primary">
                        <td class="py-2">Curso 1</td>
                        <td>540</td>
                        <td>7</td>
                        <td>$420.00 MXN.</td>
                    </tr>
                    <tr class="bg-comp-1 text-primary">
                        <td class="py-2 rounded-bl-lg">Curso 1</td>
                        <td>540</td>
                        <td>7</td>
                        <td class="rounded-br-lg">$420.00 MXN.</td>
                    </tr>
                </tbody>
            </table>
            <div class="font-bolder text-2xl mt-3 mb-5"><span>INGRESOS TOTALES: </span>$1240.00 MXN</div>

            <div id="Kardex-Query-Container" class="bg-primary rounded-lg flex flex-row  my-2 p-2">
            <div class="w-1/3 self-center flex space-x-3">
                <input type="button" class="bg-comp-1 text-color p-1 rounded-lg" value="Clean">
                <select class="w-1/2 bg-comp-1 text-color py-1 outline-none rounded-md border-0">
                    <option>Course 1</option>
                    <option>Course 2</option>
                    <option>Course 3</option>
                    <option>Course 4</option>
                </select>
            </div>

            <div class="flex w-1/3 justify-between">
                <input type="date" id="DateStart" class="w-1/3 bg-comp-1 text-color outline-none rounded-md border-0">
                <div class="h-0.5 w-2 bg-primary self-center"></div>
                <input type="date" id="DateFinish" class="w-1/3 bg-comp-1 text-color outline-none rounded-md border-0">
            </div>
        </div>
            <table id="Sales-Course" class="table-auto w-full">
                <thead class="bg-primary text-color">
                    <tr>
                        <th class="rounded-tl-lg py-2">Alumno</th>
                        <th>Fecha de inscripción</th>
                        <th>Nivel</th>
                        <th>Precio Pagado</th>
                        <th class=" rounded-tr-lg">Forma de Pago</th>
                    </tr>
                </thead>
                <tbody class="text-center font-semibold">
                    <tr class="bg-comp-1 text-primary">
                        <td class="py-2">Roberto Carlos Dominguez Espinosa</td>
                        <td>21/08/2024</td>
                        <td>7</td>
                        <td>740</td>
                        <td>Unico</td>
                    </tr>
                    <tr class="bg-comp-2 text-primary">
                        <td class="py-2">Max Andrés Zertuche Perez</td>
                        <td class="rounded-bl-lg">21/08/2024</td>
                        <td>7</td>
                        <td>740</td>
                        <td class="rounded-br-lg">Unico</td>
                    </tr>
                </tbody>
            </table>
            <div class="font-bolder text-2xl mt-3"><span>INGRESOS DEL CURSO: </span>$1480.00 MXN</div>
        </div>
    </div>
</div>