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
                <option value="categories">Categories</option>
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
            <tbody id="studentsReportsBody" class="text-center font-semibold">
                <tr class="bg-comp-1 text-primary">
                    <td>LOADING</td>
                    <td class="py-2">LOADING</td>
                    <td>LOADING</td>
                    <td>LOADING</td>
                    <td>LOADING</td>
                    <td><input type="checkbox" disabled class="status-checkbox"></td>
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
                    <th>Earnings</th>
                    <th class=" rounded-tr-lg">Status</th>
                </tr>
                </tr>
            </thead>
            <tbody id="instructorsReportsBody" class="text-center font-semibold">
                <tr class="bg-comp-1 text-primary">
                    <td>roberto@mail.com</td>
                    <td class="py-2">Roberto Carlos</td>
                    <td>25/04/2022</td>
                    <td>7</td>
                    <td>500$</td>
                    <td><input type="checkbox" checked class="status-checkbox"></td>
                </tr>
                <tr class="bg-comp-2 text-primary">
                    <td class="py-2 rounded-bl-lg">max@mail.com</td>
                    <td>Max Andrés</td>
                    <td>25/04/2022</td>
                    <td>7</td>
                    <td class=>500$</td>
                    <td class="rounded-br-lg"><input type="checkbox" checked class="status-checkbox"></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div id="Categories-Table-Container" class="mt-6 hidden">
        <table id="Full-Categories-Reports" class="table-auto w-full my-2">
            <thead class="bg-primary text-color">
                <tr>
                    <th class="rounded-tl-lg py-2">Name</th>
                    <th>Description</th>
                    <th>User</th>
                    <th>Created</th>
                    <th class=" rounded-tr-lg">REMOVE</th>
                </tr>
            </thead>
            <tbody id="categoriesReportsBody" class="text-center font-semibold">
                <tr class="bg-comp-1 text-primary">
                    <td>Computer Science</td>
                    <td class="py-2">Computer related stuff</td>
                    <td>Max</td>
                    <td>25/04/2022</td>
                    <td>
                        <button class="flex items-center h-full w-full justify-center" onclick="deleteCategory()">
                            <img class="h-5 w-5 bg-color p-1 rounded-md" src="https://cdn-icons-png.flaticon.com/512/1017/1017530.png" alt="delete">
                        </button>
                    </td>
                </tr>
                <tr class="bg-comp-2 text-primary">
                    <td class="py-2">Languages</td>
                    <td>Language related stuff</td>
                    <td>Max</td>
                    <td>25/04/2022</td>
                    <td>
                    <button class="flex items-center h-full w-full justify-center" onclick="deleteCategory()">
                            <img class="h-5 w-5 bg-color p-1 rounded-md" src="https://cdn-icons-png.flaticon.com/512/1017/1017530.png" alt="delete">
                        </button>
                    </td>
                </tr>
                <tr class="bg-comp-1 text-primary">
                    <td class="py-2 rounded-bl-lg">Engineering</td>
                    <td>Engineering related stuff</td>
                    <td>Max</td>
                    <td>25/04/2022</td>
                    <td class="rounded-br-lg">
                        <button class="flex items-center h-full w-full justify-center" onclick="deleteCategory()">
                            <img class="h-5 w-5 bg-color p-1 rounded-md" src="https://cdn-icons-png.flaticon.com/512/1017/1017530.png" alt="delete">
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="flex justify-end mb-4">
            <button id="addCategoryBtn" class="bg-primary text-color py-2 px-4 rounded-md">Add Category</button>
        </div>
    </div>
</div>

<div id="categoryModal" class="modal hidden fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center">
    <div class="bg-white p-5 rounded-lg sm:w-1/3">
        <h2 class="text-lg font-semibold mb-4">Create Category</h2>
        <p class="mb-2">Name</p>
        <input id="name" type="text" class="w-full p-2 rounded border border-gray-300">
        <p class="mb-2">Description</p>
        <textarea id="desc" class="w-full p-2 rounded border border-gray-300" rows="4"></textarea>
        <div class="flex justify-end">
            <button class="bg-gray-300 px-4 py-2 rounded mr-2" onclick="hideCategoryModal()">Cancel</button>
            <button class="bg-green-500 text-white px-4 py-2 rounded" onclick="confirmCategory()">Create</button>
        </div>
    </div>
</div>

