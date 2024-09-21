<div class="flex items-center space-x-2 w-full bg-secondary m-2 p-1 rounded-md">
    <div class="w-full">
        <h2 class="text-lg text-color font-bold">Level <?= $level ?></h2>
        <div class="w-full">
            <p class="text-sm text-color font-semibold">Intro</p>
        </div>
    </div>
    <?php 
        if($levelComplete){
            echo '<img class="h-10 w-10 rounded-full" src="https://cdn-icons-png.flaticon.com/512/60/60778.png" alt="">';
        }else{
            echo '<img class="h-10 w-10 rounded-full" src="https://cdn-icons-png.flaticon.com/512/71/71397.png" alt="">';
        }
    ?>
</div>