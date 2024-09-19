<div class="flex flex-col w-5/6 sm:w-1/3 bg-primary m-5 sm:m-2 p-5 justify-center items-center rounded-2xl shadow-lg hover:scale-50">
    <div class="flex justify-center w-full h-5/6 mb-5 bg-color rounded-2xl">
        <img class="w-auto h-auto rounded-2xl" src="https://pbs.twimg.com/media/GVq8fLsaoAEnzsl?format=jpg&name=large" alt="Course">
    </div>
    <div class="w-full text-secondary font-semibold">
        PHP Course
    </div>
    <div class="flex justify-between w-full font-semibold">
        <div class="text-comp-2">Instructor</div>
        <div class="text-comp-2">4.3/5⭐</div>
    </div>
    <button onclick="addToCart()" class="w-1/2 text-center bg-comp-1 text-color rounded p-1 hover:opacity-80 font-bold">
        ADD TO CART
    </button>
</div>
    <div class="flex flex-row justify-evenly w-full">
        <button onclick="location.href='/course'" class="w-full mx-2 text-center bg-comp-1 text-color rounded p-1 hover:opacity-80 font-bold">
        PREVIEW
        </button>
        <button class="w-full mx-2 text-center bg-comp-1 text-color rounded p-1 hover:opacity-80 font-bold">
            ADD TO CART
        </button>
    </div>
<script>
    function addToCart() {
        swal({
            title: 'Success!',
            text: 'The course has been added to your cart.',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    };
</script>
</div>
