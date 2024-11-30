<?php
    require 'views/components/header.php';
    require 'views/components/navbar.php';
?>
<div class="container mx-auto flex h-full space-y-2 sm:space-y-0 space-x-4 items-center flex-col sm:flex-row">

    <div class=" w-5/6 sm:w-2/3 h-full font-bold">
        <div id="CourseName" class="text-primary text-md">
            Course name
        </div>
        <div id="LevelName" class="text-secondary text-2xl">
            Level name
        </div>
        <div class="bg-gray-600 m-4 rounded-xl">
            <video id="Levelvideo" controls class="rounded-xl" src="https://videos.pexels.com/video-files/855390/855390-uhd_2560_1440_25fps.mp4" autoplay loop></video>
        </div>

        <div class="text-xl text-secondary">
            Resources
            <div id="ResourcesContainer" class="bg-primary space-y-2 rounded-md p-2">
            </div>
        </div>

        <div class="mt-3">
        <button id="FinishLevel" class="w-full p-2 bg-primary rounded-md text-color">Finish Level</button>
        </div>
    </div>

    <div class="bg-primary w-5/6 sm:w-1/3 rounded-md overflow-y-scroll h-screen sm:h-full">
        <div class="mt-4 text-center text-comp-2 font-bold text-3xl">
            Content
        </div>
        <div id="LevelsContainer" class="mx-4">
        </div>
    </div>
</div>

<script>
const users = {};

document.addEventListener("DOMContentLoaded", async ()=>{
    const usersResponse = await fetch('/users');
    const usersData = await usersResponse.json();
    usersData.payload.users.forEach(user => {
        users[user.userId] = user;
    });
    
    let CourseId = <?= $_GET['course'] ?? 1 ?>;
    let LevelsFound = {}; 

    function getCourseInformation(){
        fetch("/courses/get?course_id=" + CourseId)
        .then(response => response.json())
        .then(data => {
            document.getElementById("CourseName").textContent = data.payload.courses[0].courseTitle;
        });
    }
    function getLevelsInformation(){
        let PurchasedLevels = {};        
        fetch("/purchasedLevels/get?user_Id=" + <?= json_encode($_SESSION['user']['userId']) ?>)
        .then(response => response.json())
        .then(data => {
            PurchasedLevels = data.payload.PurchasedLevels;
        });

        fetch("/level?course_id=" + CourseId)
        .then(response => response.json())
        .then(data => {
            LevelsFound = data.payload.levels;

            LevelsFound.forEach(levelFound => {
                    const levelPreviewContainer = document.getElementById("LevelsContainer");
                    const levelPreview = document.createElement('div');
                    let levelhtml = `<?php require 'views/components/levelPreview.php'; ?>`;
                    levelhtml = levelhtml.replace(/LEVEL_ID/g,levelFound.levelId);
                    levelhtml = levelhtml.replace(/LEVEL_NUM/g,levelFound.levelNumber);
                    levelhtml = levelhtml.replace(/COURSE_ID/g,levelFound.courseId);
                    levelhtml = levelhtml.replace(/LEVEL_NAME/g,levelFound.levelName);
                    levelPreview.innerHTML = levelhtml;

                    levelPreviewContainer.append(levelPreview);
                    
                    levelPreview.querySelector(".Level").onclick = function () {
                        alert("No lo tienes comprado gg");
                    };

                    const exists = PurchasedLevels.some(Purchasedlevel => Purchasedlevel.levelId === levelFound.levelId);
                    if(exists)
                    {
                        levelPreview.querySelector(".Level").onclick = function () {
                            location.href = '/levels?level=' + levelFound.levelId + '&course=' + levelFound.courseId;
                            };
                    }

                    if (<?= $_GET["level"] ?> === levelFound.levelId) {
                        const levelNameElement = document.getElementById("LevelName");
                        if (levelNameElement) {
                            levelNameElement.textContent = levelFound.levelName;
                        }
                    }
            });
        });
    }

    function getLevelInformation(){
            fetch("/Content/get?level_id="+<?= $_GET["level"];?>)
            .then(response => response.json())
            .then(data => {
                const ContentFound = data.payload.content;

                ContentFound.forEach(Content => {
                if(Content.mimeType === ".mp4")
                {
                    let Route = atob(Content.file);
                    const decodedRoute = atob(Route);
                    console.log(decodedRoute);
                    const videoElement = document.getElementById("Levelvideo");
                    videoElement.src = decodedRoute;
                    videoElement.load();
                    videoElement.play();
                }
                else{
                    const levelPreviewContainer = document.getElementById("ResourcesContainer");
                    const levelPreview = document.createElement('div');
                    let levelhtml = `<?php require 'views/components/resource.php'; ?>`;
                    levelhtml = levelhtml.replace(/RESOURCE_ID/g,ContentFound.contentId);
                    levelPreview.innerHTML = levelhtml;

                    levelPreviewContainer.append(levelPreview);
                    document.getElementById("Resource").textContent = Content.name;
                }
                });
        });
    }
    getCourseInformation();
    getLevelInformation();
    getLevelsInformation();
});

document.getElementById("FinishLevel").addEventListener("click",function(){
    let formData = new FormData();

    formData.append("user_Id",<?= json_encode($_SESSION['user']['userId']) ?>);
    formData.append("level_Id",<?= $_GET["level"];?>);
    formData.append("completed",1);
    
    fetch("/purchasedLevels/put",{
    method:"POST",
    body:formData
    }).then(response => response.json())
    .then(data => console.log(data));
    
    
});
</script>