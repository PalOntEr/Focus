<?php
require 'views/components/header.php';
require 'views/components/navbar.php';

$usertype = $_SESSION['user']['role'] ?? 'G';
$MyProfile = $_GET['myProfile'] ?? 'false';
?>
<div id="User-container" class="container mx-auto">
    <div class="flex flex-row place-content-center lg:place-content-between">
        <div class="flex">
            <a href="/profile" class="self-center"><img class="md:flex md:h-48 md:w-48 hidden" src="https://www.iconpacks.net/icons/2/free-user-icon-3296-thumb.png" alt=""></a>
            <div class="self-center">
                <h2 id="User-Role" class="text-4xl text-center md:text-left text-secondary font-semibold">User Role</h2>
                <h1 id="User" class="text-8xl text-primary font-extrabold">User</h1>
                <p id="User-Info" class="text-secondary">Registered in November 2024 Age: 24 years</p>
            </div>
        </div>
        <div id="User-Settings-Container" class="hidden lg:flex md:flex-row place-self-end w-auto  mb-2">
            <?php if ($MyProfile === 'true'): ?>
                <?php if ($usertype === 'S'): ?>
                    <input type="button" class="mx-2 py-1 px-2 text-sm text-color bg-secondary rounded-md" onclick="location.href='/kardex';" value="Kardex"></input>
                <?php endif; ?>
                <?php if ($usertype === 'I'): ?>
                    <input type="button" class="mx-2 py-1 px-2 text-sm text-color bg-secondary rounded-md" onclick="location.href='/sales';" value="Sales"></input>
                <?php endif; ?>
                <?php if ($usertype === 'A'): ?>
                    <input type="button" class="ml-2 py-1 px-2 text-sm text-color bg-secondary rounded-md" onclick="location.href='/reporte';" value="Report"></input>
                <?php endif; ?>
                <input type="button" class="mx-2 py-1 px-2 text-sm text-color bg-secondary rounded-md" onclick="location.href='/register?update=true';" value="Edit Profile"></input>
            <?php else: ?>
                <?php if($usertype === 'G'): ?>
                <input type="button" class="mx-2 py-1 px-2 text-sm text-color bg-secondary rounded-md" onclick="location.href='/login';" value="Chat"></input>
                <?php else: ?>
                <input type="button" class="mx-2 py-1 px-2 text-sm text-color bg-secondary rounded-md" onclick="location.href='/chats';" value="Chat"></input>
                <?php endif; ?>  
            <?php endif; ?>
        </div>
    </div>
    <div class="w-full h-1 bg-secondary"></div>
    
    <?php if(($MyProfile === 'true' && $usertype === 'instructor') || ($MyProfile != 'true')): ?>
    <div class="w-full text-4xl text-secondary font-bold my-5">
        <?php echo $MyProfile === 'true' ? 'Your' : 'User' ?> Courses
    </div>
    <div id="Your-Courses-container" class="w-full h-[500px] flex flex-col items-center sm:flex-row overflow-y-hidden overflow-x-scroll">
        <?php
        require 'views/components/courseCard.php';
        require 'views/components/courseCard.php';
        require 'views/components/courseCard.php';
        ?>
    </div>

    <div class="w-full h-1 bg-secondary"></div>
    <?php endif; ?>
    
    <div class="w-full text-4xl text-secondary font-bold my-5">
        Recommended by  <?php echo $MyProfile === 'true' ? 'You' : 'User' ?>
    </div>
    <div id="Courses-container" class="w-full h-[500px] flex flex-col items-center sm:flex-row overflow-y-hidden overflow-x-scroll">
        <?php
        require 'views/components/courseCard.php';
        require 'views/components/courseCard.php';
        require 'views/components/courseCard.php';
        ?>
    </div>
</div>