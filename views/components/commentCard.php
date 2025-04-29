<div class="flex flex-col w-full sm:w-72 h-fit sm:h-48 max-h-[367px] bg-primary mb-2 sm:m-2 p-2 justify-center items-center rounded-2xl" style="width=500px;">
    <div class="flex w-full h-1/4 p-1 items-center justify-between font-semibold">
        <div class="flex items-center w-1/2 text-color font-semibold">
            <img class="w-6 h-6 mr-1" src="https://www.iconpacks.net/icons/2/free-user-icon-3296-thumb.png" alt="user">    
            <p class="User text-color"></p>
        </div>
        <div class="flex items-center justify-end w-1/2">
            <div class="Rating text-comp-2 mr-2"></div>
            <?php if ($usertype === 'A'): ?>
                <button class="delete-button" onclick="showModal()">
                    <img class="h-5 w-5 bg-color p-1 rounded-md" src="https://cdn-icons-png.flaticon.com/512/1017/1017530.png" alt="delete">
                </button>
            <?php endif; ?>
        </div>
    </div>
    <div class="flex w-full h-3/4 px-3 items-center justify-between font-semibold overflow-y-scroll">
        <div class="Comment text-color"></div>
    </div>
    <div class="CommentDate flex w-full h-1/4 p-1 items-center justify-end text-color text-sm">
    </div>  
</div>

<div id="deleteModal" class="modal hidden fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center">
    <div class="bg-white p-5 rounded-lg sm:w-1/3">
        <h2 class="text-lg font-semibold mb-4">Confirm Deletion</h2>
        <p class="mb-4">Reason for deletion</p>
        <textarea id="deleteReason" class="w-full p-2 rounded border border-gray-300" rows="4"></textarea>
        <div class="flex justify-end">
            <button class="bg-gray-300 px-4 py-2 rounded mr-2" onclick="hideModal()">Cancel</button>
            <button id="COMMENT_ID" class="DeleteButton bg-red-500 text-white px-4 py-2 rounded" onclick="confirmDelete()">Delete</button>
        </div>
    </div>
</div>

