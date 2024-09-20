<?php

    require 'views/components/header.php';

    $isUpdating = isset($_GET['update']) && $_GET['update'] === 'true';

    if ($isUpdating) {
        require 'views/components/navbar.php';
    }

?>

<div class="h-screen w-screen container mx-auto flex flex-col lg:flex-row items-center justify-center">
    <div id="Title-Container" class="lg:hidden mb-12">
    <h1 class="text-4xl xl:text-6xl 2xl:text-8xl font-extrabold tracking-wider text-color"><span class="text-secondary">FOC</span>US</h1>
</div>
    <div class="bg-primary flex w-5/6 md:w-3/4 justify-center md:place-content-evenly rounded-xl">
        <div id="Form-Container" class="items-center flex flex-col mx-4 2xl:mx-6 my-12">
            <?php
                if ($isUpdating) {
                    echo '<h2 class="text-color text-3xl text-center w-full mb-6 font-bold">Update Account Info</h2>';
                } else {
                    echo '<h2 class="text-color text-3xl text-center w-full mb-6 font-bold">Create Account</h2>';
                }
            ?>
            <form id="register" class="container flex flex-col md:justify-between h-full font-semibold mb-4" action="<?= $isUpdating ? '/user' : '/login'; ?>" method="GET">
                <div class="flex flex-col md:flex-row w-full items-center space-y-6 md:space-y-0 md:space-x-6 mb-6">
                    <div class="flex flex-col w-5/6 space-y-4 md:w-1/2">
                        <div>
                            <label for="User" class="text-secondary">Username:</label>
                            <input id="User" type="text" class="w-full bg-transparent border-t-transparent border-b-2 outline-none text-color" />
                        </div>
                        <div>
                            <label for="Email" class="text-secondary">Email:</label>
                            <input id="Email" type="text" class="w-full bg-transparent border-t-transparent border-b-2 outline-none text-color" />
                        </div>
                        <div>
                            <label for="password" class="text-secondary">Password:</label>
                            <input id="password" type="password" class="w-full bg-transparent border-t-transparent border-b-2 outline-none text-color" />
                        </div>
                        <div>
                            <label for="ConfirmPassword" class="text-secondary">Confirm Password:</label>
                            <input id="ConfirmPassword" type="password" class="w-full bg-transparent border-t-transparent border-b-2 outline-none text-color" />
                        </div>
                        <div>
                            <div class="">
                                <label for="Role" class="text-secondary">Role</label>
                            </div>
                            <select id="Role" class="rounded-md border-0 bg-comp-2 text-primary font-semibold py-0 pl-2 pr-7 h-[26px] outline-none w-full sm:text-sm">
                                <option>Student</option>
                                <option>Instructor</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-col space-y-4 w-5/6 md:w-1/2">
                        <label for="Photo" class="flex flex-col items-center justify-center w-2/3 h-3/5 rounded-lg cursor-pointer bg-comp-2 mt-2 self-center">
                            <div class="flex flex-col items-center justify-center p-2">
                                <svg class="w-8 h-8 mb-4 text-secondary dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class="mb-2 text-center text-sm text-secondary dark:text-gray-400"><span class="font-semibold">Profile Picture </span></p>
                                <p class="mb-2 text-center text-sm text-secondary dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-center text-secondary dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                            </div>
                            <input id="Photo" type="file" class="hidden" />
                        </label>
                        <div>
                            <div class="">
                                <label for="Gender" class="text-comp-2">Gender</label>
                            </div>
                            <select id="Gender" class="rounded-md border-0 bg-comp-2 text-primary font-semibold py-0 pl-2 pr-7 h-[26px] outline-none w-full sm:text-sm">
                                <option>Male</option>
                                <option>Female</option>
                                <option>Prefer not to say</option>
                            </select>
                        </div>
                        <div>
                            <label for="Birthdate" class="text-comp-2">Birthdate:</label>
                            <input id="Birthdate" type="date" class="w-full bg-transparent border-t-transparent border-b-2 outline-none text-color" />
                        </div>
                    </div>
                </div>
                <input type="submit" value="<?= $isUpdating ? 'Update' : 'Register'; ?>" class="w-1/6 self-center bg-comp-2 text-primary font-semibold rounded-md p-1" />
            </form>
            <?php
                if (!$isUpdating) {
                    echo '<div class="text-center text-xs w-full text-comp-1">Already have an account? <a class="text-comp-2 visited:text-color font-bold" href="/login">Log In</a></div>';
                }
            ?>
        </div>

        <div class="bg-color w-0.5 my-12 hidden lg:flex"></div>

        <div class="self-center mx-6 my-12 hidden lg:flex">
            <div id="Card-Title-Container" class="text-center">
                <h1 class="text-4xl xl:text-6xl 2xl:text-8xl font-extrabold tracking-wider text-color"><span class="text-secondary">FOC</span>US</h1>
            </div>
        </div>
    </div>
</div>

<script>
    const inputs = [
        document.querySelector('#User'),
        document.querySelector('#Email'),
        document.querySelector('#password'),
        document.querySelector('#ConfirmPassword'),
        document.querySelector('#Role'),
        document.querySelector('#Photo'),
        document.querySelector('#Gender'),
        document.querySelector('#Birthdate')
    ];

    document.querySelector('#register').addEventListener('submit', function(event) {
        let allFilled = true;

        inputs.forEach(input => {
            if (!input.value) {
                allFilled = false;
            }
        });

        if (!allFilled) {
            event.preventDefault();
            swal({
                icon: 'error',
                title: '☠️',
                text: 'Please fill in all fields!'
            });
            return;
        }

        const password = inputs.find(input => input.id === 'password').value;
        const confirmPassword = inputs.find(input => input.id === 'ConfirmPassword').value;
        const specialChars = /[¡”#$%&/=’?¡¿:;,.\-_+*{[\]}]/;

        if (password.length < 8 || !specialChars.test(password)) {
            event.preventDefault();
            swal({
                icon: 'error',
                title: '☠️',
                text: 'Password must be at least 8 characters long and contain at least one special character\n (¡”#$%&/=’?¡¿:;,.-_+*{][})'
            });
            return;
        }

        if (password !== confirmPassword) {
            event.preventDefault();
            swal({
                icon: 'error',
                title: '☠️',
                text: 'Passwords do not match!'
            });
            return;
        }

        swal({
            icon: 'success',
            title: '🎉',
            text: 'Account <?php 
            if($isUpdating){
                echo 'updated';
            }else{
                echo 'created';
            }
            ?> successfully!'
        });

    });

    document.querySelector('#Photo').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('w-full', 'h-full', 'object-cover', 'rounded-lg');
                const photoDiv = document.querySelector('label[for="Photo"] .flex');
                photoDiv.innerHTML = '';
                photoDiv.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });

</script>