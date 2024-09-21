<?php
    require 'views/components/header.php';
?>
<div class="w-screen h-screen overflow-x-hidden">
<?php
    require 'views/components/navbar.php';
?>
<div class="container mx-auto flex flex-col sm:flex-row h-full w-screen mt-4">
    <div class="hidden sm:flex flex-col h-5/6 w-1/3 bg-primary rounded-xl mx-5 p-5">
        <div class="flex justify-between items-center mb-5">
            <h1 class="text-2xl text-color font-extrabold">Chats</h1>
        </div>
        <div class="flex flex-col space-y-2 overflow-y-scroll h-full rounded-xl">
            <?php
                require 'views/components/chatPreview.php';
                require 'views/components/chatPreview.php';
                require 'views/components/chatPreview.php';
                require 'views/components/chatPreview.php';
                require 'views/components/chatPreview.php';
                require 'views/components/chatPreview.php';
                require 'views/components/chatPreview.php';
                require 'views/components/chatPreview.php';
                require 'views/components/chatPreview.php';
                require 'views/components/chatPreview.php';
                require 'views/components/chatPreview.php';
                require 'views/components/chatPreview.php';
                require 'views/components/chatPreview.php';
                require 'views/components/chatPreview.php';
                require 'views/components/chatPreview.php';
            ?>
        </div>
    </div>
    <div class="flex flex-col h-5/6 w-[90%] sm:w-2/3 bg-primary rounded-xl mb-5 sm:mb-0 mx-5 p-5">            
        <h1 class="flex text-2xl font-bold space-x-2 mb-5 items-center">
            <img class="h-10 w-10 rounded-full" src="https://www.iconpacks.net/icons/2/free-user-icon-3296-thumb.png" alt="">
            <p class="text-color ">Dobeto</p>
        </h1>
        <div class="flex flex-col space-y-2 overflow-y-scroll h-full p-2 rounded-xl">
            <?php
                require 'views/components/incomingMessage.php';
                require 'views/components/outgoingMessage.php';
                require 'views/components/incomingMessage.php';
                require 'views/components/outgoingMessage.php';
                require 'views/components/incomingMessage.php';
                require 'views/components/outgoingMessage.php';
                require 'views/components/incomingMessage.php';
                require 'views/components/outgoingMessage.php';
            ?>
        </div>
        <div class="flex flex-col justify-end bg-comp-2 p-2 rounded-xl mt-3 items-center">
            <div class="flex justify-between w-full space-x-2">
            <input type="text" class="w-full px-2 py-1 rounded-md" placeholder="Type a message...">
            <button class="px-2 py-1 bg-secondary text-white rounded-md">Send</button>
            </div>
        </div>
    </div>
    <div class="flex sm:hidden flex-col h-5/6 w-[90%] bg-primary rounded-xl mx-5 p-5">
        <div class="flex justify-between items-center mb-5">
            <h1 class="text-2xl font-bold">Chats</h1>
            <button class="hidden md:block px-2 py-1 bg-secondary text-white rounded">New Chat</button>
            <button class="block md:hidden px-2 py-1 bg-secondary text-white rounded">➕</button>
        </div>
        <div class="flex flex-col space-y-2 overflow-y-scroll h-full rounded-xl">
            <?php
                require 'views/components/chatPreview.php';
                require 'views/components/chatPreview.php';
                require 'views/components/chatPreview.php';
                require 'views/components/chatPreview.php';
                require 'views/components/chatPreview.php';
                require 'views/components/chatPreview.php';
                require 'views/components/chatPreview.php';
                require 'views/components/chatPreview.php';
                require 'views/components/chatPreview.php';
                require 'views/components/chatPreview.php';
                require 'views/components/chatPreview.php';
                require 'views/components/chatPreview.php';
                require 'views/components/chatPreview.php';
                require 'views/components/chatPreview.php';
                require 'views/components/chatPreview.php';
            ?>
        </div>
    </div>
</div>
</div>