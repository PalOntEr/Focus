<?php
    require 'views/components/header.php';
    require 'views/components/navbar.php';
?>
<div class="container mx-auto flex h-[500px] w-screen">
    <div class="h-2/3 w-1/3 bg-primary rounded-xl mx-5 p-5">
        <div class="flex justify-between items-center mb-5">
            <h1 class="text-2xl font-bold">Chats</h1>
            <button class="px-2 py-1 bg-secondary text-white rounded">New Chat</button>
        </div>
        <div class="flex flex-col space-y-2">
            <div class="flex items-center space-x-2 w-full">
                <img class="h-10 w-10 rounded-full" src="https://www.iconpacks.net/icons/2/free-user-icon-3296-thumb.png" alt="">
                <div class="w-full">
                    <h2 class="text-lg font-bold">Dobeto</h2>
                    <div class="flex justify-between w-full">
                        <p class="text-sm">Hello, how are you?</p>
                        <p class="text-sm">8:30pm</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>