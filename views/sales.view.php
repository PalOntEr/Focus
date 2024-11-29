<?php
require 'views/components/header.php';
require 'views/components/navbar.php';
?>
<div class="container mx-auto mb-4">
    <div id="Kardex-Title-Container" class="flex flex-row place-content-between">
        <div>
            <h2 class="text-4xl text-center md:text-left text-comp-1 font-semibold"><?= $_SESSION['user']['username'] ?></h2>
            <h1 class="text-8xl text-primary font-extrabold">Sales</h1>
        </div>
        <div class="self-end text-primary">
            <p>Created Courses: <span id="numCourses">0</span></p>
        </div>
    </div>

    <div class="h-1 w-full bg-secondary"></div>

    <div id="Kardex-Container" class="my-4">
        <h2 class="text-2xl text-center md:text-left text-primary font-semibold">Per Course</h2>            
        <div id="Kardex-Query-Container" class="bg-primary rounded-lg flex flex-row place-content-between my-2 p-2">
            <div class="w-1/3 self-center flex space-x-3">
                <input type="button" onclick="cleanFilters()" class="bg-comp-1 text-color p-1 rounded-lg" value="Clean">
                <select id="perCourseSelect" class="w-1/2 bg-comp-1 text-color py-1 outline-none rounded-md border-0">
                    <option value=0>Any</option>
                </select>
            </div>

            <div class="flex w-1/3 justify-between">
                <input type="date" id="DateStart" class="w-1/3 bg-comp-1 text-color outline-none rounded-md border-0">
                <div class="h-0.5 w-2 bg-primary self-center"></div>
                <input type="date" id="DateFinish" class="w-1/3 bg-comp-1 text-color outline-none rounded-md border-0">
            </div>

            <div class="flex w-1/3 justify-end self-center">
                <select id="Active" class="w-1/2 bg-comp-1 text-color py-1 outline-none rounded-md border-0">
                    <option value="any">Any</option>
                    <option value=true>Active</option>
                    <option value=false>Disabled</option>
                </select>
            </div>
        </div>

        <div id="Sales-Table-Container">
            <table id="Full-Sales" class="table-auto w-full">
                <thead class="bg-primary text-color">
                    <tr>
                        <th class="rounded-tl-lg py-2">Course</th>
                        <th>Enrolled Students</th>
                        <th>Average Level</th>
                        <th class="rounded-tr-lg">Income</th>
                    </tr>
                </thead>
                <tbody id="perCourseSales" class="text-center font-semibold">
                    <tr class="bg-comp-1 text-primary">
                        <td colspan="4" class="py-2 animate-bounce">Loading...</td>
                    </tr>
                </tbody>
            </table>
            <div class="flex justify-between">
                <div class="font-bolder text-2xl mt-3 mb-5"><span>TOTAL INCOME: </span>$<span id="perCourseTotal">0</span> MXN</div>
                <div class="font-bolder text-2xl mt-3 mb-5"><span>TOTAL LEVEL BASED: </span>$<span id="perCourseLevel">0</span> MXN</div>
                <div class="font-bolder text-2xl mt-3 mb-5"><span>TOTAL ONE TIME: </span>$<span id="perCourseOneTime">0</span> MXN</div>
            </div>

            <h2 class="text-2xl text-center md:text-left text-primary font-semibold">Per student</h2>
            <div id="Kardex-Query-Container" class="bg-primary rounded-lg flex flex-row my-2 p-2">
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
                        <th class="rounded-tl-lg py-2">Student</th>
                        <th>Enrollment Date</th>
                        <th>Level</th>
                        <th>Paid Price</th>
                        <th class="rounded-tr-lg">Payment Method</th>
                    </tr>
                </thead>
                <tbody class="text-center font-semibold">
                    <tr class="bg-comp-1 text-primary">
                        <td class="py-2">Roberto Carlos Dominguez Espinosa</td>
                        <td>21/08/2024</td>
                        <td>7</td>
                        <td>740</td>
                        <td>One Time</td>
                    </tr>
                    <tr class="bg-comp-2 text-primary">
                        <td class="rounded-bl-lg py-2">Max Andrés Zertuche Perez</td>
                        <td>21/08/2024</td>
                        <td>7</td>
                        <td>740</td>
                        <td class="rounded-br-lg">One Time</td>
                    </tr>
                </tbody>
            </table>
            <div class="flex justify-between">
                <div class="font-bolder text-2xl mt-3 mb-5"><span>TOTAL INCOME: </span>$1480.00 MXN</div>
                <div class="font-bolder text-2xl mt-3 mb-5"><span>TOTAL LEVEL BASED: </span>$0.00 MXN</div>
                <div class="font-bolder text-2xl mt-3 mb-5"><span>TOTAL ONE TIME: </span>$1480.00 MXN</div>
            </div>
        </div>
    </div>
