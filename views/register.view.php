<?php
require 'views/components/header.php';
?>

<div class="h-screen w-screen container mx-auto flex flex-col lg:flex-row items-center justify-center">
    <div id="Title-Container" class="lg:hidden mb-12">
        <h1 class="text-8xl font-extrabold tracking-wider text-secondary">FOCUS</h1>
    </div>
    <div class="bg-secondary flex w-5/6 md:w-3/4 justify-center md:place-content-evenly rounded-xl">
        <div id="Form-Container" class="items-center flex flex-col mx-4 2xl:mx-6 my-12">
            <h2 class="text-primary text-3xl text-center w-full mb-6 font-bold">Create Account</h2>
            <form class="container flex flex-col md:justify-between h-full font-semibold mb-4" action="/login" method="GET">
                <div class="flex flex-col md:flex-row w-full items-center space-y-6 md:space-y-0 md:space-x-6 mb-6">
                    <div class="flex flex-col w-5/6 space-y-4 md:w-1/2">
                        <div>
                            <label for="User" class="text-comp-1">Username:</label>
                            <input id="User" type="text" class="w-full bg-transparent border-t-transparent border-b-2 outline-none text-primary" />
                        </div>
                        <div>
                            <label for="Email" class="text-comp-1">Email:</label>
                            <input id="Email" type="text" class="w-full bg-transparent border-t-transparent border-b-2 outline-none text-primary" />
                        </div>
                        <div>
                            <label for="password" class="text-comp-1">Password:</label>
                            <input id="password" type="password" class="w-full bg-transparent border-t-transparent border-b-2 outline-none text-primary" />
                        </div>
                        <div>
                            <label id="ConfirmPassword" class="text-comp-1">Confirm Password:</label>
                            <input id="ConfirmPassword" type="password" class="w-full bg-transparent border-t-transparent border-b-2 outline-none text-primary" />
                        </div>
                        <div>
                            <div class="">
                                <label for="Role" class="text-comp-1">Role</label>
                            </div>
                            <select id="Role" class="rounded-md border-0 bg-comp-1 text-secondary font-semibold py-0 pl-2 pr-7 h-[26px] outline-none w-full sm:text-sm">
                                <option>Student</option>
                                <option>Instructor</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-col space-y-4 w-5/6 md:w-1/2">
                        <label for="Photo" class="flex flex-col items-center justify-center w-2/3 h-3/5 rounded-lg cursor-pointer bg-comp-1 mt-2 self-center">
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
                                <label for="Gender" class="text-comp-1">Gender</label>
                            </div>
                            <select id="Gender" class="rounded-md border-0 bg-comp-1 text-secondary font-semibold py-0 pl-2 pr-7 h-[26px] outline-none w-full sm:text-sm">
                                <option>Male</option>
                                <option>Female</option>
                                <option>Prefer not to say</option>
                            </select>
                        </div>
                        <div>
                            <label for="Birthdate" class="text-comp-1">Birthdate:</label>
                            <input id="Birthdate" type="date" class="w-full bg-transparent border-t-transparent border-b-2 outline-none text-primary" />
                        </div>
                    </div>
                </div>
                <input type="submit" value="Register" class="w-1/6 self-center bg-comp-1 text-secondary rounded-md p-1" />
            </form>
            <div class="text-center text-xs w-full text-comp-1">Already have an account? <a class="text-primary visited:text-color font-bold" href="/login">Log In</a></div>
        </div>

        <div class="bg-primary w-0.5 my-12 hidden lg:flex"></div>

        <div class="self-center mx-6 my-12 hidden lg:flex">
            <div id="Card-Title-Container" class="text-center">
                <h1 class="text-4xl xl:text-6xl 2xl:text-8xl font-extrabold tracking-wider text-primary">FOCUS</h1>
            </div>
        </div>
    </div>
</div>

</html>