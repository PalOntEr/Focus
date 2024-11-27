<style>
    <?php require 'views/css/navbar.css'; ?>
</style>
<?php $usertype = $_SESSION['user']['role'] ?? 'G';
?>
<nav class="bg-primary p-4 mb-2 sticky top-0">
    <div class="container mx-auto flex justify-between items-center space-x-2">
        <a href="/home" class="text-3xl font-bold ease-in duration-150 prevent-select tracking-wider">FOCUS</a>

        <div class="flex space-x-4">
            <select id="navBarCategorySelector" class="bg-transparent outline-none border-0 w-1/3">
                <option>
                <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">All</a>
                </option>
            </select>
            <form action="/advSearch" method="GET" class="hidden md:flex justify-center items-start">
                <input type="text" name="search" placeholder="Search..." class="px-2 py-1 rounded sm:w-auto md:w-96">
                <button type="submit" class="ml-2 px-2 py-1 bg-comp-2 text-secondary font-semibold rounded">Search</button>
            </form>
        </div>
        <div class="flex space-x-4 items-center">
            <a href="/advSearch" class="block md:hidden">Search</a>
            <?php if($usertype === 'I'): ?>
            <div>
                <button id="CreateCourseLink" data-dropdown-toggle="CreateCourse" class="flex items-center justify-between w-full py-2 px-3 md:p-0 md:w-auto">
                    <svg class="w-6 h-6 text-comp-2 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4.243a1 1 0 1 0-2 0V11H7.757a1 1 0 1 0 0 2H11v3.243a1 1 0 1 0 2 0V13h3.243a1 1 0 1 0 0-2H13V7.757Z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div id="CreateCourse" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownLargeButton">
                        <li>
                            <a href="/createCourse" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Create Course</a>
                        </li>
                        <li>
                            <a href="/user?myProfile=true" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit Course</a>
                        </li>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
            <?php if($usertype === "G"): ?>
            <a href="/" class="ease-in duration-150">Chats</a>
            <?php else: ?>
            <a href="/chats" class="ease-in duration-150">Chats</a>
            <?php endif;?>
            <a href="/cart" class="ease-in duration-150">Cart</a>
            <?php if($usertype !== "G"){ ?>
            <button id="UserOptionsLink" data-dropdown-toggle="UserOptions" class="flex items-center justify-between w-full py-2 px-3 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-gray-400 dark:hover:text-white dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent">
            <img class="md:flex md:h-8 md:w-8 hidden rounded-full" src="data:image/*;base64,<?= $_SESSION["user"]["profilePicture"] ?>" alt="" />
            </button>
            <div id="UserOptions" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownLargeButton">
                    <li>
                        <a href="/profile?myProfile=true" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Profile</a>
                    </li>
                    <li>
                        <a href="/login" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sign Out</a>
                    </li>
                </ul>
            </div>
            <?php }else{?>
             <button id="UserOptionsLink" class="flex items-center justify-between w-full py-2 px-3 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-gray-400 dark:hover:text-white dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent">
                 <a href="/login">   
                 <svg class="w-6 h-6 text-comp-2 dark:text-primary" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                     <path fill-rule="evenodd" d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z" clip-rule="evenodd" />
                    </svg>
                    </a>
            </button>
            <?php }?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>

    <script>fetch("/categories")
.then(response => response.json())
.then(data => {
const categorySelector = document.getElementById("navBarCategorySelector");

data.payload.categories.forEach((category) => {
            const option = document.createElement("option");
            option.value = category.categoryId;
            const a = document.createElement("a");
            a.className = "block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
            a.textContent = category.categoryName;
            option.appendChild(a);
            categorySelector.appendChild(option);
        });
}); </script>
</nav>