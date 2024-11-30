<?php
require 'views/components/header.php';
require 'views/components/navbar.php';
$usertype = $_SESSION['user']['role'] ?? 'guest';
?>

<div class="flex flex-col container sm:mx-auto overflow-x-hidden items-center">
    <div class="h-1/3 flex flex-col sm:flex-row w-5/6 sm:w-full sm:space-x-2 space-y-2 sm:space-y-0 justify-center mx-2 sm:mx-0 items-center sm:items-start">
        <?php require 'views/components/courseInfo.php'; ?>
        <div id="description" class="flex bg-primary w-5/6 sm:w-2/3 h-full px-5 py-2 text-justify text-color rounded-xl overflow-y-scroll">
            In this course, you will learn the fundamentals of PHP programming, including syntax, control structures, functions, and object-oriented programming. You will also explore advanced topics such as database interactions, session management, and security practices. By the end of the course, you will be able to build dynamic and interactive web applications using PHP.

            The course is designed to provide hands-on experience through practical exercises and real-world projects. You will start with basic PHP scripts and gradually move on to more complex applications. Topics covered include:

            - PHP Syntax and Variables<br>
            - Control Structures (if, else, switch, loops)<br>
            - Functions and Scope<br>
            - Arrays and Superglobals<br>
            - Form Handling and Validation<br>
            - File Handling<br>
            - Introduction to MySQL and Database Operations<br>
            - Session and Cookie Management<br>
            - Error Handling and Debugging<br>
            - Security Best Practices<br>
            - Introduction to PHP Frameworks<br>

            Whether you are a beginner looking to start your programming journey or an experienced developer wanting to enhance your skills, this course will provide you with the knowledge and tools needed to succeed in PHP development.
        </div>
        <div id="EditCourse">
        <?php if ($usertype === 'I'): ?>
                <button class="delete-button" onclick="location.href='/createCourse?update=true&courseId=<?= $_GET['course_id'] ?>'">
                    <img class="h-5 w-5 bg-color p-1 rounded-full" src="https://cdn-icons-png.flaticon.com/512/1042/1042474.png" alt="delete">
                </button>
                <?php endif; ?>
            </div>
    </div>
    <div class="w-full h-1/3 flex flex-col items-center sm:items-start mx-4 sm:mx-0">
        <h1 class="text-4xl font-bold text-primary">LEVELS</h1>
        <div class="h-0.5 bg-comp-1 w-full"></div>
        <div id="LevelsContainer" class="flex flex-row items-center justify-center h-96 w-5/6 sm:w-full my-2 overflow-y-scroll sm:overflow-y-auto flex-wrap">
        </div>
    </div>
    <div class="h-1/3 w-full flex flex-col items-center sm:items-start mx-4 sm:mx-0">
        <div class="flex w-full justify-between items-center">
            <h1 class="text-4xl font-bold text-primary">REVIEWS</h1>
            <div id="CommentButton">
            <button onclick ="showCommentModal()" class="comment-button">
                <img class="h-5" src="https://cdn-icons-png.flaticon.com/512/1042/1042474.png" alt="">
        </button>
        </div>
        </div>
        <div class="h-0.5 bg-comp-1 w-full"></div>
        <div id="CommentsContainer" class="container mx-auto flex flex-row items-center justify-center h-96 overflow-y-scroll sm:overflow-y-auto w-5/6 sm:w-full my-2 flex-wrap">
            <?php
            ?>
        </div>
    </div>
</div>

<div id="commentModal" class="modal hidden fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center">
    <div class="bg-white p-5 rounded-lg sm:w-1/3">
        <h2 class="text-lg font-semibold mb-4">Make review</h2>
        <p class="mb-2">Comment</p>
        <textarea id="comment" class="w-full p-2 rounded border border-gray-300" rows="4"></textarea>
        <p class="">Rating</p>
        <div class="flex mb-4">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <span class="star" data-value="<?php echo $i; ?>" onclick="rateStar(<?php echo $i; ?>)">&#9733;</span>
            <?php endfor; ?>
        </div>
        <div class="flex justify-end">
            <button class="bg-gray-300 px-4 py-2 rounded mr-2" onclick="hideCommentModal()">Cancel</button>
            <button class="bg-green-500 text-white px-4 py-2 rounded" onclick="confirmComment()">Comment</button>
        </div>
    </div>
