<?php
require 'views/components/header.php';
?>

<div class="h-screen w-screen container mx-auto flex flex-col lg:flex-row items-center justify-center">
    <div id="Title-Container" class="lg:hidden mb-12"> 
        <h1 class="text-8xl font-extrabold tracking-wider">FOCUS</h1>
    </div>      
    <div class="bg-primary flex w-5/6 md:w-1/2 place-content-evenly rounded-xl">
        <div id="Form-Container" class="flex flex-col mx-4 2xl:mx-6 my-12">
            <h2 class="text-color text-3xl text-center w-full mb-6 font-bold">Log In</h2>
            <form id="login" class="flex flex-col justify-between h-52 font-semibold mb-4">
                <div>
                    <p class="text-secondary">Username:</p>
                    <input id="user" type="text" class="w-full bg-transparent border-t-transparent border-b-2 outline-none text-color" />
                </div>
                <div>
                    <p class="text-secondary">Password:</p>
                    <input id="password" type="password" class="w-full bg-transparent border-t-transparent border-b-2 outline-none text-color" />
                </div>
                <input type="submit" value="Log In" class="w-1/2 self-center bg-comp-2 text-primary font-semibold rounded-md p-1" />
            </form>
            <div class="text-center text-xs w-full text-comp-1">Don't have an account? <a class="text-comp-2 visited:text-color font-bold" href="/register">Register</a></div>
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
        document.querySelector('#user'),
        document.querySelector('#password'),
    ];

    document.querySelector('#login').addEventListener('submit', function(event) {
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
                text: 'Please fill in all fields!'
            });
            return;
        }

        const username = document.querySelector('#user').value;
        const password = document.querySelector('#password').value;

        fetch('login', {
            method: 'post',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                user: username,
                password: password
            }),
        }).then(response => response.json())
        .then(data => {
            if (data.status) {
                console.log(data.payload.user);
                sessionStorage.setItem('user', data.payload.user);
                window.location.href = '/home';
            } else {
                swal({
                    icon: 'error',
                    title: '☠️',
                    text: data.payload.error
                });
            }
        });

    });
</script>