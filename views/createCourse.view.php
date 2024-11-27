<?php
    require 'views/components/header.php';
    require 'views/components/navbar.php';

    $isUpdating = isset($_GET['update']) && $_GET['update'] === 'true';
?>
<div class="container mx-auto space-y-5">
    <div class="text-center">
        <h2 class="text-primary text-4xl font-bold"><?= $isUpdating ? 'Update' : 'Create'; ?></h2>
        <h1 class="text-secondary text-5xl font-bold">Course</h1>
    </div>
    <div class="flex flex-col sm:flex-row mx-10 items-center sm:items-stretch space-y-4 sm:space-y-0 sm:space-x-4 text-secondary font-semibold">
        <div class="w-5/6 sm:w-1/2 space-y-2">
            <div>
                <div class="text-xl my-1">
                    Title
                </div>
                <input id="title" class="rounded-md p-1 bg-primary text-color w-full font-bold text-lg" type="text">
            </div>
            <div>
                <div class="text-xl my-1">
                    Description
                </div>
                <textarea id="desc" class="w-full rounded-md p-1 bg-primary h-32 resize-none text-color"></textarea>
            </div>
            <div class="flex items-center justify-between">
                <div class="text-xl mr-1">
                    Category
                </div>
                <select id="category" class="w-full ml-4 rounded-md p-1 bg-primary text-color font-semibold">
                </select>
            </div>
        </div>        
        <label for="photo" class="flex w-5/6 sm:w-1/2 rounded-md bg-primary text-comp-1 items-center justify-center">
            <div class="flex flex-col items-center justify-center p-2">                
            <svg class="w-[48px] h-[48px] text-color" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M7.5 4.586A2 2 0 0 1 8.914 4h6.172a2 2 0 0 1 1.414.586L17.914 6H19a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h1.086L7.5 4.586ZM10 12a2 2 0 1 1 4 0 2 2 0 0 1-4 0Zm2-4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Z" clip-rule="evenodd"/>
            </svg>
                <p class="text-color">Upload course photo</p>
            </div>
            <input id="photo" type="file" class="hidden" />
        </label>
    </div>
    <div class="mx-10">
        <?php if ($isUpdating): ?>
            <div class="flex items-center space-x-2">
                <div>
                    Active
                </div>
                <input id="active" type="checkbox" class="rounded-md p-1 bg-comp-2 text-comp-1" <?= $isUpdating ? 'checked' : ''; ?>>
            </div>
        <?php endif; ?>
    </div>
    <div class="mx-10 overflow-y-scroll">
        <div class="flex justify-between items-center text-secondary">
            <h3 class="text-3xl font-bold">Levels</h3>
            <button class="text-secondary" id="AddLevel">Add level</a>
        </div>
        <div id="LevelPreviewContainer" class="bg-secondary text-color space-y-2 rounded-md p-2">
        </div>
    </div>
    <div class="w-full">        
        <h3 class="mx-10 text-3xl font-bold text-secondary mb-2">Payment Method</h3>
        <div class="flex justify-evenly mx-10 text-primary">
            <label class="flex items-center">
                <input type="radio" name="payment_method" value="one_time" class="mr-2" checked>
                One time
                <input type="number" name="one_time_amount" placeholder="Enter amount" class="outline-none ml-2 p-1 rounded-md bg-comp-1 text-color">
            </label>
            <label class="flex items-center">
                <input type="radio" name="payment_method" value="level_based" class="mr-2">
                Level Based
            </label>
        </div>
    </div>
    <div class="flex w-full justify-center">
        <button id="createCourse" class="w-1/2 m-2 bg-comp-1 text-color font-bold py-2 rounded-md"><?= $isUpdating ? 'Update' : 'Create'; ?> Course</button>
    </div>
</div>


