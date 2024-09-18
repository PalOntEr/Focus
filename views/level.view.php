<?php
    require 'views/components/header.php';
    require 'views/components/navbar.php';
?>
<div class="container mx-auto flex h-full space-x-4">

    <div class="w-2/3 h-full font-bold">
        <div class="text-secondary text-md">
            Course name
        </div>
        <div class="text-secondary text-2xl">
            Level name
        </div>
        <div class="bg-gray-600 m-4 rounded-xl">
            <video class="rounded-xl" src="https://videos.pexels.com/video-files/855390/855390-uhd_2560_1440_25fps.mp4" autoplay loop></video>
        </div>
        <div class="text-secondary text-md">
            Resources
            <div class="bg-comp-1 space-y-2 rounded-md p-2">
                <?php                
                    for( $i = 1; $i <= 5; $i++ ) {
                        $docName = "Document $i";
                        $docRef = "https://www.google.com";
                        require 'views/components/resource.php';
                    }
                ?>
            </div>
        </div>
    </div>

    <div class="bg-secondary w-1/3 rounded-md overflow-y-scroll h-full">
        <div class="mt-4 text-center text-primary font-bold text-3xl">
            Content
        </div>
        <div class="mx-4">
            <?php
                for( $i = 1; $i <= 100; $i++ ) {
                    $level = $i;
                    $levelComplete = false;
                    if(rand(0,1) == 1){
                        $levelComplete = true;
                    }
                    require 'views/components/levelPreview.php';
                }
            ?>
        </div>
    </div>

</div>