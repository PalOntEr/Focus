<style><?php require 'views/css/navbar.css'; ?></style>
<nav class="bg-secondary p-4 mb-2 sticky top-0">
    <div class="container mx-auto flex justify-between items-center">
        <a href="/home" class="text-3xl font-bold ease-in duration-150 prevent-select tracking-wider">FOCUS</a>
        <form action="#" method="GET" class="hidden sm:flex justify-center items-start">
            <input type="text" name="search" placeholder="Search..." class="px-2 py-1 rounded sm:w-auto md:w-96">
            <button type="submit" class="ml-2 px-2 py-1 bg-color text-secondary rounded">Search</button>
        </form>
        <div class="flex space-x-4 items-center">
            <a href="#" class="block sm:hidden">Search</a>
            <a href="/chats" class="ease-in duration-150">Chats</a>
            <a href="#" class="ease-in duration-150">Cart</a>
            <a href="/login" class=""><img class="h-6 w-6" src="https://www.iconpacks.net/icons/2/free-user-icon-3296-thumb.png" alt=""></a>
        </div>
    </div>
</nav>