<script>

    fetch("/categories")
    .then(response => response.json())
    .then(data => {
    const categorySelector = document.getElementById("category");


    data.payload.categories.forEach((category) => {
                const option = document.createElement("option");
                option.value = category.categoryId;
                option.textContent = category.categoryName;
                categorySelector.appendChild(option);
            });
    });


    let currentLevelNum = 0;
    document.querySelector("#AddLevel").addEventListener("click", function () {
        const levelPreviewContainer = document.getElementById("LevelPreviewContainer");
        const levelPreview = document.createElement('div');
        
        let levelhtml = `<?php require 'views/components/createLevelPreview.php'; ?>`;
        
        currentLevelNum++;        
        levelhtml = levelhtml.replace(/LEVEL_NUM/g, currentLevelNum);

        levelPreview.innerHTML = levelhtml;
        levelPreviewContainer.appendChild(levelPreview);

        const deleteButton = levelPreview.querySelector('.DeleteLevel');
        const addVideo = levelPreview.querySelectorAll('.videoRef');
        const addFile = levelPreview.querySelectorAll('.fileRef');
        const videoinput = levelPreview.querySelectorAll('.video');
        const fileinput = levelPreview.querySelectorAll('.file');

        addVideo.forEach((link) => {
            link.addEventListener("click", function(e) {
                e.preventDefault();
                const levelContainer = link.closest(".Level");
                const fileInput = levelContainer.querySelector(".video");
                fileInput.click();
            });
        });

        addFile.forEach((link) => {
            link.addEventListener("click", function(e) {
                e.preventDefault();
                const levelContainer = link.closest(".Level");
                const fileInput = levelContainer.querySelector(".file");
                fileInput.click();
            });
        });

        videoinput.forEach((video) => {
            video.addEventListener('change', function () {
        const levelContainer = video.closest('.Level');
        let fileNameDisplay = levelContainer.querySelector('.videoNameDisplay');

        if (!fileNameDisplay) {
            fileNameDisplay = document.createElement('div');
            fileNameDisplay.classList.add('videoNameDisplay');
            levelContainer.appendChild(fileNameDisplay);
        }

        const fileName = video.files.length > 0 ? video.files[0].name : 'No file selected';
        fileNameDisplay.textContent = fileName;
             });
        });
        
        fileinput.forEach((file) => {
        file.addEventListener('change', function () {
        const levelContainer = file.closest('.Level');
        let fileNameDisplay = levelContainer.querySelector('.fileNameDisplay');

        if (!fileNameDisplay) {
            fileNameDisplay = document.createElement('div');
            fileNameDisplay.classList.add('fileNameDisplay');
            levelContainer.appendChild(fileNameDisplay);
        }

        const fileName = file.files.length > 0 ? file.files[0].name : 'No file selected';
        fileNameDisplay.textContent = fileName;
             });
        });
        
             
        deleteButton.addEventListener('click', function (e) {
        e.preventDefault();  
        levelPreview.remove();
        updateLevelNumbers();
       });
    });

    function updateLevelNumbers() {
        const levels = document.querySelectorAll(".Level");

        levels.forEach((level,index) => {
            const levelNum = index+1;
            level.id = `level-${levelNum}`; 
            level.querySelector('.font-bold').textContent = levelNum;  
        });

        currentLevelNum = levels.length; 
    }

    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const individualCostElements = document.querySelectorAll('[name="individualCost"]');
            if (this.value === 'one_time') {
                individualCostElements.forEach(element => element.classList.add('hidden'));
            } else {
                individualCostElements.forEach(element => element.classList.remove('hidden'));
            }
        });
    });

    document.querySelector('#createCourse').addEventListener('click', function(event) {
        let title = document.querySelector('#title').value;
        let description = document.querySelector('#desc').value;
        let category = document.querySelector('#category').value;
        let paymentMethod = document.querySelector('input[name="payment_method"]:checked');
        let oneTimeAmount = document.querySelector('input[name="one_time_amount"]').value;
        let levelId = document.querySelectorAll('.Level');
        let CoursePhoto = document.querySelector("#photo");

        if (!title || !description || !category || !paymentMethod) {
            swal({
                icon: 'error',
                title: '☠️',
                text: 'Please fill out all required fields.',
            });
            event.preventDefault();
            return;
        }

        if (paymentMethod.value === 'one_time' && !oneTimeAmount) {
            swal({
                icon: 'error',
                title: '☠️',
                text: 'Please enter the amount for one-time payment.',
            });
            event.preventDefault();
            return;
        }

        // for (let i = 0; i < levelNames.length; i++) {
        //     if (!levelNames[i].value || !levelDescriptions[i].value) {
        //         swal({
        //             icon: 'error',
        //             title: '☠️',
        //             text: 'Please fill out all level names and descriptions.',
        //         });
        //         event.preventDefault();
        //         return; 
        //     }
        // }


        const formData = new FormData();

        formData.append("title",title);
        formData.append("description",description);
        formData.append("category",category);
        formData.append("courseImage", document.getElementById("photo").files[0])

        if(paymentMethod.value === 'one_time')
        {
            formData.append("oneTimeAmount",oneTimeAmount);
        }
        else{
            formData.append("oneTimeAmount", null);
        }
        
        
        fetch("/createCourse", {
            method:"POST",
            body: formData
        }).then(response => response.json())
        .then(data => {
            const courseId = data.payload.courseId
            const levelData = [];
            levelId.forEach((level) => {
                let LevelInfo = {};
                LevelInfo.levelNumber = level.id;
                LevelInfo.levelName = level.querySelector('.levelName').value;
                LevelInfo.levelDescription = level.querySelector('.levelDescription').value;
                LevelInfo.levelVideo = level.querySelector('.video').files[0];
                LevelInfo.levelFile = level.querySelector('.file').files[0];
                LevelInfo.levelCost = level.querySelector('.individualCost').value;
                LevelInfo.CourseId = courseId;
    let formData = new FormData();
    
    // Append text fields to FormData
    formData.append("levelNumber", LevelInfo.levelNumber);
    formData.append("levelName", LevelInfo.levelName);
    formData.append("levelDescription", LevelInfo.levelDescription);
    formData.append("levelCost", LevelInfo.levelCost ? LevelInfo.levelCost : null);
    formData.append("CourseId", courseId);
    
    // Append files to FormData
    formData.append("levelVideo", LevelInfo.levelVideo);  // Assuming only one file
    formData.append("levelFile", LevelInfo.levelFile);    // Assuming only one file
    
    
                fetch("/level",{
                    method:"POST",
                    body: formData
                }).then(response => response.json())
                .then(data => {
                    console.log(data);
                });
            });
        });
        

        swal({
            icon: 'success',
            title: '🎉',
            text: 'Course <?= $isUpdating ? 'updated' : 'created'; ?> successfully!',
        });
    });

    document.querySelector('#photo').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('w-full', 'h-full', 'object-cover', 'rounded-lg');
                const photoDiv = document.querySelector('label[for="photo"] .flex');
                photoDiv.innerHTML = '';
                photoDiv.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });
</script>