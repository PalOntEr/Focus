<?php
require 'views/components/header.php';
require 'views/components/navbar.php';
?>

<div class="flex flex-col container sm:mx-auto overflow-x-hidden items-center">
    <div class="h-1/3 flex flex-col sm:flex-row w-5/6 sm:w-full sm:space-x-2 space-y-2 sm:space-y-0 justify-center mx-2 sm:mx-0 items-center sm:items-start">
        <?php require 'views/components/courseInfo.php'; ?>
        <div class="flex bg-primary w-5/6 sm:w-2/3 h-3/5 sm:h-full px-5 py-2 text-justify text-color rounded-xl overflow-y-scroll">
            In this course, you will learn the fundamentals of PHP programming, including syntax, control structures, functions, and object-oriented programming. You will also explore advanced topics such as database interactions, session management, and security practices. By the end of the course, you will be able to build dynamic and interactive web applications using PHP.

            The course is designed to provide hands-on experience through practical exercises and real-world projects. You will start with basic PHP scripts and gradually move on to more complex applications. Topics covered include:

            - PHP Syntax and Variables<br>
            - Control Structures (if, else, switch, loops)<br>
            - Functions and Scope<br>
            - Arrays and Superglobals<br>
            - Form Handling and Validation<br>
            - File Handling<br>
            - Introduction to MySQL and Database Operations<br>
            - Session and Cookie Management<br>
            - Error Handling and Debugging<br>
            - Security Best Practices<br>
            - Introduction to PHP Frameworks<br>

            Whether you are a beginner looking to start your programming journey or an experienced developer wanting to enhance your skills, this course will provide you with the knowledge and tools needed to succeed in PHP development.
        </div>
    </div>
    <div class="h-1/3 flex flex-col items-center sm:items-start mx-4 sm:mx-0">
        <h1 class="text-4xl font-bold text-primary">LEVELS</h1>
        <div class="h-0.5 bg-comp-1 w-full"></div>
        <div class="flex flex-row items-center justify-center h-96 w-5/6 sm:w-full my-2 overflow-y-scroll sm:overflow-y-auto flex-wrap">
            <?php
            for ($i = 1; $i <= 28; $i++) {
                $comment = "lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.";
                $level = $i;
                $stars = rand(1, 5);
                $commentUser = "Dobeto";
                require 'views/components/levelCard.php';
            }
            ?>
        </div>
    </div>
    <div class="h-1/3 flex flex-col items-center sm:items-start mx-4 sm:mx-0">
        <h1 class="text-4xl font-bold text-primary">REVIEWS</h1>
        <div class="h-0.5 bg-comp-1 w-full"></div>
        <div class="container mx-auto flex flex-row items-center justify-center h-96 overflow-y-scroll sm:overflow-y-auto w-5/6 sm:w-full my-2 flex-wrap">
            <?php
            for ($i = 1; $i <= 5; $i++) {
                for ($j = 1; $j <= 5; $j++) {
                    $comment = "lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.";
                    $stars = rand(1, 5);
                    $commentUser = "Dobeto";
                    require 'views/components/commentCard.php';
                }
            }
            ?>
        </div>
    </div>