<div id="LEVEL_ID" class="flex flex-col w-full sm:w-48 h-fit sm:h-48 max-h-[367px] bg-primary mb-2 sm:m-2 p-2 justify-center items-center rounded-2xl" style="width=500px;">
    <div class="flex justify-center w-1/1 h-1/2 mb-1 bg-color rounded-2xl">
        <img class="CourseImage rounded-2xl" src="https://static.wikia.nocookie.net/ultra-custom-night/images/f/f6/Purple_Freddy.png" alt="Level <?= $level ?>">
    </div>
    <div class="flex w-full h-1/6 p-1 items-center justify-between font-semibold">
            <div class="w-1/2 text-color font-semibold">
                Level LEVEL_NUM
            </div>
            <div class="LevelName w-1/2 text-comp-2 text-sm">Intro</div>
    </div>
    <div class="flex w-full h-1/6 p-1 items-center justify-center font-semibold">
        <button onclick="location.href='/levels?level=LEVEL_ID&course=COURSE_ID'" class="Play w-full text-center bg-comp-1 text-color rounded p-px hover:opacity-80 font-bold">
            PLAY
        </button>
    </div>
    <p class="Purchased h-1/6 text-xs">Level not purchased.</p>
</div>