</div>

<script>
const users = {};
let CourseId = <?= $_GET['course_id'] ?? 1 ?>;
let CompletedCourse = false;

document.addEventListener("DOMContentLoaded", async ()=>{
    const usersResponse = await fetch('/users');
    const usersData = await usersResponse.json();
    usersData.payload.users.forEach(user => {
        users[user.userId] = user;
    });
    
    let CourseImage;
    function getCourseInformation()
    {
    
        fetch("/courses/get?course_id=" + CourseId)
        .then(response => response.json())
        .then(data => {
            const CourseInfo = data.payload.courses[0];
            let Description = document.getElementById("description");
            let Title = document.getElementById("Title");
            let Image = document.getElementById("CourseImage");
            let Instructor = document.getElementById("Instructor");
            Description.textContent= CourseInfo.courseDescription;
            Title.textContent = CourseInfo.courseTitle;
            Instructor.textContent = users[CourseInfo.instructorId].username;

            if(<?= json_encode($_SESSION['user']['userId']) ?> === CourseInfo.instructorId)
            {
                document.getElementById("EditCourse").hidden = false;
            }
            else{
                document.getElementById("EditCourse").hidden = true;
            }
            Image.src = "data:image/*;base64," + CourseInfo.courseImage;
            CourseImage = Image.src;
        });
    }
    
    function getLevelsOfCourse(){
        let PurchasedLevels = {};        
        fetch("/purchasedLevels/get?user_Id=" + <?= json_encode($_SESSION['user']['userId']) ?>)
        .then(response => response.json())
        .then(data => {
            PurchasedLevels = data.payload.PurchasedLevels;
        });

        fetch("/level?course_id="+ CourseId)
        .then(response => response.json())
        .then(data => {
            const Levels = data.payload.levels;
            Levels.forEach((level,index) => {
                const levelPreviewContainer = document.getElementById("LevelsContainer");
                const levelPreview = document.createElement('div');
                let levelhtml = `<?php require 'views/components/levelCard.php'; ?>`;
                levelhtml = levelhtml.replace(/LEVEL_NUM/g, index+1);
                levelhtml = levelhtml.replace(/LEVEL_ID/g, level.levelId);
                levelhtml = levelhtml.replace(/COURSE_ID/g, level.courseId);
                levelPreview.innerHTML = levelhtml;
    
                levelPreview.querySelector(".LevelName").textContent = level.levelName;
                levelPreview.querySelector(".CourseImage").src = CourseImage;
                levelPreview.querySelector(".Play").disabled = true;

                if (PurchasedLevels !== undefined) {
 
                    const exists = PurchasedLevels.some(Purchasedlevel => Purchasedlevel.levelId === level.levelId);
                    if(exists)
                    {
                        levelPreview.querySelector(".Play").disabled = false;
                    }
                
                    const matchedLevels = PurchasedLevels.filter(purchasedLevel => purchasedLevel.levelId === level.levelId);
                    levelPreviewContainer.append(levelPreview);
                    console.log(PurchasedLevels);
                    console.log(matchedLevels);
                    if(matchedLevels.length !== 0)
                    {
                        if(matchedLevels[0].completed === 0)
                        {
                            CompletedCourse = true;
                        }
                    }
                    else
                    {
                        CompletedCourse = true;
                    }
                }  
            });
            document.getElementById("CommentButton").hidden = CompletedCourse;
        });

    }
    
    
    getCourseInformation();
    getLevelsOfCourse();
    getReviewsOfCourse(); 
});

