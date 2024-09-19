<?php
require 'views/components/header.php';
require 'views/components/navbar.php';
?>

<div class="container mx-auto flex flex-col h-full">
    <div class="flex w-full h-full mb-4 overflow-y-hidden">
        <div class="w-1/6 bg-primary rounded-md">
            <form id="filters" action="search_results.php" method="GET" class="p-4">
                <div class="mb-4">
                    <label for="category" class="block text-sm font-medium text-color">Category</label>
                    <select id="category" name="category" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md">
                        <option value="">Select a category</option>
                        <option value="CS">Computer Science</option>
                        <option value="EN">Engineering</option>
                        <option value="LA">Languages</option>
                        <!-- Add more categories as needed -->
                    </select>
                </div>
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-color">Title</label>
                    <input type="text" id="title" name="title" class="px-2 py-1 rounded w-full">
                </div>
                <div class="mb-4">
                    <label for="user" class="block text-sm font-medium text-color">User who published course</label>
                    <input type="text" id="user" name="user" class="px-2 py-1 rounded w-full">
                </div>
                <div class="mb-4">
                    <label for="start_date" class="block text-sm font-medium text-color">Start Date</label>
                    <input type="date" id="start_date" name="start_date" class="px-2 py-1 rounded w-full">
                </div>
                <div class="mb-4">
                    <label for="end_date" class="block text-sm font-medium text-color">End Date</label>
                    <input type="date" id="end_date" name="end_date" class="px-2 py-1 rounded w-full">
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="ml-2 px-2 py-1 bg-comp-2 text-secondary font-semibold rounded">Search</button>
                </div>
            </form>
        </div>
        <div class="flex h-full flex-wrap justify-center overflow-y-scroll">
                <?php
                    for ($i = 0; $i < 10; $i++) {
                        require 'views/components/courseCard.php';
                    }
                ?>
        </div>
    </div>
</div>

<script>
    document.querySelector('#filters').addEventListener('submit', function(event) {
        event.preventDefault();
        var startDate = document.getElementById('start_date').value;
        var endDate = document.getElementById('end_date').value;
        var category = document.getElementById('category').value;
        var title = document.getElementById('title').value;
        var user = document.getElementById('user').value;

        if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
            swal({
                icon: 'error',
                title: 'Invalid Date Range',
                text: 'Start Date must be before or the same day as End Date.',
            });
            return;
        }

        if (!category && !title && !user && !startDate && !endDate) {
            swal({
                icon: 'error',
                title: 'No Filters Selected',
                text: 'Please select at least one filter before searching.',
            });
            return;
        }

        this.submit();
    });
</script>