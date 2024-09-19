<?php
    require 'views/components/header.php';
    require 'views/components/navbar.php';
?>
<div class="container mx-auto space-y-5">
    <div class="text-center">
        <h2 class="text-color text-4xl font-bold">Create</h2>
        <h1 class="text-secondary text-5xl font-bold">Course</h1>
    </div>
    <div class="flex flex-col sm:flex-row mx-10 items-center sm:items-stretch space-y-4 sm:space-y-0 sm:space-x-4 text-color font-semibold">
        <div class="w-5/6 sm:w-1/2 space-y-2">
            <div>
                <div>
                    Title
                </div>
                <input class="rounded-md p-1 bg-comp-2 text-comp-1" type="text">
            </div>
            <div>
                <div>
                    Description
                </div>
                <textarea class="w-full rounded-md p-1 bg-comp-2 text-comp-1 max-h-36"></textarea>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    Category
                </div>
                <select class="w-full ml-4 rounded-md p-1 bg-comp-2 text-comp-1">
                    <option value="math">Math</option>
                    <option value="science">Science</option>
                    <option value="history">History</option>
                    <option value="literature">Literature</option>
                </select>
            </div>
        </div>        
        <label for="Photo" class="flex w-5/6 sm:w-1/2 rounded-md bg-comp-2 text-comp-1 items-center justify-center">
            <div class="flex flex-col items-center justify-center p-2">                
                <img class="h-20" src="https://cdn-icons-png.flaticon.com/512/864/864721.png" alt="">
                <p>Upload course photo</p>
            </div>
            <input id="Photo" type="file" class="hidden" />
        </label>
    </div>
    <div class="mx-10 overflow-y-scroll">
        <div class="flex justify-between items-center text-secondary">
            <h3 class="text-3xl font-bold">Levels</h3>
            <a class="text-secondary" href="#">Add level</a>
        </div>
        <div class="bg-comp-1 text-secondary space-y-2 rounded-md p-2">
            <?php                
                for( $i = 1; $i <= 5; $i++ ) {
                    $levelNum = $i;
                    require 'views/components/createLevelPreview.php';
                }
            ?>
        </div>
    </div>
    <div class="w-full">        
        <h3 class="mx-10 text-3xl font-bold text-secondary mb-2">Payment Method</h3>
        <div class="flex justify-evenly mx-10 text-color">
            <label class="flex items-center">
                <input type="radio" name="payment_method" value="one_time" class="mr-2">
                One time
                <input type="text" name="one_time_amount" placeholder="Enter amount" class="ml-2 p-1 rounded-md bg-comp-2 text-comp-1">
            </label>
            <label class="flex items-center">
                <input type="radio" name="payment_method" value="level_based" class="mr-2">
                Level Based
            </label>
        </div>
    </div>
    <div class="flex w-full justify-center">
        <button class="w-1/2 m-2 bg-secondary text-primary font-bold py-2 rounded-md">Create Course</button>
    </div>
</div>