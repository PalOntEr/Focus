<?php
require 'views/components/header.php';
require 'views/components/navbar.php';
?>
<div class="container mx-auto">
    <div id="Kardex-Title-Container" class="flex flex-row place-content-between">
        <div>
            <h2 id="User" class="text-4xl text-center md:text-left text-comp-1 font-semibold"><?= $_SESSION['user']['username'] ?></h2>
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
                <input type="button" onclick="clearFilters()" class="bg-comp-1 text-color p-1 rounded-lg" value="Clean" >
                <select id="categorySelect" class="w-1/2 bg-comp-1 text-color py-1 outline-none rounded-md border-0">
                    <option value="0">Any</option>
                </select>
            </div>

            <div class="flex w-1/2 justify-evenly">
                <input type="date" id="DateStart" class="w-1/3 bg-comp-1 text-color outline-none rounded-md border-0">
                <div class="h-0.5 w-2 bg-primary self-center"></div>
                <input type="date" id="DateFinish" class="w-1/3 bg-comp-1 text-color outline-none rounded-md border-0">
            </div>

            <div class="flex w-1/4 justify-end self-center font-semibold space-x-3">
                <div>
                    <select id="Active" class="w-full bg-comp-1 text-color py-1 outline-none rounded-md border-0">
                        <option value="any">Any</option>
                        <option value="true">Active</option>
                        <option value="false">Disabled</option>
                    </select>
                </div>
                <div>
                    <select id="Finished" class="w-full bg-comp-1 text-color py-1 outline-none rounded-md border-0">
                        <option value="any">Any</option>
                        <option value="true">Finished</option>
                        <option value="false">Not Finished</option>
                    </select>
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
                <tbody id="kardexTable" class="text-center font-semibold">
                    <tr class="bg-comp-1 text-primary">
                        <td colspan="7" class="py-2 animate-bounce">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const { PDFDocument, StandardFonts, rgb } = PDFLib;

    async function modifyAndDownloadPdf(url,CourseName,user) {
    // Load an existing PDF
    const existingPdfBytes = await fetch(url).then((res) => res.arrayBuffer());
    const pdfDoc = await PDFDocument.load(existingPdfBytes);

    // Get the first page and modify it
    const pages = pdfDoc.getPages();
    const firstPage = pages[0];
    firstPage.drawText(user, {
        x: 330,
        y: 320,
        size: 35,
        color: rgb(0,0,0),
    });

    firstPage.drawText(CourseName, {
        x: 215,
        y: 205,
        size: 50,
        color: rgb(0,0,0),
    });
    const date = new Date();

    const year = date.getFullYear();
const month = date.getMonth() + 1;  // Months are zero-indexed
const day = date.getDate();
    firstPage.drawText(day + "/" + month + "/" + year, {
        x: 500,
        y: 75,
        size: 20,
        color: rgb(0,0,0),
    });

    // Save the modified PDF
    const pdfBytes = await pdfDoc.save();

    // Create a Blob from the PDF bytes
    const blob = new Blob([pdfBytes], { type: 'application/pdf' });

    // Create a download link and trigger the download
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'modified.pdf'; // Set the desired file name
    link.click();

    // Clean up the object URL
    URL.revokeObjectURL(link.href);
}

    const categorySelect = document.getElementById('categorySelect');   
    const DateStart = document.getElementById('DateStart'); 
    const DateFinish = document.getElementById('DateFinish');
    const Active = document.getElementById('Active');
    const Finished = document.getElementById('Finished');
    let kardexReport = {};

    function downloadDiploma(CourseName,user) {
        
        modifyAndDownloadPdf('public/images/Certificate.pdf',CourseName,user);
        swal({
            title: 'Diploma downloaded',
            icon: 'success',
            showConfirmButton: false,
            timer: 1500
        })
    }
    
    fetch('/categories')
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                const categories = data.payload.categories;
                const categorySelect = document.getElementById('categorySelect');
                categories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.categoryId;
                    option.textContent = category.categoryName;
                    categorySelect.appendChild(option);
                });
            } else {
                console.error(data.payload.error);
            }
        })
        .catch(error => console.error('Error fetching categories:', error));

    document.addEventListener('DOMContentLoaded', () => {
        getKardexReport();
    });
    
    async function getKardexReport() {
        try {
            let queryParams = [];
            if (categorySelect.value != 0) queryParams.push(`categoryId=${categorySelect.value}`);
            if (DateStart.value) queryParams.push(`startDate=${encodeURIComponent(DateStart.value + ' 00:00:00')}`);
            if (DateFinish.value) queryParams.push(`completionDate=${encodeURIComponent(DateFinish.value + ' 23:59:59')}`);
            
            const fetchParams = queryParams.length ? '?' + queryParams.join('&') : '';

            const fetchUrl = '/reports/student/kardex' + fetchParams;
            const response = await fetch(fetchUrl);
            const data = await response.json();
            
            if (data.status) {
                kardexReport = data.payload.kardexReport;
                let reports = kardexReport.filter(course => {
                    if (Active.value === 'any') return true;
                    if (Active.value === 'true') return !course.deactivationDate;
                    if (Active.value === 'false') return course.deactivationDate;
                });
                reports = reports.filter(course => {
                    if (Finished.value === 'any') return true;
                    if (Finished.value === 'true') return course.isCompleted;
                    if (Finished.value === 'false') return !course.isCompleted;
                });
                updateKardexTable(reports); 
            } else {
                console.error(data.payload.error);
            }
        } catch (error) {
            console.error('Error fetching kardex report:', error);
        }
    }

    function updateKardexTable(reports) {
        const kardexTable = document.getElementById('kardexTable');
        kardexTable.innerHTML = '';

        if (reports.length === 0) {
            const row = document.createElement('tr');
            row.classList.add('bg-comp-1', 'text-primary');
            row.innerHTML = `
                <td colspan="7" class="py-2">No courses found</td>
            `;
            kardexTable.appendChild(row);
        } else {
            const userName = document.getElementById("User").textContent;
            console.log(userName);
            reports.forEach((report, index) => {
                const row = document.createElement('tr');
                row.classList.add(index % 2 === 0 ? 'bg-comp-1' : 'bg-comp-2', 'text-primary','report');
                row.innerHTML = `
                    <td class="py-2 Title">${report.courseTitle}</td>
                    <td>${report.percentageCompleted}%</td>
                    <td>${report.startDate.split(' ')[0]}</td>
                    <td>${report.endDate}</td>
                    <td>${report.accessDate}</td>
                    <td><input type="checkbox" ${report.isCompleted ? 'checked' : ''} disabled></td>
                    <td>
                        <a class="Download justify-center flex ${report.isCompleted ? '' : 'pointer-events-none opacity-50'}" onclick="downloadDiploma('${report.courseTitle}','${userName}')" href="#">
                            <img class="h-5 bg-color p-1 rounded-md" src="https://cdn-icons-png.flaticon.com/512/3580/3580085.png" alt="">
                        </a>
                    </td>
                `;
                kardexTable.appendChild(row);
            });
        }
    }

    function clearFilters() {
        document.getElementById('categorySelect').value = '0';
        document.getElementById('DateStart').value = '';
        document.getElementById('DateFinish').value = '';
        document.getElementById('Active').value = 'any';
        document.getElementById('Finished').value = 'any';
        getKardexReport();
    }

    categorySelect.addEventListener('change', getKardexReport);
    Active.addEventListener('change', getKardexReport); 
    Finished.addEventListener('change', getKardexReport);

    DateStart.addEventListener('change', () => {
        if (DateStart.value > DateFinish.value && DateFinish.value !== '') {
            swal('Start date must be before or equal to end date.', {
                icon: 'warning',
                title: '📅',
            });
            DateStart.value = '';
            return;
        }
        getKardexReport();
    });

    DateFinish.addEventListener('change', () => {
        if (DateFinish.value < DateStart.value && DateStart.value !== '') {
            swal('End date must be after or equal to start date.', {
                icon: 'warning',
                title: '📅',
            });
            DateFinish.value = '';
            return;
        }
        getKardexReport();
    });
</script>

