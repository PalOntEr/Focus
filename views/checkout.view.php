<?php
require 'views/components/header.php';
?>
<div class="w-screen h-screen overflow-x-hidden">
    <?php
    require 'views/components/navbar.php';
    ?>
    <div class="container mx-auto flex h-auto">
        <div class="w-full mx-4">
            <h1 class="text-center text-8xl text-primary font-extrabold tracking-wide">FOC<span class="text-secondary">US</span></h1>
            <h2 class="text-center text-4xl font-bold text-primary">Check<span class="text-secondary">out</span></h2>
            <div class="w-full bg-primary h-0.5 my-6"></div>
            <form class="flex flex-col space-y-8 text-md">
                <div>
                    <label for="Email">Email</label>
                    <input type="text" id="Email" placeholder="Email" class="w-full" />
                </div>
                <div>
                    <label for="Car-Holder">Card Holder</label>
                    <input type="text" id="Card-Holder" placeholder="Card Holder" class="w-full" />
                </div>
                <div class="flex">
                    <label for="Car-Holder">Card Holder</label>
                    <input type="text" id="Card-Number" placeholder="Card Number" class="w-full" />
                    <div class="w-1/2 flex">
                        <label for="Expiration-Date">Date Of Expiration</label>
                        <input class="w-full" type="text" id="Expiration-Date" placeholder="MM/YY" />
                    </div>
                    <div class="w-1/2 flex">
                        <label for="Expiration-Date">CVC</label>
                        <input class="w-full" type="text" id="CVC" placeholder="CVC" />
                    </div>
                </div>
            </form>
        </div>
        <div class="w-1/3 h-full">
            <div class="h-full flex flex-col bg-primary rounded-xl p-4">
                <div class="h-auto flex flex-col space-y-4">
                    <p class="text-color flex justify-between">PHP Course <span>$850.00MXN</span></p>
                    <div class="w-full h-0.5 bg-secondary"></div>
                    <p class="text-color flex justify-between">PHP Course <span>$850.00MXN</span></p>
                    <div class="w-full h-0.5 bg-secondary"></div>
                    <p class="text-color flex justify-between">PHP Course <span>$850.00MXN</span></p>
                    <div class="w-full h-0.5 bg-secondary"></div>
                    <p class="text-color flex justify-between">PHP Course <span>$850.00MXN</span></p>
                    <div class="w-full h-0.5 bg-secondary"></div>
                    <p class="text-color flex justify-between">PHP Course <span>$850.00MXN</span></p>
                    <div class="w-full h-0.5 bg-secondary"></div>
                    <p class="text-color flex justify-between">PHP Course <span>$850.00MXN</span></p>
                    <div class="w-full h-0.5 bg-secondary"></div>
                    <p class="text-color flex justify-between">PHP Course <span>$850.00MXN</span></p>
                    <div class="w-full h-0.5 bg-secondary"></div>
                    <p class="text-color flex justify-between">PHP Course <span>$850.00MXN</span></p>
                    <div class="w-full h-0.5 bg-secondary"></div>
                    <p class="text-color flex justify-between">PHP Course <span>$850.00MXN</span></p>
                    <div class="w-full h-0.5 bg-secondary"></div>
                </div>
                <div class="h-auto my-4">
                    <div class="font-bold text-comp-1 text-sm">Total Courses: <span class="font-normal text-color">4</span></div>
                    <div class="font-bold text-comp-1 text-sm my-3">SUBTOTAL: <span class="font-normal text-color">$524.00 MXN</span></div>
                    <div class="font-bold text-comp-1 text-sm my-3">TOTAL: <span class="font-normal text-color">$480.00 MXN</span></div>
                </div>
                <div class="h-1/12 justify-center flex flex-col">
                    <button class=" w-full bg-comp-1 text-color py-1 rounded-md">Checkout</button>
                </div>
            </div>
        </div>

    </div>