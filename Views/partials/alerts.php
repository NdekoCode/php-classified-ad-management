<?php if (isset($_SESSION['alert'])) : ?>
    <div class="container mt-10">
        <?php if (isset($_SESSION['alert']['danger'])) : ?>
            <div class="mb-4 alert">
                <div class="flex w-full max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-md">
                    <div class="w-2 bg-red-600">
                    </div>
                    <div class="flex items-start justify-between w-full px-2 py-2">
                        <div class="flex flex-col ml-2">
                            <strong class="font-medium text-gray-800"> <span class="font-bold">Alert</span> Danger</strong>
                            <p class="text-gray-500 "><?= $_SESSION['alert']['danger'] ?>
                        </div>
                        <button href="#" class="alert-btn-close">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        <?php unset($_SESSION['alert']['danger']);
        endif; ?>
        <?php if (isset($_SESSION['alert']['success'])) : ?>
            <div class="mb-4 alert">
                <div class="flex w-full max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-md">
                    <div class="w-2 bg-green-600">
                    </div>
                    <div class="flex items-start justify-between w-full px-2 py-2">

                        <div class="flex flex-col ml-2">
                            <strong class="font-medium text-gray-800"> <span class="font-bold">Danger</span> Alert</strong>
                            <p class="text-gray-500 "><?= $_SESSION['alert']['success'] ?>
                        </div>
                        <button href="#" class="alert-btn-close">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div> <?php unset($_SESSION['alert']['success']);
                endif; ?>
        <?php if (isset($_SESSION['alert']['warning'])) : ?>
            <div class="mb-4 alert">
                <div class="flex w-full max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-md">
                    <div class="w-2 bg-yellow-600">
                    </div>
                    <div class="flex items-start justify-between w-full px-2 py-2">
                        <div class="flex flex-col ml-2">
                            <strong class="font-medium text-gray-800"> <span class="font-bold">Alert</span> Success</strong>
                            <p class="text-gray-500 "><?= $_SESSION['alert']['warning'] ?>
                        </div>
                        <button href="#" class="alert-btn-close">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div><?php unset($_SESSION['alert']['warning']);
                endif; ?>

    </div>
<?php endif; ?>