<!-- Include SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    function GetCategories()
    {
        fetch('/categories')
        .then(response => response.json())
        .then(data => {
            const categoriesReportsBody = document.getElementById('categoriesReportsBody');

            categoriesReportsBody.innerHTML = "";
            
            let i = 0;
            data.payload.categories.forEach(category => {

                const row = document.createElement('tr');
                            row.classList.add(i % 2 === 0 ? 'bg-comp-1' : 'bg-comp-2', 'text-primary');
            
                            row.innerHTML = `
                                <td>${category.categoryName}</td>
                                <td class="py-2">${category.categoryDescription}</td>
                                <td>${category.User}</td>
                                <td>${category.Created}</td>
                                <td>
                                <button class="flex items-center h-full w-full justify-center" onclick="deleteCategory(${category.categoryId})">
                                <img class="h-5 w-5 bg-color p-1 rounded-md" src="https://cdn-icons-png.flaticon.com/512/1017/1017530.png" alt="delete">
                            </button></td>
                            `;
            
                            categoriesReportsBody.appendChild(row);
                            i++;
            })
        });
    }
    
    GetCategories();

    fetch('/users/student/report')    
        .then(response => response.json())
        .then(data => {
            const studentsReportsBody = document.getElementById('studentsReportsBody');

            studentsReportsBody.innerHTML = ''; // Clear existing rows
            instructorsReportsBody.innerHTML = ''; // Clear existing rows

            let i = 0;
            
            data.payload.users.forEach(user => {
                if (user.role === 'S') {
                    const row = document.createElement('tr');
                    row.classList.add(i % 2 === 0 ? 'bg-comp-1' : 'bg-comp-2', 'text-primary');
    
                    row.innerHTML = `
                        <td>${user.email}</td>
                        <td class="py-2">${user.email}</td>
                        <td>${user.creationDate}</td>
                        <td>${user.enrolledCourses ? user.enrolledCourses : '0'}</td>
                        <td>${user.completedCourses ? user.completedCourses : '0'}%</td>
                        <td><input type="checkbox" class="status-checkbox" ${Math.random() > 0.5 ? 'checked' : ''}></td>
                    `;
    
                    studentsReportsBody.appendChild(row);
                    i++;
                }
            });

            if(i === 0) {
                const row = document.createElement('tr');
                row.classList.add('bg-comp-1', 'text-primary');
                row.innerHTML = `
                    <td colspan="6">No students found</td>
                `;
                studentsReportsBody.appendChild(row);
            }

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

        })
        .catch(error => console.error('Error fetching users:', error));

    fetch('users/instructor/report')
        .then(response => response.json())
        .then(data => {
            const instructorsReportsBody = document.getElementById('instructorsReportsBody');
            let j = 0;
            instructorsReportsBody.innerHTML = ''; // Clear existing rows
            
            data.payload.users.forEach(user => {
                if (user.role === 'I') {
                    const row = document.createElement('tr');
                    row.classList.add(j % 2 === 0 ? 'bg-comp-1' : 'bg-comp-2', 'text-primary');
    
                    row.innerHTML = `
                        <td>${user.email}</td>
                        <td class="py-2">${user.email}</td>
                        <td>${user.creationDate}</td>
                        <td>${user.createdCourses ? user.createdCourses : '0'}</td>
                        <td>$${user.earnings ? user.earnings : '0'}</td>
                        <td><input type="checkbox" class="status-checkbox" ${Math.random() > 0.5 ? 'checked' : ''}></td>
                    `;
    
                    instructorsReportsBody.appendChild(row);
                    j++;  
                }
            });

            if(j === 0) {
                const row = document.createElement('tr');
                row.classList.add('bg-comp-1', 'text-primary');
                row.innerHTML = `
                    <td colspan="6">No instructors found</td>
                `;
                instructorsReportsBody.appendChild(row);
            }

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
            
        });

    document.getElementById('userTypeFilter').addEventListener('change', function() {
        const studentTable = document.getElementById('UserReports-Table-Container');
        const teacherTable = document.getElementById('TeacherReports-Table-Container');
        const categoriesTable = document.getElementById('Categories-Table-Container');
        
        if (this.value === 'student') {
            studentTable.classList.remove('hidden');
            teacherTable.classList.add('hidden');
            categoriesTable.classList.add('hidden');
        }
        else if (this.value === 'instructor') {
            studentTable.classList.add('hidden');
            categoriesTable.classList.add('hidden');
            teacherTable.classList.remove('hidden');
        } 
        else {
            studentTable.classList.add('hidden');
            teacherTable.classList.add('hidden');
            categoriesTable.classList.remove('hidden');
        }
    });

    document.getElementById('addCategoryBtn').addEventListener('click', function() {
        document.getElementById('categoryModal').classList.remove('hidden');
        document.getElementById('categoryModal').classList.add('flex');
    });
    
    function hideCategoryModal() {
        document.getElementById('categoryModal').classList.add('hidden');
        document.getElementById('categoryModal').classList.remove('flex');
    }

    function confirmCategory(){
        const name = document.querySelector('#name').value.trim();
        const desc = document.querySelector('#desc').value.trim();
        
        if (name === '') {
            new swal({
                icon: 'error',
                text: 'Type a name.',
                title: '☠️',
                confirmButtonText: 'OK'
            });
            return;
        }

        if (desc === '') {
            new swal({
                icon: 'error',
                text: 'Type a description.',
                title: '☠️',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        const formData = new FormData();

        formData.append("categoryName", name);
        formData.append("categoryDescription", desc);
        formData.append("userId", <?= $_SESSION["user"]["userId"] ?>);

        fetch("/categories", {
            method: "POST",
            body: formData
        }).then(response => response.json()).
        then(data => {
            if (data.status) {
            new swal({
            title: '🎉',
            text: 'Category has been created',
            icon: 'success',
            confirmButtonText: 'OK'
            }).then((result) => {
                if(result.isConfirmed){
                    GetCategories();
                }
            });
            hideCategoryModal();
        }
        else{
            new swal({
            title: '☠️',
            text: 'Error creating category',
            icon: 'error',
            confirmButtonText: 'OK'
            });
            hideCategoryModal();
        }})
        }

    function deleteCategory(categoryId){
        new swal({
            title: '😐',
            text: 'Do you really want to delete this category? This process cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {

                fetch("/deleteCategory?categoryId="+categoryId)
                .then(response => response.json())
                .then(data => {
                    new swal({
                        title: '🛸',
                        text: 'Category has been deleted',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                    GetCategories();
                }).catch(error => {
                    new swal({
                        title: '😐',
                        text: 'Something went Wrong: ' + error,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                });
            }
        });
    }

</script>