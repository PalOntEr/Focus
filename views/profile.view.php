<?php
require 'views/components/header.php';
require 'views/components/navbar.php';

$usertype = $_SESSION['user']['role'] ?? 'G';
$MyProfile = $_GET['myProfile'] ?? 'false';
?>
<div id="User-container" class="container mx-auto">
    <div class="flex flex-row place-content-center lg:place-content-between">
        <div class="flex mb-5">
            <a href="/profile" class="self-center"><img id="profilePicture" class="md:flex md:h-48 md:w-48 hidden rounded-full" src="data:image/*;base64,<?=$_SESSION["user"]["profilePicture"] ?>" alt=""></a>
            <div class="self-center">
                <h2 id="User-Role" class="text-4xl text-center md:text-left text-secondary font-semibold"><?php if($MyProfile == 'false') echo 'Instructor'; else if ($usertype === 'S') echo 'Student'; else if ($usertype === 'I') echo 'Instructor'; else if ($usertype === 'A') echo 'Administrator'; else echo 'Private'; ?></h2>
                <h1 id="User" class="text-8xl text-primary font-extrabold"><?php if(!$MyProfile) echo 'Private Name'; else echo $_SESSION['user']['username']?></h1>
                <?php
                    $creationDate = new DateTime($_SESSION['user']['creationDate'] ?? '2000-01-01');
                    $monthYear = $creationDate->format('F Y');
                ?>
                <?php
                    $birthdate = new DateTime($_SESSION['user']['birthdate']);
                    $today = new DateTime();
                    $age = $today->diff($birthdate)->y;
                ?>
                
                    <p id="User-Info" class="text-secondary">Registered in <?php echo $monthYear; ?> <?php if ($MyProfile === 'true'): ?> Age: <?php echo $age; ?> years <?php endif; ?></p>

            </div>
        </div>
        <div id="User-Settings-Container" class="hidden lg:flex md:flex-row place-self-end w-auto  mb-2">
            <?php if ($MyProfile === 'true'): ?>
                <?php if ($usertype === 'S'): ?>
                    <input type="button" class="mx-2 py-1 px-2 text-sm text-color bg-secondary rounded-md" onclick="location.href='/kardex';" value="Kardex"></input>
                <?php endif; ?>
                <?php if ($usertype === 'I'): ?>
                    <input type="button" class="mx-2 py-1 px-2 text-sm text-color bg-secondary rounded-md" onclick="location.href='/sales';" value="Sales"></input>
                <?php endif; ?>
                <?php if ($usertype === 'A'): ?>
                    <input type="button" class="ml-2 py-1 px-2 text-sm text-color bg-secondary rounded-md" onclick="location.href='/reporte';" value="Report"></input>
                <?php endif; ?>
                <input type="button" class="mx-2 py-1 px-2 text-sm text-color bg-secondary rounded-md" onclick="location.href='/register?update=true';" value="Edit Profile"></input>
            <?php else: ?>
                <?php if($usertype === 'G'): ?>
                    <input type="button" class="mx-2 py-1 px-2 text-sm text-color bg-secondary rounded-md" onclick="location.href='/login';" value="Chat"></input>
                <?php else: ?>
                    <input type="button" class="mx-2 py-1 px-2 text-sm text-color bg-secondary rounded-md" onclick="location.href='/chats?insId=<?= $_GET['insId'] ?>';" value="Chat"></input>
                <?php endif; ?>  
            <?php endif; ?>
        </div>
    </div>
    <div class="w-full h-1 bg-secondary"></div>
    
    <?php if(($MyProfile === 'true' && $usertype === 'I') || ($MyProfile != 'true')): ?>
        <div class="w-full text-4xl text-secondary font-bold my-5">
            <?php echo $MyProfile === 'true' ? 'Your' : 'User' ?> Courses
        </div>
        <div id="Your-Courses-container" class="w-full h-[500px] flex flex-col items-center sm:flex-row overflow-y-hidden overflow-x-scroll">
            <p class="loadingText text-3xl self-center justify-self-center animate-bounce">Loading...</p>
        </div>

        <div class="w-full h-1 bg-secondary"></div>
    <?php endif; ?>
    
    <div class="w-full text-4xl text-secondary font-bold my-5">
        Recommended by  <?php echo $MyProfile === 'true' ? 'You' : 'User' ?>
    </div>
    <div id="Courses-container" class="w-full h-[500px] flex flex-col items-center sm:flex-row overflow-y-hidden overflow-x-scroll">
        <p class="loadingText text-3xl self-center justify-self-center animate-bounce">Loading...</p>
    </div>
