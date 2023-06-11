<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="w-full p-6 mb-4 border border-b border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                <form method="POST" action="action.php">
                    <div class="mb-4">
                        <label class="text-xl text-gray-600">Title <span class="text-red-500">*</span></label></br>
                        <input type="text" class="w-full p-2 border-2 border-gray-300" name="title" id="title" value="" required>
                    </div>

                    <div class="mb-4">
                        <label class="text-xl text-gray-600">Description</label></br>
                        <input type="text" class="w-full p-2 border-2 border-gray-300" name="description" id="description" placeholder="(Optional)">
                    </div>

                    <div class="mb-8">
                        <label class="text-xl text-gray-600">Content <span class="text-red-500">*</span></label></br>
                        <textarea name="content" class="border-2 border-gray-500">

                            </textarea>
                    </div>

                    <div class="flex p-1">
                        <button type="submit" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
                            Publish post
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

<script>
    CKEDITOR.replace('content');
</script>