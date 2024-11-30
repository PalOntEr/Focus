<?php
require 'views/components/header.php';
?>
<div class="w-screen h-screen overflow-x-hidden">
    <?php
    require 'views/components/navbar.php';
    ?>
    <div class="container mx-auto items-center md:items-start flex flex-col sm:flex-row h-2/3 my-16">
        <div class="w-full mx-4 h-full flex flex-col">
            <h1 class="text-center text-8xl text-primary font-extrabold tracking-wide">FOC<span class="text-secondary">US</span></h1>
            <h2 class="text-center text-4xl font-bold text-primary">Check<span class="text-secondary">out</span></h2>
            <div class="w-full bg-primary h-0.5 my-6"></div>
            <form id="checkout" class="flex flex-col text-md space-y-12 h-full justify-between ">
                <div>
                    <label for="Email" class="font-bold text-primary">Email</label>
                    <input type="text" id="Email" class="w-full p-2 rounded-xl text-color outline-none bg-secondary" />
                </div>
                <div>
                    <label for="Car-Holder" class="font-bold text-primary">Card Holder</label>
                    <input type="text" id="Card-Holder" class="w-full p-2 rounded-xl text-color outline-none bg-secondary" />
                </div>
                <div class="flex space-x-3">
                    <div class="w-full flex flex-col">
                    <label for="Car-Holder" class="font-bold text-primary">Card Number</label>
                    <input type="number" id="Card-Number" class="w-full p-2 rounded-xl text-color outline-none bg-secondary" />
                    </div>
                    <div class="w-1/2 flex flex-col">
                        <label for="Expiration-Date" class="font-bold text-primary">Date Of Expiration</label>
                        <input class="w-full p-2  rounded-xl text-color outline-none bg-secondary" type="text" id="Expiration-Date" />
                    </div>
                    <div class="w-1/2 flex flex-col">
                        <label for="Expiration-Date" class="font-bold text-primary">CVC</label>
                        <input class="w-full p-2 rounded-xl text-color outline-none bg-secondary" type="text" id="CVC" />
                    </div>
                </div>

                <div class="h-1/12 justify-center flex flex-col">
                    <button class=" w-full bg-comp-1 text-color py-2 rounded-md">Checkout</button>
                </div>
            </form>
        </div>
        <div class="md:w-1/3 w-full h-5/6 md:my-auto my-4 md:h-full p-5 flex flex-col bg-primary rounded-xl">
            <div class="h-5/6 flex flex-col overflow-y-scroll">
                <div class="h-full flex flex-col">
                    <div id="cartCourses" class=" flex flex-col space-y-4">
                        <p class="text-sm self-center justify-self-center">Add courses to your cart to see them here...</p>
                    </div>
                </div>
            </div>
            <div class="h-1/6 my-4 space-y-4">
                <div  class="font-bold text-comp-1 text-sm">Total Courses: <span id="totalCourses" class="font-normal text-color">0</span></div>
                <div  class="font-bold text-comp-1 text-sm">SUBTOTAL: <span id="subTotal" class="font-normal text-color">$0.00 MXN</span></div>
                <div  class="font-bold text-comp-1 text-sm">TOTAL: <span id="total" class="font-normal text-color">$0.00 MXN</span></div>
            </div>
        </div>
    </div>