</div>
<script>

    const userName = document.getElementById("User");
    const profilePicture = document.getElementById("profilePicture");
    let users = {};

    const insId = <?= $_GET['insId'] ?? 0 ?>;
    if (insId && insId == <?= $_SESSION['user']['userId'] ?? 0 ?>) {
        window.location.href = "/profile?myProfile=true";
    }

    fetch("/users").then(response => response.json()).then(data => {
        data.payload.users.forEach(user => {
            users[user.userId] = user;
        });
        if (<?= $MyProfile === 'true' ? 1 : 0 ?> === 0) {
            const insId = <?= $_GET['insId'] ?? 0 ?>;
            if (insId && users[insId]) {
                userName.innerText = users[insId].username;
                profilePicture.src = `data:image/*;base64,${users[insId].profilePicture}`;
            }
        }
    });

    function setRecommendedCourses(){
        fetch("/courses/get?user_rated_courses=true?instructorId=<?= $MyProfile === 'true' ? $_SESSION['user']['userId'] ?? 0 : $_GET['insId'] ?? 0?>")
            .then(response => response.json())
            .then(data => {
                const coursesContainer = document.getElementById("Courses-container");
                if (data.status) {
                    let courses = data.payload.courses;
    
                    coursesContainer.innerHTML = courses
                        .map(
                            (course) => {
                                let courseHtml = `<?php require 'views/components/courseCard.php'; ?>`;
                                courseHtml = courseHtml
                                    .replace('course-number', `course-${course.courseId}`)
                                    .replace('PHP Course', course.courseTitle)
                                    .replace('Instructor', users[course.instructorId].username)
                                    .replace('4.3/5⭐', `${course.averageRating}⭐`)
                                    .replace('https://pbs.twimg.com/media/GVq8fLsaoAEnzsl?format=jpg&name=large', `data:image/jpeg;base64,${course.courseImage}`)
                                    .replace('/course?course_id=0', `/course?course_id=${course.courseId}`)
                                    .replace('addToCart(0)', `addToCart(${course.courseId})`)
                                    .replace('?insId=0', `?insId=${course.instructorId}`);
                                return courseHtml;
                            }
                        )
                        .join("");
                } else {
                    coursesContainer.innerHTML = 'The user has not rated any courses yet';
                }
            })
            .catch(error => {
                console.error('Error fetching courses:', error);
            });
    }

    function setInstructorCourses(){
        fetch("/courses/get?instructor_id=<?= $MyProfile === 'true' ? $_SESSION['user']['userId'] ?? 0 : $_GET['insId'] ?? 0?>")
            .then(response => response.json())
            .then(data => {
                const coursesContainer = document.getElementById("Your-Courses-container");
                if (data.status) {
                    let courses = data.payload.courses;
    
                    coursesContainer.innerHTML = courses
                        .map(
                            (course) => {
                                let courseHtml = `<?php require 'views/components/courseCard.php'; ?>`;
                                courseHtml = courseHtml
                                    .replace('course-number', `course-${course.courseId}`)
                                    .replace('PHP Course', course.courseTitle)
                                    .replace('Instructor', users[course.instructorId].username)
                                    .replace('4.3/5⭐', `${course.averageRating}⭐`)
                                    .replace('https://pbs.twimg.com/media/GVq8fLsaoAEnzsl?format=jpg&name=large', `data:image/jpeg;base64,${course.courseImage}`)
                                    .replace('/course?course_id=0', `/course?course_id=${course.courseId}`)
                                    .replace('addToCart(0)', `addToCart(${course.courseId})`)
                                    .replace('?insId=0', `?insId=${course.instructorId}`);
                                return courseHtml;
                            }
                        )
                        .join("");
                } else {
                    coursesContainer.innerHTML = 'The user has not rated any courses yet';
                }
            })
            .catch(error => {
                console.error('Error fetching courses:', error);
            });
    }

    document.addEventListener("DOMContentLoaded", () => {
        setRecommendedCourses();
        if (<?= $MyProfile === 'false' ? 1 : 0 ?> === 1 || <?= $usertype === 'I' ? 1 : 0 ?> === 1) {
            setInstructorCourses();
        }
    });


</script>