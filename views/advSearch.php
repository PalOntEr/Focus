<?php
require 'views/components/header.php';
require 'views/components/navbar.php';
?>

<div class="container mx-auto flex flex-col h-full">
    <div class="flex w-full h-full mb-4 overflow-y-hidden">
        <div class="w-1/6 bg-primary rounded-md">
            <form id="filters" action="/advSearch" method="GET" class="p-4">
                <div class="mb-4">
                    <label for="category" class="block text-sm font-medium text-color">Category</label>
                    <select id="category" name="category" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md">
                        <option value="">Select a category</option>
                        <option value="0">All</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-color">Title</label>
                    <input type="text" id="title" name="title" class="px-2 py-1 rounded w-full">
                </div>
                <div class="mb-4">
                    <label for="user" class="block text-sm font-medium text-color">User who published course</label>
                    <select id="user" name="user" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md">
                        <option value="">Select an instructor</option>
                        <option value="0">All</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="start_date" class="block text-sm font-medium text-color">Start Date</label>
                    <input type="date" id="start_date" name="start_date" class="px-2 py-1 rounded w-full">
                </div>
                <div class="mb-4">
                    <label for="end_date" class="block text-sm font-medium text-color">End Date</label>
                    <input type="date" id="end_date" name="end_date" class="px-2 py-1 rounded w-full">
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="ml-2 px-2 py-1 bg-comp-2 text-secondary font-semibold rounded">Search</button>
                </div>
            </form>
        </div>
        <div id="results" class="flex h-full w-5/6 flex-wrap justify-center overflow-y-scroll">
            <p id="loadingText" class="text-3xl self-center justify-self-center animate-bounce">Loading...</p>
        </div>
    </div>
</div>

<script>

    let courseCard = `<?php require 'views/components/courseCard.php'; ?>`;
    let users = {};

    document.querySelector('#filters').addEventListener('submit', function(event) {
        event.preventDefault();
        
        var inputs = {
            startDate: document.getElementById('start_date').value,
            endDate: document.getElementById('end_date').value,
            category: document.getElementById('category').value,
            title: document.getElementById('title').value,
            user: document.getElementById('user').value,
        };

        if (inputs.startDate && inputs.endDate && new Date(inputs.startDate) > new Date(inputs.endDate)) {
            swal({
                icon: 'error',
                title: 'Invalid Date Range',
                text: 'Start Date must be before or the same day as End Date.',
            });
            return;
        }

        // if (!inputs.category && !inputs.title && !inputs.user && !inputs.startDate && !inputs.endDate) {
        //     swal({
        //         icon: 'error',
        //         title: 'No Filters Selected',
        //         text: 'Please select at least one filter before searching.',
        //     });
        //     return;
        // }

        let queryParams = [];
        if (inputs.category && inputs.category != 0) queryParams.push(`category_id=${inputs.category}`);
        if (inputs.title) queryParams.push(`course_title=${inputs.title}`);
        if (inputs.user && inputs.user != 0) queryParams.push(`instructor_id=${inputs.user}`);
        if (inputs.startDate) queryParams.push(`creation_date=${encodeURIComponent(inputs.startDate + ' 00:00:00')}`);
        if (inputs.endDate) queryParams.push(`modification_date=${encodeURIComponent(inputs.endDate + ' 23:59:59')}`);
        
        let queryString = queryParams.length ? '?' + queryParams.join('&') : '';

        fetch(`/courses/get${queryString}`)
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    const resultsContainer = document.getElementById('results');
                    resultsContainer.innerHTML = '';
                    data.payload.courses.forEach(course => {
                        let courseHtml = courseCard
                            .replace('course-number', `course-${course.courseId}`)
                            .replace('PHP Course', course.courseTitle)
                            .replace('Instructor', users[course.instructorId].username)
                            .replace('4.3/5⭐', `${course.averageRating}⭐`)
                            .replace('https://pbs.twimg.com/media/GVq8fLsaoAEnzsl?format=jpg&name=large', `data:image/jpeg;base64,${course.courseImage}`)
                            .replace('/course?course_id=0', `/course?course_id=${course.courseId}`)
                            .replace('addToCart(0)', `addToCart(${course.courseId})`);
                        resultsContainer.innerHTML += courseHtml;
                    });
                } else {
                    swal({
                        icon: 'error',
                        title: 'No Courses Found',
                        text: 'No courses matched your search criteria.',
                    });
                }
            })
            .catch(error => {
                console.error('Error fetching courses:', error);
                swal({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while fetching courses. Please try again later.',
                });
            });
    });

    document.addEventListener('DOMContentLoaded',async function() {
        const urlParams = new URLSearchParams(window.location.search);

        await fetch("/categories").then(response => response.json()).then(data => {
            const categorySelector = document.getElementById("category");
            data.payload.categories.forEach((category) => {
                const option = document.createElement("option");
                option.value = category.categoryId;
                const a = document.createElement("a");
                a.className = "block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                a.textContent = category.categoryName;
                option.appendChild(a);
                categorySelector.appendChild(option);
            });
            const categoryParam = urlParams.get('category');
            if (categoryParam) {
            document.getElementById('category').value = categoryParam;
            }
        });
        
        const titleParam = urlParams.get('search');
        if (titleParam) {
            document.getElementById('title').value = titleParam;
        }

        fetch('/users')
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    users = data.payload.users.reduce((acc, user) => {
                        acc[user.userId] = user;
                        return acc;
                    }, {});
                    const userSelector = document.getElementById('user');
                    data.payload.users.forEach(user => {
                        if (user.role === 'I') {
                            const option = document.createElement('option');
                            option.value = user.userId;
                            option.textContent = user.username;
                            userSelector.appendChild(option);
                        }
                    });
                } else {
                    swal({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to fetch users.',
                    });
                }
            })
            .catch(error => {
                console.error('Error fetching users:', error);
                swal({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while fetching users. Please try again later.',
                });
            });

        

        document.querySelector('#filters').dispatchEvent(new Event('submit'));
    });
</script>