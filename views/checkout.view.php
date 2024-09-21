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
                    <div class=" flex flex-col space-y-4">
                        <?php
                        $courses = [
                            "PHP Course" => 850.00,
                            "JavaScript Course" => 750.00,
                            "HTML & CSS Course" => 650.00,
                            "React Course" => 950.00
                        ];

                        foreach ($courses as $course => $price) {
                            echo '<p class="text-color flex justify-between">' . $course . ' <span>$' . number_format($price, 2) . 'MXN</span></p>';
                            echo '<div class="w-full h-0.5 bg-secondary"></div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="h-1/6 my-4 space-y-4">
                <div class="font-bold text-comp-1 text-sm">Total Courses: <span class="font-normal text-color">4</span></div>
                <div class="font-bold text-comp-1 text-sm">SUBTOTAL: <span class="font-normal text-color">$524.00 MXN</span></div>
                <div class="font-bold text-comp-1 text-sm">TOTAL: <span class="font-normal text-color">$480.00 MXN</span></div>
            </div>
        </div>
    </div>
</div>
<script>
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
            icon: 'success',
            title: '🎉',
            text: 'Checkout successful!'
        }).then(() => {
            window.location.href = '/home';
        });

    });
</script>