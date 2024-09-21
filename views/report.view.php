<?php
require 'views/components/header.php';
require 'views/components/navbar.php';
?>
<div class="container mx-auto">
    <div id="Report-Title-Container" class="flex flex-row place-content-between">
        <div>
            <h2 class="text-4xl text-center md:text-left text-comp-1 font-semibold">User Role</h2>
            <h1 class="text-8xl text-primary font-extrabold">Report</h1>
        </div>
        <div class="self-end text-primary">
            <button>Download</button>
        </div>
    </div>

    <div class="h-1 w-full bg-secondary my-6"></div>
    <div id="Kardex-Query-Container" class="bg-primary rounded-lg flex flex-row place-content-between my-2 p-2">
        <div class="w-1/3 self-center flex space-x-3">
            <select id="userTypeFilter" class="w-full md:w-1/3 bg-comp-1 text-color py-1 outline-none rounded-md border-0">
                <option value="student">Student</option>
                <option value="instructor">Instructor</option>
            </select>
        </div>
    </div>
    <div id="UserReports-Table-Container">
        <table id="Full-Students-Reports" class="table-auto w-full">
            <thead class="bg-primary text-color">
                <tr>
                    <th class="rounded-tl-lg py-2">User</th>
                    <th>Name</th>
                    <th>Registration Date</th>
                    <th>Enrolled Courses</th>
                    <th>Completed Courses</th>
                    <th class=" rounded-tr-lg">Status</th>
                </tr>
            </thead>
            <tbody class="text-center font-semibold">
                <tr class="bg-comp-1 text-primary">
                    <td>roberto@mail.com</td>
                    <td class="py-2">Roberto Carlos</td>
                    <td>25/04/2022</td>
                    <td>7</td>
                    <td>5</td>
                    <td><input type="checkbox" checked class="status-checkbox"></td>
                </tr>
                <tr class="bg-comp-2 text-primary">
                    <td>max@mail.com</td>
                    <td class="py-2">Max Andrés</td>
                    <td>25/04/2022</td>
                    <td>7</td>
                    <td>5</td>
                    <td><input type="checkbox" class="status-checkbox"></td>
                </tr>
                <tr class="bg-comp-1 text-primary">
                    <td class="py-2 rounded-bl-lg">roberto@mail.com</td>
                    <td>Roberto Carlos</td>
                    <td>25/04/2022</td>
                    <td>7</td>
                    <td>5</td>
                    <td class="rounded-br-lg"><input type="checkbox" checked class="status-checkbox"></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div id="TeacherReports-Table-Container" class="mt-6 hidden">
        <table id="Full-Teachers-Reports" class="table-auto w-full">
            <thead class="bg-primary text-color">
                <tr>
                    <th class="rounded-tl-lg py-2">User</th>
                    <th>Name</th>
                    <th>Registration Date</th>
                    <th>Created Courses</th>
                    <th class=" rounded-tr-lg">Earnings</th>
                </tr>
            </thead>
            <tbody class="text-center font-semibold">
                <tr class="bg-comp-1 text-primary">
                    <td>roberto@mail.com</td>
                    <td class="py-2">Roberto Carlos</td>
                    <td>25/04/2022</td>
                    <td>7</td>
                    <td>500$</td>
                </tr>
                <tr class="bg-comp-2 text-primary">
                    <td class="py-2 rounded-bl-lg">max@mail.com</td>
                    <td>Max Andrés</td>
                    <td>25/04/2022</td>
                    <td>7</td>
                    <td class="rounded-br-lg">500$</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Include SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.querySelectorAll('.status-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                new swal({
                    icon: 'success',
                    text: 'User Activated',
                    title: '☝️🤓',
                    confirmButtonText: 'OK'
                });
                return;
            } else {
                new swal({
                    icon: 'success',
                    text: 'User Deactivated',
                    title: '☠️',
                    confirmButtonText: 'OK'
                });
                return;
            }
        });
    });

    document.getElementById('userTypeFilter').addEventListener('change', function() {
        const studentTable = document.getElementById('UserReports-Table-Container');
        const teacherTable = document.getElementById('TeacherReports-Table-Container');
        
        if (this.value === 'student') {
            studentTable.classList.remove('hidden');
            teacherTable.classList.add('hidden');
        } else {
            studentTable.classList.add('hidden');
            teacherTable.classList.remove('hidden');
        }
    });
</script>