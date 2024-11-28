<div class="flex flex-row w-full px-4 min-h-64 h-fit bg-primary mb-5 sm:mb-2 items-center rounded-2xl shadow-lg">
    <div class="flex flex-col w-2/3 justify-center h-auto py-3 bg-transparent rounded-2xl">
        <img class="w-auto max-h-44 rounded-2xl" src="https://pbs.twimg.com/media/GVq8fLsaoAEnzsl?format=jpg&name=large" alt="Course">
        <button onclick="location.href='/course'" class="text-center bg-comp-1 mt-2 text-color w-full rounded p-px hover:opacity-80 font-bold">
            SEE COURSE
        </button>
    </div>
    <div class="w-full h-full justify-between py-5 flex flex-col ml-2 my-4">
        <div class="w-full text-comp-2 font-semibold flex flex-col justify-between">
            <div class="flex justify-between">
                <div>PHP Course - 4.3/5⭐</div>
                <div>Computer Science</div>
            </div>
            <div class="text-secondary w-full flex place-content-between">
                <p><a href="/user">Instructor</a></p>
            </div>
        </div>
        <div class="flex w-full text-color text-justify text-sm h-full">
            Descripcion
        </div>
        <div class="w-full flex flex-row items-center justify-between">
            <select class="bg-comp-1 text-color rounded p-1">
                <option value="0">All levels</option>
                <option value="1">Level 1</option>
                <option value="2">Level 2</option>
                <option value="3">Level 3</option>
            </select>
            <button onclick="removeFromCart(0)" class="">DELETE</button>
        </div>
    </div>
</div>