function getReviewsOfCourse(){
    fetch("/deletedComments/Get")
    .then(response => response.json())
    .then(data => {
        let DeletedComments = data.payload.DeletedComments;
        fetch("/comments?course_id="+CourseId)
        .then(response => response.json())
        .then(data => {
            const Reviews = data.payload;
            let HasReviewed = false;
            let AvgRating = 0;
            const levelPreviewContainer = document.getElementById("CommentsContainer");
            levelPreviewContainer.innerHTML = "";
            Reviews.forEach(review => {
                    const levelPreview = document.createElement('div');
                    let levelhtml = `<?php require 'views/components/commentCard.php'; ?>`;
                    levelhtml = levelhtml.replace(/COMMENT_ID/g, review.commentId);
                    levelPreview.innerHTML = levelhtml;
                    
                    console.log(users);
                    levelPreview.querySelector(".Rating").textContent = review.rating + "/5⭐";
                    levelPreview.querySelector(".User").textContent = users[review.userId].username;
                    levelPreview.querySelector(".Comment").textContent = review.comment;
                    levelPreview.querySelector(".CommentDate").textContent = review.creationDate;

                    const deleted = DeletedComments.some(DeletedComment => DeletedComment.commentId == review.commentId);   
                    if(deleted)
                    {
                        const matchedComments = DeletedComments.filter(DeletedComment => DeletedComment.commentId === review.commentId); // Returns an array of matches
                        levelPreview.querySelector(".Comment").textContent = "This comment was deleted. Reason: " + matchedComments[0].deletionReason; 
                    }

                    levelPreviewContainer.append(levelPreview);
                    if(review.userId === <?= json_encode($_SESSION['user']['userId']) ?>)
                    {
                        HasReviewed = true;
                    }
                    AvgRating += review.rating;
            });
    
            if(Reviews.length !== 0)
            {
                AvgRating /= Reviews.length;
            }
            document.getElementById("Rating").textContent = AvgRating+"/5⭐";
            if(!CompletedCourse)
            document.getElementById("CommentButton").hidden = HasReviewed;
    
            
        });
    });
}

function confirmComment() {
        const comment = document.querySelector('#comment').value.trim();
        if (comment === '') {
            swal({
                icon: 'error',
                text: 'Type a comment.',
                title: '☠️',
                confirmButtonText: 'OK'
            });
            return;
        }
    
        if (selectedRating === 0) {
            swal({
                icon: 'error',
                text: 'Select a rating.',
                title: '☠️',
                confirmButtonText: 'OK'
            });
            return;
        }
    
        let formData = new FormData();
    
        formData.append("comment", comment);
        formData.append("rating", selectedRating);
        formData.append("userId", <?= json_encode($_SESSION['user']['userId']) ?>);
        formData.append("courseId", <?= json_encode($_GET['course_id']) ?>)
    
        fetch("comments",{
            method:"POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            swal({
                title: '🌟',
                text: 'Comment has been created with a rating of ' + selectedRating + ' 🌟',
                icon: 'success',
                confirmButtonText: 'OK'
            });
            hideCommentModal();
        });
        getReviewsOfCourse();
    }

function showModal() {
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}

function hideModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
}

function confirmDelete() {
    const reason = document.querySelector('#deleteReason').value.trim();
    const modal = document.querySelector("#deleteReason").closest(".modal");
    const commentId = modal.querySelector(".DeleteButton").id;
    console.log(commentId);

    if (reason === '') {
        swal({
            title: 'Error!',
            text: 'Please provide a reason for deletion.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }

    let formData = new FormData();

    formData.append("commentId", commentId);
    formData.append("userId",<?= json_encode($_SESSION['user']['userId']) ?>);
    formData.append("deletionReason", reason);
    fetch("/deletedComments/Post",{
        method:"POST",
        body:formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
    });
    swal({
        title: 'Deleted!',
        text: 'Comment has been deleted.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
    hideModal();
}
function showCommentModal() {
    document.getElementById('commentModal').classList.remove('hidden');
    document.getElementById('commentModal').classList.add('flex');
}

function hideCommentModal() {
    document.getElementById('commentModal').classList.add('hidden');
    document.getElementById('commentModal').classList.remove('flex');
}

let selectedRating = 0;

function rateStar(rating) {
    selectedRating = rating;
    const stars = document.querySelectorAll('.star');
    stars.forEach((star, index) => {
        if (index < rating) {
            star.classList.add('text-yellow-300');
        } else {
            star.classList.remove('text-yellow-300');
        }
    });
}

</script>