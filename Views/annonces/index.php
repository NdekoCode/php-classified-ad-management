<!-- Create By Joker Banny -->

<body class="bg-white">

    <!-- Title -->
    <div class="py-10 bg-white">
        <h1 class="text-2xl font-bold text-center text-gray-800">All Annonces</h1>
    </div>


    <!-- Product List -->
    <section class="py-10 bg-gray-100 ">
        <div class="container">
            <div class="grid grid-cols-1 gap-8 mt-8  md:mt-16 md:grid-cols-2">
                <?php foreach ($annonces as $annonce) : ?>

                    <article class="relative duration-300 bg-white shadow-lg lg:flex rounded-xl hover:shadow-xl hover:transform hover:scale-105">

                        <div class="flex items-end overflow-hidden rounded-xl">
                            <img class="object-cover w-full" src="https://images.unsplash.com/photo-1549298916-b41d501d3772?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1112&q=80" alt="Hotel Photo" />
                        </div>

                        <div class="flex flex-col justify-between py-6 lg:mx-6">
                            <h3 class="text-xl font-semibold text-slate-700 hover:underline dark:text-white ">
                                <?= $annonce->getTitle() ?>
                            </h3>

                            <p class="mt-1 text-sm text-slate-400"><?= $annonce->getExcerpt() ?></p>
                            <span class="text-sm text-gray-500 dark:text-gray-300">On: <?= $annonce->getCreatedAt() ?></span>

                            <a href="/annonces/read/<?= $annonce->getId() ?>" class="text-sm inline-block rounded-lg bg-blue-500 px-4 py-1.5 text-white duration-100 hover:bg-blue-600">Learn more</a>
                        </div>
                        <a href="/annonces/read/<?= $annonce->getId() ?>" class="absolute inset-0 o pacity-0"></a>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>