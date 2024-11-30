<?php
    require 'views/components/header.php';
    require 'views/components/navbar.php';
?>
<div class="container mx-auto">
    <h1 class="text-8xl text-primary text-center font-extrabold tracking-wide">FOC<span class="text-secondary">US</span></h1>
    <div class="w-full text-4xl text-primary font-bold my-5">
        Most rated
    </div>
    <div class="h-1 bg-secondary"></div>
    <div id="mostRated" class="w-full h-1/2 py-2 flex flex-col items-center md:flex-row overflow-y-hidden overflow-x-auto">
        <p class="loadingText text-3xl self-center justify-self-center animate-bounce">Loading...</p>
    </div>
    <div class="w-full text-4xl text-primary font-bold my-5">
        Best seller
    </div>
    <div class="h-1 bg-secondary"></div>
    <div id="bestSelling" class="w-full h-1/2 py-2 flex flex-col items-center md:flex-row overflow-y-hidden overflow-x-auto">
        <p class="loadingText text-3xl self-center justify-self-center animate-bounce">Loading...</p>
    </div>
    <div class="w-full text-4xl text-primary font-bold my-5">
        Recently uploaded
    </div>
    <div class="h-1 bg-secondary"></div>
    <div id="recentlyUpdated" class="w-full h-1/2 py-2 flex flex-col items-center md:flex-row overflow-y-hidden overflow-x-auto">
        <p class="loadingText text-3xl self-center justify-self-center animate-bounce">Loading...</p>
    </div>
    <div class="w-full text-4xl text-primary font-bold my-5">
        Categories
    </div>
    <div class="h-1 bg-secondary"></div>
    <div id="categories" class="w-full h-1/2 py-5 flex flex-col justify-center items-center space-x-0 md:space-x-12 md:flex-row overflow-y-hidden overflow-x-auto">
        <p class="loadingText text-3xl self-center justify-self-center animate-bounce">Loading...</p>
    </div>
</div>

<script>

let users = {};

fetch("/users").then(response => response.json()).then(data => {
    data.payload.users.forEach(user => {
        users[user.userId] = user;
    });
});

fetch("/categories")
.then(response => response.json())
.then(data => {
    const categoriesContainer = document.getElementById("categories");

    data.payload.categories.forEach((category) => {
        categoriesContainer.innerHTML = data.payload.categories
            .map(
                (category) => `
                <div class="flex-col justify-center w-1/2 h-1/2 md:w-1/5 md:h-1/5 mb-5 bg-color rounded-2xl">
                    <a href="/advSearch?category=${category.categoryId}">
                        <h2 class="text-center font-extrabold text-secondary text-4xl mb-3">${category.categoryName}</h2>
                        <p class="text-center text-primary text-lg font-semibold">${category.categoryDescription}</p>
                    </a>
                </div>
                `
            )
            .join("");
    });
});

fetch("/courses/get")
    .then(response => response.json())
    .then(data => {
        if (data.status) {
            const recentlyUpdatedContainer = document.getElementById("recentlyUpdated");
            let courses = data.payload.courses;

            courses.sort((a, b) => new Date(b.creationDate) - new Date(a.creationDate));

            courses = courses.slice(0, 10);

            recentlyUpdatedContainer.innerHTML = courses
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
            console.error('No courses found');
        }
    })
    .catch(error => {
        console.error('Error fetching courses:', error);
    });

fetch("/courses/get?top_sellers=true")
    .then(response => response.json())
    .then(data => {
        if (data.status) {
            const bestSellingContainer = document.getElementById("bestSelling");
            let courses = data.payload.courses;

            courses = courses.slice(0, 10);

            bestSellingContainer.innerHTML = courses
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
            console.error('No courses found');
        }
    })
    .catch(error => {
        console.error('Error fetching courses:', error);
    });

    fetch("/courses/get?top_rating=true")
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                const mostRatedContainer = document.getElementById("mostRated");
                let courses = data.payload.courses;

                courses = courses.slice(0, 10);

                mostRatedContainer.innerHTML = courses
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
                console.error('No courses found');
            }
        })
        .catch(error => {
            console.error('Error fetching courses:', error);
        });
</script>