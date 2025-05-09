<?php
    require 'views/components/header.php';
    require 'views/components/navbar.php';

    $isUpdating = isset($_GET['update']) && $_GET['update'] === 'true';
    $courseId = isset($_GET['courseId']) ? $_GET['courseId'] : NULL;
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
                <input id="active" type="checkbox" class="rounded-md p-1 bg-comp-2 text-comp-1">
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
                <input id ="oneTime" type="radio" name="payment_method" value="one_time" class="mr-2" checked>
                One time
                <input id="oneTimeAmount" type="number" name="one_time_amount" placeholder="Enter amount" class="outline-none ml-2 p-1 rounded-md bg-comp-1 text-color">
            </label>
            <label class="flex items-center">
                <input id="levelBased" type="radio" name="payment_method" value="level_based" class="mr-2">
                Level Based
            </label>
        </div>
    </div>
    <div class="flex w-full justify-center">
        <button id="createCourse" class="w-1/2 m-2 bg-comp-1 text-color font-bold py-2 rounded-md"><?= $isUpdating ? 'Update' : 'Create'; ?> Course</button>
    </div>
</div>


<script>

let courseInfo = {};

let deletedLevels = [];
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
            
            categorySelector.value = courseInfo.categoryId;
        });
        
        
        let currentLevelNum = 0;
    function getCourseInformation(){
        
        if(<?= json_encode($isUpdating) ?>)
        {   
            const courseId = <?= json_encode($courseId) ?>;
            fetch("/courses/get?course_id=" + courseId)
            .then(response => response.json())
            .then(data => {
                courseInfo = data.payload.courses[0];
                
                document.getElementById("title").value = courseInfo.courseTitle;
                document.getElementById("desc").value = courseInfo.courseDescription;
                courseInfo.deactivationDate === null ? document.getElementById("active").checked = true : document.getElementById("active").checked = false;
                const img = document.createElement('img');
                img.src = "data:image/*;base64," + courseInfo.courseImage;
                img.classList.add('w-full', 'h-full', 'object-cover', 'rounded-lg');
                const photoDiv = document.querySelector('label[for="photo"] .flex');
                photoDiv.innerHTML = '';
                photoDiv.appendChild(img);

                if(courseInfo.coursePrice !== null)
                {
                    document.getElementById("oneTime").checked = true;  
                }
                else{
                    document.getElementById("levelBased").checked = true;
                }

                document.getElementById("oneTimeAmount").value = courseInfo.coursePrice;
            });

            
            let levelInfo = {};
            fetch("/level?course_id=" + courseId)
            .then(response => response.json())
            .then(data => {
                levelInfo = data.payload.levels;
                levelInfo.forEach((level,index) => {
                    fetch("/Content/get?level_id=" + level.levelId)
                    .then(response => response.json())
                    .then(data => {
                        levelInfo[index].Files = data.payload.content;
                        currentLevelNum++;        
                        const levelPreviewContainer = document.getElementById("LevelPreviewContainer");
                        const levelPreview = document.createElement('div');
                        let levelhtml = `<?php require 'views/components/createLevelPreview.php'; ?>`;
                        levelhtml = levelhtml.replace(/LEVEL_NUM/g, currentLevelNum);
                        
                        levelhtml = levelhtml.replace(/LEVEL_ID/g, level.levelId);
                        levelPreview.innerHTML = levelhtml;
                        levelPreview.querySelector(".levelName").value = level.levelName;
                        levelPreview.querySelector(".levelDescription").value = level.levelDescription;
                        levelPreview.querySelector(".individualCost").value = level.levelCost;
                        levelPreview.querySelector(".levelLink").value = level.link;
    
                        levelPreviewContainer.appendChild(levelPreview);
                        let paymentMethod = document.querySelector('input[name="payment_method"]:checked');
                        
                        const individualCostElements = document.querySelectorAll('[name="individualCost"]');
                        if (level.levelCost === null || paymentMethod.value == "one_time") {
                        individualCostElements.forEach(element => element.classList.add('hidden'));
                    } else {
                        individualCostElements.forEach(element => element.classList.remove('hidden'));
                    }

                    const deleteButton = levelPreview.querySelector('.DeleteLevel');
                    levelInfo[index].Files.forEach(file => {
                    const addVideo = levelPreview.querySelector('.videoRef');
                    const addFile = levelPreview.querySelector('.fileRef');
                    const videoinput = levelPreview.querySelector('.video');
                    const fileinput = levelPreview.querySelector('.file');
                    if(file.mimeType === '.mp4')
                    {
                        
                            addVideo.addEventListener("click", function(e) {
                                e.preventDefault();
                                const levelContainer = addVideo.closest(".Level");
                                const fileInput = levelContainer.querySelector(".video");
                                fileInput.click();
                            });
                    
                            addFile.addEventListener("click", function(e) {
                                e.preventDefault();
                                const levelContainer = addFile.closest(".Level");
                                const fileInput = levelContainer.querySelector(".file");
                                fileInput.click();
                            });

                            const fileName = file.name;
                            const levelContainer = videoinput.closest('.Level');
                            let fileNameDisplay = levelContainer.querySelector('.videoNameDisplay');
                            fileNameDisplay.id = file.contentId; 

                            videoinput.addEventListener('change', function () {
                                let levelContainer = videoinput.closest('.Level');
                                let fileNameDisplay = levelContainer.querySelector('.videoNameDisplay');
                                if (!fileNameDisplay) {
                                fileNameDisplay = document.createElement('div');
                                fileNameDisplay.classList.add('videoNameDisplay');
                                levelContainer.appendChild(fileNameDisplay);
                                }
                            const fileName = videoinput.files.length > 0 ? videoinput.files[0].name : 'No file selected';
                            fileNameDisplay.textContent = "";
                            fileNameDisplay.textContent = fileName;
                            });

                            fileNameDisplay.textContent = "";
                            fileNameDisplay.textContent = fileName;
                    }
                    else
                    {
                        const fileName = file.name;
                            const levelContainer = fileinput.closest('.Level');
                            let fileNameDisplay = levelContainer.querySelector('.fileNameDisplay');
                            fileNameDisplay.id = file.contentId;
                                fileinput.addEventListener('change', function () {
                                const levelContainer = fileinput.closest('.Level');
                                let fileNameDisplay = levelContainer.querySelector('.fileNameDisplay');
                                
                                if (!fileNameDisplay) {
                                    fileNameDisplay = document.createElement('div');
                                    fileNameDisplay.classList.add('fileNameDisplay');
                                    levelContainer.appendChild(fileNameDisplay);
                                }
                                const fileName = fileinput.files.length > 0 ? fileinput.files[0].name : 'No file selected';
                                fileNameDisplay.textContent ="";        
                                fileNameDisplay.textContent = fileName;
                                });
                                fileNameDisplay.textContent = fileName;
                        }
                        });
                                
                            deleteButton.addEventListener('click', function (e) {
                            e.preventDefault();  
                            const level = this.closest(".Level");
                            const levelId = level.querySelector(".LevelId").id;
                            if(levelId){
                            deletedLevels.push(levelId);
                            console.log(deletedLevels);
                        }
                        levelPreview.remove();
                        updateLevelNumbers();
                    });
                });
            });
        });
    }
}

    getCourseInformation();

    document.querySelector("#AddLevel").addEventListener("click", function () {
        const levelPreviewContainer = document.getElementById("LevelPreviewContainer");
        const levelPreview = document.createElement('div');
        
        let levelhtml = `<?php require 'views/components/createLevelPreview.php'; ?>`;
        
        currentLevelNum++;        
        levelhtml = levelhtml.replace(/LEVEL_NUM/g, currentLevelNum);
        levelhtml = levelhtml.replace(/LEVEL_ID/g, "");

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
            level.id = `${levelNum}`; 
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
    
    const CreateButton = document.getElementById("createCourse");
    async function handleCourseCreationOrUpdate(isUpdating, courseId = null) {
    try {
        let title = document.querySelector('#title').value;
        let description = document.querySelector('#desc').value;
        let category = document.querySelector('#category').value;
        let paymentMethod = document.querySelector('input[name="payment_method"]:checked');
        let oneTimeAmount = document.querySelector('input[name="one_time_amount"]').value;
        let levelId = document.querySelectorAll('.Level');
        let CoursePhoto = document.querySelector("#photo");
        
        // Validation
        if (!title || !description || !category || !paymentMethod) {
            swal({
                icon: 'error',
                title: '☠️',
                text: 'Please fill out all required fields.',
            });
            return;
        }
        
        if (paymentMethod.value === 'one_time' && !oneTimeAmount) {
            swal({
                icon: 'error',
                title: '☠️',
                text: 'Please enter the amount for one-time payment.',
            });
            return;
        } else if (paymentMethod.value === 'level_based') {
            let levelCosts = document.querySelectorAll('.individualCost');
            for (let cost of levelCosts) {
                if (!cost.value) {
                    swal({
                        icon: 'error',
                        title: '☠️',
                        text: 'Please fill out all level costs.',
                    });
                    return;
                }
            }
        }
        
        let formData = new FormData();
        formData.append("title", title);
        formData.append("description", description);
        formData.append("category", category);
        if (CoursePhoto.files.length > 0) {
            formData.append("courseImage", CoursePhoto.files[0]);
        }
        
        if (paymentMethod.value === 'one_time') {
            formData.append("oneTimeAmount", oneTimeAmount);
        } else {
            formData.append("oneTimeAmount", null);
        }
        
        const videoFiles = document.querySelectorAll('.video');
        const files = document.querySelectorAll('.file');

        levelId.forEach((level, index) => {
        formData.append(`levelData[${index}][levelVideo]`, videoFiles[index].files[0]);
        formData.append(`levelData[${index}][levelFile]`, files[index].files[0]);
        });
        CreateButton.value = "Please Wait";
        CreateButton.textContent = "Please Wait";
        CreateButton.disabled = true;
        CreateButton.style.opacity = 0.8;
        if (!isUpdating) {
            // Create a new course
            const courseResponse = await fetch("/createCourse", {
                method: "POST",
                body: formData
            });
            const courseData = await courseResponse.json();
            
            if (!courseData.payload.courseId) {
                throw new Error(courseData.payload.error);
            }
            
            courseId = courseData.payload.courseId;
            
            for (let level of levelId) {
            const levelFormData = new FormData();
            
            levelFormData.append("levelNumber", level.id);
            levelFormData.append("levelName", level.querySelector('.levelName').value);
            levelFormData.append("levelDescription", level.querySelector('.levelDescription').value);
            levelFormData.append("levelCost", level.querySelector('.individualCost').value || null);
            levelFormData.append("CourseId", courseId);
            levelFormData.append("levelLink", level.querySelector(".levelLink").value);
            const videoFile = level.querySelector('.video').files[0];
            const file = level.querySelector('.file').files[0];
            
            if (videoFile) levelFormData.append("levelVideo", videoFile);
            if (file) levelFormData.append("levelFile", file);
            
            if (isUpdating) {
                const levelId = level.querySelector('.LevelId')?.id;
                if (levelId) {
                    levelFormData.append("levelId", levelId); // Include levelId for updates
                }
            }

            // Send level data
            await fetch("/level", {
                method: "POST",
                body: levelFormData
            });
        }
        } else {
            // Update an existing course
            let Active = document.getElementById("active").checked;
            let UpdateformData = new FormData();
            UpdateformData.append("title", title);
            UpdateformData.append("description", description);
            UpdateformData.append("category", category);
            UpdateformData.append("course_Id", courseId);
            UpdateformData.append("active", Active);
            console.log(Active);
            if (CoursePhoto.files.length > 0) {
                UpdateformData.append("courseImage", CoursePhoto.files[0]);
            }

            if (paymentMethod.value === 'one_time') {
                UpdateformData.append("oneTimeAmount", oneTimeAmount);
            } else {
                UpdateformData.append("oneTimeAmount", null);
            }
            const updateResponse = await fetch("/courses/patch", {
                method: "POST",
                body: UpdateformData
            });

            const updateData = await updateResponse.json();

            if (!updateData.status) {
                throw new Error("Failed to update course.");
            }
             let LevelsCreated = [];
            let formData = new FormData();
                levelId.forEach((level) => {
                let LevelInfo = {};
                LevelInfo.levelNumber = level.id;
                LevelInfo.levelName = level.querySelector('.levelName').value;
                LevelInfo.levelDescription = level.querySelector('.levelDescription').value;
                LevelInfo.levelCost = level.querySelector('.individualCost').value;
                LevelInfo.levelId = level.querySelector('.LevelId').id;
                LevelInfo.levelLink = level.querySelector(".levelLink").value;
                console.log(level.querySelector('.levelLink').value);
                LevelInfo.levelCourse = <?=json_encode($courseId)?>;
                LevelsCreated.push(LevelInfo);
            });
            formData.append("LevelsCreated", JSON.stringify(LevelsCreated));
            formData.append("deletedLevels",JSON.stringify(deletedLevels));
            await fetch("/levels/patch",{
            method:"POST",
            body: formData});

            levelId.forEach(async (level,index) => {
                        let formData = new FormData();
                        
                        let videoFile = level.querySelector('.video').files[0];
                        let file = level.querySelector('.file').files[0];
                        let videoName = level.querySelector('.videoNameDisplay').textContent;
                        let fileName = level.querySelector('.fileNameDisplay').textContent;

                        formData.append("videoFile",videoFile);
                        formData.append("file",file);
                        formData.append("levelNumber", level.id);
                        formData.append("courseId", <?= $courseId ?>);

                        await fetch("/Content/patch",{
                            method:"POST",
                            body: formData
                        })
                    });

        }
        swal({
            icon: 'success',
            title: '🎉',
            text: `Course ${isUpdating ? 'updated' : 'created'} successfully!`,
        }).then(() => {
            CreateButton.value = `${isUpdating ? 'Update' : 'Create'} Course`;
            CreateButton.disabled = false;
            CreateButton.textContent = `${isUpdating ? 'Update' : 'Create'} Course`;
            CreateButton.style.opacity = 1;
        });
    } catch (error) {
        console.error("Error during course creation or update:", error);
        swal({
            icon: 'error',
            title: '❌',
            text: `An error occurred while ${isUpdating ? 'updating' : 'creating'} the course.
            ${error}`,
        }).then(() => {
            CreateButton.value = `${isUpdating ? 'Update' : 'Create'} Course`;
            CreateButton.disabled = false;
            CreateButton.textContent = `${isUpdating ? 'Update' : 'Create'} Course`;
            CreateButton.style.opacity = 1;
        });
    }
}

    document.querySelector('#createCourse').addEventListener('click',(event) => {
        event.preventDefault();
        if(!<?= json_encode($isUpdating) ?>)
        handleCourseCreationOrUpdate(false);
        else
        handleCourseCreationOrUpdate(true, <?=$courseId?>);
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