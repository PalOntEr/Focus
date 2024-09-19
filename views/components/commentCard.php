<div class="flex flex-col w-full sm:w-72 h-fit sm:h-48 max-h-[367px] bg-primary mb-2 sm:m-2 p-2 justify-center items-center rounded-2xl" style="width=500px;">
    <div class="flex w-full h-1/4 p-1 items-center justify-between font-semibold">
            <div class="flex items-center w-full text-color font-semibold">
                <img class="w-6 h-6 mr-1" src="https://www.iconpacks.net/icons/2/free-user-icon-3296-thumb.png" alt="user">    
                <?= $commentUser ?>
            </div>
            <div class="text-comp-2"><?= $stars ?>/5⭐</div>
    </div>
    <div class="flex w-full h-3/4 px-3 items-center justify-between font-semibold overflow-y-scroll">
        <div class="text-color"><?= $comment ?></div>
    </div>
</div>