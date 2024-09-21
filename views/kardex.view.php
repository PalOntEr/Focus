<?php
require 'views/components/header.php';
require 'views/components/navbar.php';
?>
<div class="container mx-auto">
    <div id="Kardex-Title-Container" class="flex flex-row place-content-between">
        <div>
            <h2 class="text-4xl text-center md:text-left text-comp-1 font-semibold">User</h2>
            <h1 class="text-8xl text-primary font-extrabold">Kardex</h1>
        </div>
        <div class="self-end text-primary">
            <p>Enrolled Courses: 3</p>
        </div>
    </div>

    <div class="h-1 w-full bg-secondary"></div>
    <div id="Kardex-Container" class="my-2">
        <div id="Kardex-Query-Container" class="bg-primary rounded-lg flex flex-row place-content-between my-2 p-2">
            <div class="w-1/4 self-center flex space-x-2">
                <input type="button" class="bg-comp-1 text-color p-1 rounded-lg" value="Clean" >
                <select class="w-1/2 bg-comp-1 text-color py-1 outline-none rounded-md border-0">
                    <option>Any</option>
                    <option>Computer Science</option>
                    <option>Languages</option>
                    <option>Engineering</option>
                </select>
            </div>

            <div class="flex w-1/2 justify-evenly">
                <input type="date" id="DateStart" class="w-1/3 bg-comp-1 text-color outline-none rounded-md border-0">
                <div class="h-0.5 w-2 bg-primary self-center"></div>
                <input type="date" id="DateFinish" class="w-1/3 bg-comp-1 text-color outline-none rounded-md border-0">
            </div>

            <div class="flex w-1/4 justify-end self-center font-semibold space-x-3">
                <div>
                    <input id="Active" type="checkbox" class="checked:bg-secondary">
                    <label for="Active" class="">Active</label>
                </div>
                <div>
                    <input id="Finished" type="checkbox" class="checked:bg-secondary">
                    <label for="Finished" class="">Finished</label>
                </div>
            </div>
        </div>
        <div id="Kardex-Table-Container">
            <table class="table-auto w-full">
                <thead class="bg-primary text-color">
                    <tr>
                        <th class="rounded-tl-lg py-2">Course</th>
                        <th>Progress</th>
                        <th>Registration date</th>
                        <th>End date</th>
                        <th>Last time visited</th>
                        <th>Completed</th>
                        <th class="rounded-tr-lg">Diploma</th>
                    </tr>
                </thead>
                <tbody class="text-center font-semibold">
                    <tr class="bg-comp-1 text-primary">
                        <td class="py-2">Course 1</td>
                        <td>97%</td>
                        <td>24/05/2024</td>
                        <td>24/05/2028</td>
                        <td>26/07/2025</td>
                        <td><input type="checkbox" checked disabled></td>
                        <td>
                            <a class="justify-center flex" onclick="downloadDiploma()" href="<?= $docRef ?>" download>
                                <img class="h-5 bg-color p-1 rounded-md" src="https://cdn-icons-png.flaticon.com/512/3580/3580085.png" alt="">
                            </a>
                        </td>
                    </tr>
                    <tr class="bg-comp-2 text-primary">
                        <td class="py-2">Course 2</td>
                        <td>97%</td>
                        <td>24/05/2024</td>
                        <td>24/05/2028</td>
                        <td>26/07/2025</td>
                        <td><input type="checkbox" checked disabled></td>
                        <td>
                            <a class="justify-center flex" onclick="downloadDiploma()" href="<?= $docRef ?>" download>
                                <img class="h-5 bg-color p-1 rounded-md" src="https://cdn-icons-png.flaticon.com/512/3580/3580085.png" alt="">
                            </a>
                        </td>
                    </tr>
                    <tr class="bg-comp-1 text-comp-2">
                        <td class="py-2 rounded-bl-lg">Course 3</td>
                        <td>97%</td>
                        <td>24/05/2024</td>
                        <td>24/05/2028</td>
                        <td>26/07/2025</td>
                        <td><input type="checkbox" checked disabled></td>
                        <td class="rounded-br-lg">
                            <a class="justify-center flex" onclick="downloadDiploma()" href="<?= $docRef ?>" download>
                                <img class="h-5 bg-color p-1 rounded-md" src="https://cdn-icons-png.flaticon.com/512/3580/3580085.png" alt="">
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    function downloadDiploma() {
        swal({
            title: 'Diploma downloaded',
            icon: 'success',
            showConfirmButton: false,
            timer: 1500
        })
    }
</script>