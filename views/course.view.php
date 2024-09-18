<?php
    require 'views/components/header.php';
    require 'views/components/navbar.php';
?>

<div class="container sm:mx-auto flex flex-col items-center self-center sm:items-start sm:flex-row w-full h-fit sm:h-1/3 xl:h-fit space-y-2 sm:space-y-0 sm:space-x-4">
    <div class="flex justify-center bg-secondary w-5/6 sm:w-1/4 h-1/4 sm:h-full p-2 rounded-xl">
        <?php require 'views/components/courseInfo.php'; ?>
    </div>
    <div class="flex bg-secondary w-5/6 sm:w-3/4 h-3/4 sm:h-full px-5 py-2 text-justify rounded-xl overflow-y-scroll">
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
<div class="container mx-auto flex flex-col sm:flex-row self-center items-center justify-center w-5/6 sm:w-full h-fit my-2 flex-wrap">
    <?php
    for( $i = 1; $i <= 100; $i++ ) {
        $level = $i;
        require 'views/components/levelCard.php';
    }
    ?>
</div>