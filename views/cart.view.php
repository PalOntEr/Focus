<?php
    require 'views/components/header.php';
?>
<div class="w-screen h-screen overflow-x-hidden">
<?php
    require 'views/components/navbar.php';
?>
<div class="container flex flex-col mx-auto h-full">
<h1 class="text-8xl text-primary text-center font-extrabold tracking-wide">Cart</h1>
<div class="flex flex-row my-5">
    <div class="w-1/4">
        <div id="Cart-Container" class="sticky top-24 h-auto bg-primary rounded-md p-4">
            <div>
                <div class="font-bold text-comp-1 text-sm my-3">Total Courses: <span id="totalCourses" class="font-normal text-color">0</span></div>
                <div class="font-bold text-comp-1 text-sm my-3">SUBTOTAL: <span id="subTotal" class="font-normal text-color">$0.00 MXN</span></div>
                <div class="font-bold text-comp-1 text-sm my-3">TOTAL: <span id="total" class="font-normal text-color">$0.00 MXN</span></div>
                <div class="h-px w-full bg-comp-2 my-4"></div>   
                <button onclick="location.href='/checkout'"class="w-full bg-comp-1 text-sm p-2 text-color rounded-md font-bold">PROCEED TO CHECKOUT</button>
            </div>
        </div>
    </div>

    <div id="cartCourseCards" class="w-3/4 h-3/4 flex flex-col ml-2 space-y-2 items-center rounded-xl">
        <p class="text-3xl self-center justify-self-center animate-bounce">Add courses to your cart to see them here...</p>
    </div>
</div>
</div>
<script>

const cartCourseCards = document.getElementById('cartCourseCards');
const totalCourses = document.getElementById('totalCourses');
const subTotal = document.getElementById('subTotal');
const total = document.getElementById('total');
let subTotalAmount = 0;
let totalAmount = 0;
let cart = JSON.parse(localStorage.getItem('cart')) || [];
let categoriesData = {};
const users = {};

document.addEventListener('DOMContentLoaded', async () => {

    const categoriesResponse = await fetch('/categories');
    categoriesData = await categoriesResponse.json();
    categoriesData = categoriesData.payload.categories;

    const usersResponse = await fetch('/users');
    const usersData = await usersResponse.json();
    usersData.payload.users.forEach(user => {
        users[user.userId] = user;
    });

    async function loadcart(){
        cart = JSON.parse(localStorage.getItem('cart')) || [];
        totalCourses.innerText = cart.length;
        if (cart.length === 0) {
            cartCourseCards.innerHTML = '<p class="text-3xl self-center justify-self-center animate-bounce">Add courses to your cart to see them here...</p>';
            return;
        }
        cartCourseCards.innerHTML = '';
        for (const courseId of cart) {
            try {
                const coursesResponse = await fetch(`/courses/get?course_id=${courseId}`);
                const coursesData = await coursesResponse.json();

                if (coursesData.status && coursesData.payload.courses.length > 0) {
                    const course = coursesData.payload.courses[0];
                    let courseCard = `<?php require 'views/components/buycourseCard.php'; ?>`;
                    courseCard = courseCard
                        .replace('https://pbs.twimg.com/media/GVq8fLsaoAEnzsl?format=jpg&name=large', course.courseImage ? 'data:image/jpeg;base64,' + course.courseImage : 'https://pbs.twimg.com/media/GVq8fLsaoAEnzsl?format=jpg&name=large')
                        .replace('PHP Course - 4.3/5⭐', `${course.courseTitle} - ${course.courseRating}/5⭐`)
                        .replace('Computer Science', categoriesData[course.categoryId - 1].categoryName)
                        .replace('Instructor', users[course.instructorId].username)
                        .replace('Descripcion', course.courseDescription)
                        .replace('removeFromCart(0)', `removeFromCart(${course.courseId})`);
                    cartCourseCards.innerHTML += courseCard;
                    subTotalAmount += parseFloat(course.coursePrice).toFixed(2);
                }
                
                subTotal.innerText = `$${subTotalAmount} MXN`;
                totalAmount = (subTotalAmount * 1.15).toFixed(2);
                total.innerText = `$${totalAmount} MXN`;

            } catch (error) {
                console.error('Error fetching course data:', error);
            }
        }
    }

    loadcart();
    
});

function removeFromCart(id){
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const newCart = cart.filter(courseId => courseId !== id);
    localStorage.setItem('cart', JSON.stringify(newCart));
    loadcart2();
}

async function loadcart2(){
    cart = JSON.parse(localStorage.getItem('cart')) || [];
    totalCourses.innerText = cart.length;
    if (cart.length === 0) {
        cartCourseCards.innerHTML = '<p class="text-3xl self-center justify-self-center animate-bounce">Add courses to your cart to see them here...</p>';
        return;
    }
    cartCourseCards.innerHTML = '';
    for (const courseId of cart) {
        try {
            const coursesResponse = await fetch(`/courses/get?course_id=${courseId}`);
            const coursesData = await coursesResponse.json();

            if (coursesData.status && coursesData.payload.courses.length > 0) {
                const course = coursesData.payload.courses[0];
                let courseCard = `<?php require 'views/components/buycourseCard.php'; ?>`;
                courseCard = courseCard
                    .replace('https://pbs.twimg.com/media/GVq8fLsaoAEnzsl?format=jpg&name=large', course.courseImage ? 'data:image/jpeg;base64,' + course.courseImage : 'https://pbs.twimg.com/media/GVq8fLsaoAEnzsl?format=jpg&name=large')
                    .replace('PHP Course - 4.3/5⭐', `${course.courseTitle} - ${course.courseRating}/5⭐`)
                    .replace('Computer Science', categoriesData[course.categoryId - 1].categoryName)
                    .replace('Instructor', users[course.instructorId].username)
                    .replace('Descripcion', course.courseDescription)
                    .replace('removeFromCart(0)', `removeFromCart(${course.courseId})`);
                cartCourseCards.innerHTML += courseCard;
                subTotalAmount += course.coursePrice;
            }
            
            subTotal.innerText = `$${subTotalAmount} MXN`;
            totalAmount = subTotalAmount * 1.15;
            total.innerText = `$${totalAmount} MXN`;

        } catch (error) {
            console.error('Error fetching course data:', error);
        }
    }
}

</script>