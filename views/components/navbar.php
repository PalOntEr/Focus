<style>
    <?php require 'views/css/navbar.css'; ?>
</style>
<nav class="bg-primary p-4 mb-2 sticky top-0">
    <div class="container mx-auto flex justify-between items-center">
        <a href="/home" class="text-3xl font-bold ease-in duration-150 prevent-select tracking-wider">FOCUS</a>

        <div class="flex space-x-4">
            <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar" class="hidden lg:flex items-center font-bold w-full py-2 px-3 md:border-0 md:p-0 md:w-auto">
                Categories <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                </svg></button>
            <div id="dropdownNavbar" class="z-10 hidden font-normal bg-white divide-y rounded-lg">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownLargeButton">
                    <li>
                        <a href="/advSearch" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Computer Science</a>
                    </li>
                    <li>
                        <a href="/advSearch" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Languages</a>
                    </li>
                    <li>
                        <a href="/advSearch" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Engineering</a>
                    </li>
                </ul>
            </div>
            <form action="/advSearch" method="GET" class="hidden md:flex justify-center items-start">
                <input type="text" name="search" placeholder="Search..." class="px-2 py-1 rounded sm:w-auto md:w-96">
                <button type="submit" class="ml-2 px-2 py-1 bg-comp-2 text-secondary font-semibold rounded">Search</button>
            </form>
        </div>
        <div class="flex space-x-4 items-center">
            <a href="/advSearch" class="block sm:hidden">Search</a>
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
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit Course</a>
                        </li>
                    </ul>
                </div>
            </div>
            <a href="/chats" class="ease-in duration-150">Chats</a>
            <a href="/cart" class="ease-in duration-150">Cart</a>
            <button id="UserOptionsLink" data-dropdown-toggle="UserOptions" class="flex items-center justify-between w-full py-2 px-3 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-gray-400 dark:hover:text-white dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent">
                <svg class="w-6 h-6 text-comp-2 dark:text-primary" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z" clip-rule="evenodd" />
                </svg>
            </button>
            <div id="UserOptions" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownLargeButton">
                    <li>
                        <a href="/user" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Profile</a>
                    </li>
                    <li>
                        <a href="/login" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sign Out</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>