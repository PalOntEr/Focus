
<div id="LEVEL_NUM" class="Level flex items-center justify-between border-b-2 p-1">
    <div class="flex w-1/2 items-center space-x-2 text-sm">
        <div class="w-1/12 font-bold text-color">
            LEVEL_NUM
        </div>
        <div class="w-5/12">
            <input name="levelName" class="levelName w-full rounded-md p-1 bg-transparent outline-none text-color" placeholder="Level Name" type="text">
        </div>
        <div class="w-1/2">
            <input name="levelDescription" class="levelDescription w-full rounded-md p-1 bg-transparent outline-none text-color" placeholder="Level Description" type="text">
        </div>
    </div>
    <div class="flex items-center justify-end space-x-2 w-1/2">
        <input type="file" name="video" class="video" hidden>
        <a class="videoRef" href="#">
        <svg class="w-[48px] h-[48px] text-color" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M10 3v4a1 1 0 0 1-1 1H5m14-4v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1ZM9 12h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H9a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1Zm5.697 2.395v-.733l1.269-1.219v2.984l-1.268-1.032Z"/>
        </svg>
        </a>
        <p class="videoNameDisplay">Video not selected</p>

        <input type="file" name="file" class="file" hidden>
        <a class="fileRef" href="#">
        <svg class="w-[48px] h-[48px] text-color" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9V4a1 1 0 0 0-1-1H8.914a1 1 0 0 0-.707.293L4.293 7.207A1 1 0 0 0 4 7.914V20a1 1 0 0 0 1 1h4M9 3v4a1 1 0 0 1-1 1H4m11 6v4m-2-2h4m3 0a5 5 0 1 1-10 0 5 5 0 0 1 10 0Z"/>
        </svg>
        </a>
        <p class="fileNameDisplay">File not selected</p>
    <div>
            <label name="individualCost" class="hidden flex items-center space-x-1">
                <label>Cost:</label>
                <input type="number" name="individualCost" class="individualCost w-20 rounded-md p-1 bg-transparent outline-none text-color" value="">
            </label>
        </div>
        <div>
            <label class="DeleteLevel flex items-center space-x-1">
                <a href="#">
                <svg class="w-[48px] h-[48px] text-color" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                </svg>
                </a>
            </label>
        </div>
    </div>
</div>