</div>
<script>
    const cartCourses = document.getElementById('cartCourses');
    const totalCourses = document.getElementById('totalCourses');
    const subTotal = document.getElementById('subTotal');
    const total = document.getElementById('total');
    let subTotalAmount = 0;
    let totalAmount = 0;
    let cart = JSON.parse(sessionStorage.getItem('checkoutItems')) || [];
    let categoriesData = {};
    let itemsToCheckout = [];
    const users = {};
    const inputs = [
        document.querySelector('#Email'),
        document.querySelector('#Card-Holder'),
        document.querySelector('#Card-Number'),
        document.querySelector('#Expiration-Date'),
        document.querySelector('#CVC')
    ];

    document.querySelector('#checkout').addEventListener('submit', function(event) {
        event.preventDefault();
        let allFilled = true;

        inputs.forEach(input => {
            if (!input.value) {
                allFilled = false;
            }
        });

        if (!allFilled) {
            swal({
                icon: 'error',
                title: '☠️',
                text: 'Please fill all the fields'
            });
            return;
        }

        const email = document.querySelector('#Email').value;
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailPattern.test(email)) {
            swal({
                icon: 'error',
                title: '☠️',
                text: 'Please enter a valid email address'
            });
            return;
        }

        const cardNumber = document.querySelector('#Card-Number').value;
        const cardNumberPattern = /^[0-9]{16}$/;

        if (!cardNumberPattern.test(cardNumber)) {
            swal({
                icon: 'error',
                title: '☠️',
                text: 'Please enter a valid 16-digit card number'
            });
            return;
        }

        const expirationDate = document.querySelector('#Expiration-Date').value;
        const expirationDatePattern = /^(0[1-9]|1[0-2])\/(0[1-9]|[12][0-9]|3[01])$/;

        if (!expirationDatePattern.test(expirationDate)) {
            swal({
                icon: 'error',
                title: '☠️',
                text: 'Please enter a valid expiration date'
            });
            return;
        }

        const cvc = document.querySelector('#CVC').value;
        const cvcPattern = /^[0-9]{3,4}$/;

        if (!cvcPattern.test(cvc)) {
            swal({
            icon: 'error',
            title: '☠️',
            text: 'Please enter a valid CVC'
            });
            return;
        }

        swal({
            title: "🤑",
            text: "Do you want to proceed with the checkout?",
            icon: "info",
            buttons: true,
            dangerMode: true,
        }).then((willCheckout) => {
            if (willCheckout) {
                result = true;

                itemsToCheckout.forEach(item => {
                    if (item.coursePrice !== undefined) {
                        if(!purchase(item.courseId, item.coursePrice)){
                            result = false;
                        };
                    } else {
                        if(!purchase(item.courseId, item.levelCost, item.levelId)){
                            result = false;
                        };
                    }
                });

                if(result){
                    localStorage.setItem('cart', JSON.stringify([]));
                    sessionStorage.setItem('checkoutItems', JSON.stringify([]));
                    swal({
                        icon: 'success',
                        title: '🎉',
                        text: 'Purchase successful!'
                    }).then(() => {
                        window.location.href = '/home';
                    });
                }
            }
        });

    });

    async function purchase(courseId, coursePrice, levelId = null) {
        const formData = new FormData();
        formData.append('purchaseDate', new Date().toISOString().slice(0, 19).replace('T', ' '));
        formData.append('userId', <?= $_SESSION['user']['userId'] ?>);  
        formData.append('courseId', courseId);
        if (levelId)
            formData.append('levelId', levelId);
        formData.append('paymentMethod', 'Credit Card');
        formData.append('paymentType', (levelId ? 'L' : 'C'));
        formData.append('paymentAmount', coursePrice);

        fetch('/purchase', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                return true;
            } else {
            swal({
                icon: 'error',
                title: '☠️',
                text: data.payload.error.includes('Duplicate entry') ? 'One of the items in the cart is already owned by you' : data.payload.error
            }).then(() => {
                return false;
            });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            swal({
            icon: 'error',
            title: '☠️',
            text: 'An error occurred during the purchase process'
            }).then(() => {
                return true;
            });
        });
    }

    document.addEventListener('DOMContentLoaded', async () => {

        const categoriesResponse = await fetch('/categories');
        categoriesData = await categoriesResponse.json();
        categoriesData = categoriesData.payload.categories;

        const usersResponse = await fetch('/users');
        const usersData = await usersResponse.json();
        usersData.payload.users.forEach(user => {
            users[user.userId] = user;
        });

        async function loadcart() {
            totalCourses.innerText = cart.length;
            subTotalAmount = 0;
            totalAmount = 0;
            subTotal.innerText = `$${subTotalAmount} MXN`;
            total.innerText = `$${totalAmount} MXN`;
            if (cart.length === 0) {
            cartCourses.innerHTML = '<p class="text-sm self-center justify-self-center">Add courses to your cart to see them here...</p>';
            return;
            }
            cartCourses.innerHTML = '';
            for (const item of cart) {
            try {
                const courseId = item.courseId;
                const levelId = item.levelId || null;
                const coursePrice = item.coursePrice;
                const levelPrice = item.levelCost; 

                const coursesResponse = await fetch(`/courses/get?course_id=${courseId}`);
                const coursesData = await coursesResponse.json();

                if (coursesData.status && coursesData.payload.courses.length > 0) {
                const course = coursesData.payload.courses[0];
                
                itemsToCheckout.push(item);
                
                let courseCard = `<p id="course-id" class="text-color flex justify-between">courseName<span>coursePriceMXN</span></p><div class="w-full h-0.5 bg-secondary"></div>`;
                courseCard = courseCard
                .replace('courseName', `${course.courseTitle}`);
                
                if (coursePrice !== undefined) {
                    courseCard = courseCard.replace('coursePrice', `$${parseFloat(coursePrice).toFixed(2)}`); 
                    subTotalAmount += parseFloat(coursePrice);
                } else {
                    courseCard = courseCard.replace('coursePrice', `$${parseFloat(levelPrice).toFixed(2)}`);
                    subTotalAmount += parseFloat(levelPrice);
                }
                cartCourses.innerHTML += courseCard;
                }

                subTotal.innerText = `$${parseFloat(subTotalAmount).toFixed(2)} MXN`;
                totalAmount = (subTotalAmount * 1.15).toFixed(2);
                total.innerText = `$${totalAmount} MXN`;

            } catch (error) {
                console.error('Error fetching course data:', error);
            }
            }
        }

        console.log(itemsToCheckout)

        loadcart();
    });

</script>