</div>
<script>

const perCourseSelect = document.getElementById('perCourseSelect');
const dateStart = document.getElementById('DateStart');
const dateFinish = document.getElementById('DateFinish');
const active = document.getElementById('Active');
const perCourseTotal = document.getElementById('perCourseTotal');
const perCourseLevel = document.getElementById('perCourseLevel');   
const perCourseOneTime = document.getElementById('perCourseOneTime');
let categories = {};
let perCourseReport = {};

document.addEventListener('DOMContentLoaded', async () => {
    fetch('/categories')
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                categories = data.payload.categories;
                categories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.categoryId;
                    option.textContent = category.categoryName;
                    perCourseSelect.appendChild(option);
                });
            } else {
                console.error(data.payload.error);
            }
        })
        .catch(error => console.error('Error fetching categories:', error));

    await getSalesPerCourseReport();

    const numCourses = document.getElementById('numCourses');
    numCourses.textContent = perCourseReport.length;
});

async function getSalesPerCourseReport(){
    try {
        const categoryFilter = perCourseSelect.value == 0 ? "" : "&categoryId=" + perCourseSelect.value;
        const dateStartFilter = dateStart.value == "" ? "" : "&creationDate=" + dateStart.value;
        const dateFinishFilter = dateFinish.value == "" ? "" : "&modificationDate=" + dateFinish.value;
        const fetchUrl = '/reports/instructor/salesPerCourse?instructorId=<?= $_SESSION['user']['userId'] ?>' + categoryFilter + dateStartFilter + dateFinishFilter;
        const response = await fetch(fetchUrl);
        const data = await response.json();
        if (data.status) {
            const salesReport = data.payload.salesReport;
            perCourseReport = salesReport;
            const reports = perCourseReport.filter(course => {
                if (active.value === 'any') return true;
                if (active.value === 'true') return !course.deactivationDate;
                if (active.value === 'false') return course.deactivationDate;
            });
            updatePerCourseReportTable(reports);
            const totalIncome = reports.reduce((acc, course) => acc + parseFloat(course.totalIncome), 0);
            const totalLevelIncome = reports.reduce((acc, course) => acc + parseFloat(course.incomeFromLevels), 0);
            const totalOneTimeIncome = reports.reduce((acc, course) => acc + parseFloat(course.incomeFromCourses), 0);
            perCourseTotal.textContent = totalIncome.toFixed(2);
            perCourseLevel.textContent = totalLevelIncome.toFixed(2);
            perCourseOneTime.textContent = totalOneTimeIncome.toFixed(2);   
        } else {
            console.error(data.payload.error);
        }
    } catch (error) {
        console.error('Error fetching sales report:', error);
    }
}

function updatePerCourseReportTable(reports){
    const perCourseSales = document.getElementById('perCourseSales');
    perCourseSales.innerHTML = '';
    if (reports.length === 0) {
        const row = document.createElement('tr');
        row.classList.add('bg-comp-1', 'text-primary');
        row.innerHTML = `
            <td colspan="4" class="py-2">No courses found</td>
        `;
        perCourseSales.appendChild(row);
    } else {
        reports.forEach((sale, index) => {
            const row = document.createElement('tr');
            row.classList.add(index % 2 === 0 ? 'bg-comp-1' : 'bg-comp-2', 'text-primary');
            row.innerHTML = `
                <td class="py-2">${sale.courseTitle}</td>
                <td>${sale.totalStudents}</td>
                <td>${parseFloat(sale.avgLevelsBought).toFixed(2)}</td>
                <td>$${sale.totalIncome} MXN</td>
            `;
            perCourseSales.appendChild(row);
        });
    }
}

perCourseSelect.addEventListener('change', getSalesPerCourseReport);

dateStart.addEventListener('change', () => {
    if (dateStart.value > dateFinish.value && dateFinish.value !== '') {
        swal('Start date must be before or equal to end date.', {
            icon: 'warning',
            title: '📅',
        });
        dateStart.value = '';
        return;
    }
    getSalesPerCourseReport();
});

dateFinish.addEventListener('change', () => {
    if (dateFinish.value < dateStart.value) {
        swal('End date must be after or equal to start date.', {
            icon: 'warning',
            title: '📅',
        });
        dateFinish.value = '';
        return;
    }
    getSalesPerCourseReport();
});

active.addEventListener('change', () => {
    getSalesPerCourseReport();
});

function cleanFilters() {
    perCourseSelect.value = 0;
    dateStart.value = '';   
    dateFinish.value = '';
    active.value = 'any';
    getSalesPerCourseReport();
}

</script>