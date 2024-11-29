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
                <button onclick="goToCheckout()"class="w-full bg-comp-1 text-sm p-2 text-color rounded-md font-bold">PROCEED TO CHECKOUT</button>
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
let subTotalAmount = 0.0;
let totalAmount = 0.0;
let cart = JSON.parse(localStorage.getItem('cart')) || [];
const cartItems = [];
let categoriesData = {};
const users = {};

document.addEventListener('DOMContentLoaded', async () => {

    const categoriesResponse = await fetch('/categories');
    categoriesData = await categoriesResponse.json();
    categoriesData = categoriesData.payload.categories;

    let levelsInCourses = [];

    const usersResponse = await fetch('/users');
    const usersData = await usersResponse.json();
    usersData.payload.users.forEach(user => {
        users[user.userId] = user;
    });

    async function loadcart(){
        cart = JSON.parse(localStorage.getItem('cart')) || [];
        totalCourses.innerText = cart.length;
        subTotalAmount = 0;
        totalAmount = 0;
        subTotal.innerText = `$${subTotalAmount} MXN`;
        total.innerText = `$${totalAmount} MXN`;
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
                        .replace('removeFromCart(0)', `removeFromCart(${course.courseId})`)
                    
                    if (course.coursePrice !== null) {
                        courseCard = courseCard.replace('<option value="0">ALLCOURSESORLEVELS</option>', `<option value="0">ALL LEVELS</option>`)
                            .replace('<select class="courseLevelChosen bg-comp-1 text-color rounded p-1">', `<select disabled class="courseLevelChosen bg-comp-1 text-color rounded p-1">`);
                        subTotalAmount += parseFloat(course.coursePrice);
                        cartItems.push(course);
                    }
                    else {
                        const levelResponse = await fetch(`/level?course_id=${course.courseId}`);
                        const levelData = await levelResponse.json();
                        if (levelData.status && levelData.payload.levels.length > 0) {
                            let levels = '';
                            for (const level of levelData.payload.levels) {
                                levels += `<option id="level-${level.levelId}" value="${level.levelCost}">${level.levelName}</option>`;
                                levelsInCourses.push(level);
                            }
                            const firstLevelCost = parseFloat(levelData.payload.levels[0].levelCost);
                            courseCard = courseCard.replace('<option value="0">ALLCOURSESORLEVELS</option>', levels)                            
                                                        .replace('<select class="courseLevelChosen bg-comp-1 text-color rounded p-1">', `<select data-previous-selection="${levelData.payload.levels[0].levelId}" data-previous-cost="${firstLevelCost}" class="courseLevelChosen bg-comp-1 text-color rounded p-1">`);
                            subTotalAmount += parseFloat(firstLevelCost);
                            cartItems.push(levelData.payload.levels[0]);
                        }
                            
                    }

                    cartCourseCards.innerHTML += courseCard;
                }
                                  

                totalAmount = subTotalAmount * 1.15;
                subTotal.innerText = `$${parseFloat(subTotalAmount).toFixed(2)} MXN`;
                total.innerText = `$${parseFloat(totalAmount).toFixed(2)} MXN`;

            } catch (error) {
                console.error('Error fetching course data:', error);
            }
        }

        document.querySelectorAll('.courseLevelChosen').forEach(select => {
            select.addEventListener('change', (event) => {
                const selectedOption = event.target.options[event.target.selectedIndex];
                const selectedCost = parseFloat(selectedOption.value);
                const previousCost = parseFloat(event.target.getAttribute('data-previous-cost')) || 0;

                subTotalAmount = subTotalAmount - previousCost + selectedCost;
                totalAmount = subTotalAmount * 1.15;

                subTotal.innerText = `$${subTotalAmount.toFixed(2)} MXN`;
                total.innerText = `$${totalAmount.toFixed(2)} MXN`;

                const previousSelectionId = event.target.getAttribute('data-previous-selection');
                const newSelectionId = selectedOption.id.split('-')[1];

                if (previousSelectionId) {
                    const previousLevelIndex = cartItems.findIndex(item => item.levelId == previousSelectionId);
                    if (previousLevelIndex !== -1) {
                        cartItems.splice(previousLevelIndex, 1);
                    }
                }

                const newLevel = levelsInCourses.find(level => level.levelId == newSelectionId);
                cartItems.push(newLevel);

                event.target.setAttribute('data-previous-selection', newSelectionId);
                event.target.setAttribute('data-previous-cost', selectedCost);
            });
        });
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
    subTotalAmount = 0;
    totalAmount = 0;
    subTotal.innerText = `$${subTotalAmount} MXN`;
    total.innerText = `$${totalAmount} MXN`;
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
                    .replace('removeFromCart(0)', `removeFromCart(${course.courseId})`)
                
                if (course.coursePrice !== null) {
                    courseCard = courseCard.replace('<option value="0">ALLCOURSESORLEVELS</option>', `<option value="0">ALL LEVELS</option>`)
                        .replace('<select class="courseLevelChosen bg-comp-1 text-color rounded p-1">', `<select disabled class="courseLevelChosen bg-comp-1 text-color rounded p-1">`);
                    subTotalAmount += parseFloat(course.coursePrice);
                    cartItems.push(course);
                }
                else {
                    const levelResponse = await fetch(`/level?course_id=${course.courseId}`);
                    const levelData = await levelResponse.json();
                    if (levelData.status && levelData.payload.levels.length > 0) {
                        let levels = '';
                        for (const level of levelData.payload.levels) {
                            levels += `<option id="level-${level.levelId}" value="${level.levelCost}">${level.levelName}</option>`;
                            levelsInCourses.push(level);
                        }
                        const firstLevelCost = parseFloat(levelData.payload.levels[0].levelCost);
                        courseCard = courseCard.replace('<option value="0">ALLCOURSESORLEVELS</option>', levels)                            
                                                    .replace('<select class="courseLevelChosen bg-comp-1 text-color rounded p-1">', `<select data-previous-selection="${levelData.payload.levels[0].levelId}" data-previous-cost="${firstLevelCost}" class="courseLevelChosen bg-comp-1 text-color rounded p-1">`);
                        subTotalAmount += parseFloat(firstLevelCost);
                        cartItems.push(levelData.payload.levels[0]);
                    }
                        
                }
                cartCourseCards.innerHTML += courseCard;
            }
                              
            totalAmount = subTotalAmount * 1.15;
            subTotal.innerText = `$${parseFloat(subTotalAmount).toFixed(2)} MXN`;
            total.innerText = `$${parseFloat(totalAmount).toFixed(2)} MXN`;
        } catch (error) {
            console.error('Error fetching course data:', error);
        }
    }
    document.querySelectorAll('.courseLevelChosen').forEach(select => {
        select.addEventListener('change', (event) => {
            const selectedOption = event.target.options[event.target.selectedIndex];
            const selectedCost = parseFloat(selectedOption.value);
            const previousCost = parseFloat(event.target.getAttribute('data-previous-cost')) || 0;
            subTotalAmount = subTotalAmount - previousCost + selectedCost;
            totalAmount = subTotalAmount * 1.15;
            subTotal.innerText = `$${subTotalAmount.toFixed(2)} MXN`;
            total.innerText = `$${totalAmount.toFixed(2)} MXN`;
            const previousSelectionId = event.target.getAttribute('data-previous-selection');
            const newSelectionId = selectedOption.id.split('-')[1];
            if (previousSelectionId) {
                const previousLevelIndex = cartItems.findIndex(item => item.levelId == previousSelectionId);
                if (previousLevelIndex !== -1) {
                    cartItems.splice(previousLevelIndex, 1);
                }
            }
            const newLevel = levelsInCourses.find(level => level.levelId == newSelectionId);
            cartItems.push(newLevel);
            event.target.setAttribute('data-previous-selection', newSelectionId);
            event.target.setAttribute('data-previous-cost', selectedCost);
        });
    });
}

function goToCheckout(){
    if (cart.length === 0) {
        swal("🚫", "Your cart is empty. Please add courses to your cart before proceeding to checkout.", "error");
    } else {
        sessionStorage.setItem('checkoutItems', JSON.stringify(cartItems));
        window.location.href = '/checkout';
    }
}

</script>