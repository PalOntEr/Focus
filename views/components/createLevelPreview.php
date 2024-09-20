<div class="flex items-center justify-between border-b-2 p-1">
    <div class="flex w-1/2 items-center space-x-2 text-sm">
        <div class="w-1/12 font-bold">
            <?= $levelNum ?>
        </div>
        <div class="w-5/12">
            <input name="levelName" class="w-full rounded-md p-1 bg-comp-2 text-comp-1" placeholder="Level Name" type="text">
        </div>
        <div class="w-1/2">
            <input name="levelDescription" class="w-full rounded-md p-1 bg-comp-2 text-comp-1" placeholder="Level Description" type="text">
        </div>
    </div>
    <div class="flex items-center justify-end space-x-2 w-1/2">
        <a href="#" download>
            <img class="h-5" src="https://cdn-icons-png.flaticon.com/512/12334/12334190.png" alt="">
        </a>
        <a href="#" download>
            <img class="h-5" src="https://cdn-icons-png.flaticon.com/512/84/84539.png" alt="">
        </a>
        <div>
            <label class="flex items-center space-x-1">
                <input type="checkbox" class="">
                <span>Cost $500</span>
            </label>
        </div>
        <div>
            <label class="flex items-center space-x-1">
                <a href="#">
                    <img class="h-5" src="https://cdn-icons-png.flaticon.com/512/1017/1017530.png" alt="Remove">
                </a>
            </label>
        </div>
    </div>
</div>