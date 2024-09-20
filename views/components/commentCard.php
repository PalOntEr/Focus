<div class="flex flex-col w-full sm:w-72 h-fit sm:h-48 max-h-[367px] bg-primary mb-2 sm:m-2 p-2 justify-center items-center rounded-2xl" style="width=500px;">
    <div class="flex w-full h-1/4 p-1 items-center justify-between font-semibold">
        <div class="flex items-center w-1/2 text-color font-semibold">
            <img class="w-6 h-6 mr-1" src="https://www.iconpacks.net/icons/2/free-user-icon-3296-thumb.png" alt="user">    
            <?= $commentUser ?>
        </div>
        <div class="flex items-center justify-end w-1/2">
            <div class="text-comp-2 mr-2"><?= $stars ?>/5⭐</div>
            <button class="delete-button" onclick="showModal()">
                <img class="h-5 w-5 bg-color rounded-full" src="https://cdn-icons-png.flaticon.com/512/1017/1017530.png" alt="delete">
            </button>
        </div>
    </div>
    <div class="flex w-full h-3/4 px-3 items-center justify-between font-semibold overflow-y-scroll">
        <div class="text-color"><?= $comment ?></div>
    </div>
</div>

<!-- Modal Structure -->
<div id="deleteModal" class="modal hidden fixed inset-0 bg-gray-600 bg-opacity-50 items-center justify-center">
    <div class="bg-white p-5 rounded-lg">
        <h2 class="text-lg font-semibold mb-4">Confirm Deletion</h2>
        <p class="mb-4">Reason for deletion</p>
        <textarea id="deleteReason" class="w-full p-2 rounded border border-gray-300" rows="4"></textarea>
        <div class="flex justify-end">
            <button class="bg-gray-300 px-4 py-2 rounded mr-2" onclick="hideModal()">Cancel</button>
            <button class="bg-red-500 text-white px-4 py-2 rounded" onclick="confirmDelete()">Delete</button>
        </div>
    </div>
</div>

<script>
function showModal() {
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}

function hideModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
}

function confirmDelete() {
    const reason = document.querySelector('#deleteReason').value.trim();
    if (reason === '') {
        swal({
            title: 'Error!',
            text: 'Please provide a reason for deletion.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }

    // Add your deletion logic here
    swal({
        title: 'Deleted!',
        text: 'Comment has been deleted.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
    hideModal();
}
</script>
