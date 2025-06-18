<?php if (isset($component)) { $__componentOriginalff09156f73c896030ee75284e9b2c466 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalff09156f73c896030ee75284e9b2c466 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalff09156f73c896030ee75284e9b2c466)): ?>
<?php $attributes = $__attributesOriginalff09156f73c896030ee75284e9b2c466; ?>
<?php unset($__attributesOriginalff09156f73c896030ee75284e9b2c466); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalff09156f73c896030ee75284e9b2c466)): ?>
<?php $component = $__componentOriginalff09156f73c896030ee75284e9b2c466; ?>
<?php unset($__componentOriginalff09156f73c896030ee75284e9b2c466); ?>
<?php endif; ?>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h1 class="text-2xl font-bold mb-4">Your Documents</h1>

                    <form method="GET" action="<?php echo e(route('documents.overview')); ?>" class="mb-4 flex gap-2 items-center">
                        <input type="text" name="search" placeholder="Search documents..." value="<?php echo e(request('search')); ?>"
                               class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm flex-grow">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Search</button>
                    </form>

                    <?php if(Auth::user()->google_refresh_token || Auth::user()->microsoft_refresh_token): ?>
                        <a href="<?php echo e(route('documents.overview', ['sync_all' => 1])); ?>"
                           class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded mb-4 inline-block">
                            🔄 Sync All Accounts
                        </a>
                    <?php endif; ?>

                    <?php if($lastSyncedAt): ?>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                            Last synced: <?php echo e(\Carbon\Carbon::parse($lastSyncedAt)->format('d-m-Y H:i')); ?>

                        </p>
                    <?php else: ?>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                            Last synced: Never
                        </p>
                    <?php endif; ?>

    <div class="p-4 max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold mb-2">Documents</h1>

        <!-- Upload Form -->
        <form method="POST" action="<?php echo e(route('documents.upload')); ?>" enctype="multipart/form-data" class="mb-6">
            <?php echo csrf_field(); ?>
            <input type="file" name="file" id="file" required class="border rounded px-2 py-1 mr-2">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                Upload File (Max 10 MB)
            </button>
            <p id="file-info" class="mt-2 text-sm text-gray-700"></p>
        </form>

                    <?php if(session('status')): ?>
                        <div class="mb-4 text-green-600 font-semibold"><?php echo e(session('status')); ?></div>
                    <?php endif; ?>

                    <?php if($errors->any()): ?>
                        <div class="mb-4 text-red-600 font-semibold">
                            <ul>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <ul class="space-y-1">
                        <?php $__empty_1 = true; $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <li class="p-3 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                                <a href="<?php echo e($file->web_view_link); ?>" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">
                                    <?php echo e($file->name); ?>

                                </a>
                                <span class="ml-4 text-xs font-semibold px-2 py-1 rounded-full
                                    <?php if($file->provider == 'google'): ?> bg-red-200 text-red-800 <?php elseif($file->provider == 'microsoft'): ?> bg-blue-200 text-blue-800 <?php else: ?> bg-gray-200 text-gray-800 <?php endif; ?>">
                                    <?php echo e(ucfirst($file->provider)); ?>

                                </span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <li class="text-gray-500 mt-4">No documents found. Try connecting an account and syncing.</li>
                        <?php endif; ?>
                    </ul>

                </div>
            </div>
        </div>
    </div>
    </div>
<?php /**PATH C:\Users\Senna\CMGT Jaar 2\TLE2_Startup\resources\views/alldocuments/documents-overview.blade.php ENDPATH**/ ?>