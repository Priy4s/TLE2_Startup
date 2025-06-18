<?php if (isset($component)) { $__componentOriginalff09156f73c896030ee75284e9b2c466 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalff09156f73c896030ee75284e9b2c466 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <h1 class="text-6xl font-bold">Your Documents</h1>
    <div class="mt-10">
        <div class="flex justify-between w-full">
            <div>
                <form method="GET" action="<?php echo e(route('documents.overview')); ?>" class="mb-4 flex gap-2 items-center">
                    <input type="text" name="search" placeholder="Search documents..." value="<?php echo e(request('search')); ?>"
                           class="border-gray-300 dark:border-gray-700 dark:bg-articleBlue dark:text-viridian focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Search</button>
                </form>

                
                <div id="filter-container" class="mb-4 flex flex-wrap items-center gap-2">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">Filter:</span>
                    <?php
                        $filterOptions = ['google', 'microsoft', 'word', 'powerpoint', 'pdf', 'local'];
                        $baseClass = 'px-3 py-1 text-sm font-medium rounded-full cursor-pointer transition';
                        $activeClass = 'bg-blue-600 text-white';
                        $inactiveClass = 'bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600';
                    ?>

                    
                    <button data-filter="all" class="<?php echo e($baseClass); ?> <?php echo e(empty($activeFilters) ? $activeClass : $inactiveClass); ?>">
                        Alles
                    </button>

                    
                    <?php $__currentLoopData = $filterOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button data-filter="<?php echo e($filter); ?>"
                                class="<?php echo e($baseClass); ?> <?php echo e(in_array($filter, $activeFilters ?? []) ? $activeClass : $inactiveClass); ?>">
                            <?php echo e(ucfirst($filter)); ?>

                        </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <div class="text-right">
                <?php if(Auth::user()->google_refresh_token || Auth::user()->microsoft_refresh_token): ?>
                    <a href="<?php echo e(route('documents.overview', ['sync_all' => 1])); ?>"
                       class="w-[13vw] bg-articleBlue hover:bg-accentGreen text-viridian hover:text-greenLight dark:bg-accentBlue dark:hover:bg-accentGreen dark:text-greenLight text-center px-4 py-2 rounded mb-1 inline-block">
                         Sync Documents <i class="fa-solid fa-rotate ml-2"></i>
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

                <button onclick="openModal('upload-file')" class="w-[13vw] bg-articleBlue hover:bg-accentGreen text-viridian hover:text-greenLight dark:bg-accentBlue dark:hover:bg-accentGreen dark:text-greenLight px-4 py-2 rounded">
                    Upload File <i class="fa-solid fa-upload ml-2"></i>
                </button>

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
            </div>
        </div>

        <h2 class="text-2xl font-bold mb-2">Documents</h2>
        <div>
            <ul class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-[2vw]">
                <?php $__empty_1 = true; $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <li class="bg-articleBlue dark:bg-accentBlue p-4 rounded shadow relative w-[24vw] flex justify-between items-center">
                        <a href="<?php echo e($file->web_view_link); ?>" target="_blank" class="max-w-[12vw] break-words text-viridian hover:text-accentBlue dark:text-greenLight dark:hover:text-articleBlue">
                            <?php echo e($file->name); ?>

                        </a>
                        <div class="w-28 flex justify-between mr-1">
                            <?php if($file->mime_type == 'application/vnd.google-apps.spreadsheet'): ?>
                                <span class="text-xs bg-green-200 text-green-800 dark:bg-green-800 dark:text-green-100 font-semibold px-2 py-1 rounded-full">Sheets</span>
                            <?php elseif($file->mime_type == 'application/vnd.openxmlformats-officedocument.presentationml.presentation' || $file->mime_type == 'application/vnd.google-apps.presentation'): ?>
                                <span class="text-xs bg-orange-200 text-orange-800 dark:bg-orange-800 dark:text-orange-100 font-semibold px-2 py-1 rounded-full">Slides</span>
                            <?php elseif($file->mime_type == 'application/vnd.google-apps.form'): ?>
                                <span class="text-xs bg-purple-200 text-purple-800 dark:bg-purple-800 dark:text-purple-100 font-semibold px-2 py-1 rounded-full">Forms</span>
                            <?php elseif($file->mime_type == 'application/vnd.google-apps.document'): ?>
                                <span class="text-xs bg-blue-200 text-blue-800 dark:bg-blue-900 dark:text-blue-100 font-semibold px-2 py-1 rounded-full">Docs</span>
                            <?php else: ?>
                                <span class="text-xs bg-gray-200 text-gray-800 dark:bg-gray-800 dark:text-gray-100 font-semibold px-2 py-1 rounded-full">Other</span>
                            <?php endif; ?>
                            <span class="ml-2 text-xs font-semibold px-2 py-1 rounded-full
                                <?php if($file->provider == 'google'): ?> bg-red-200 text-red-800 dark:bg-red-900 dark:text-red-200 <?php elseif($file->provider == 'microsoft'): ?> bg-blue-200 text-blue-800 dark:bg-blue-900 dark:text-blue-200 <?php else: ?> bg-gray-200 text-gray-800 dark:bg-gray-900 dark:text-gray-200 <?php endif; ?>">
                                <?php echo e(ucfirst($file->provider)); ?>

                            </span>
                        </div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <li class="text-gray-500 mt-4">No documents found. Try connecting an account and syncing.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <div id="modal-upload-file" class="fixed inset-0 flex items-center justify-center hidden z-50">
        <div class="absolute inset-0 bg-greenLight dark:bg-viridian bg-opacity-50 dark:bg-opacity-50" onclick="closeModal('upload-file')"></div>

        <div class="relative bg-articleBlue dark:bg-accentBlue p-6 rounded shadow-lg w-full max-w-md z-10">
            <button class="absolute top-2 right-2 text-viridian hover:text-accentGreen text-xl" onclick="closeModal('upload-file')">&times;</button>

            <h1 class="text-xl font-bold mb-4">Upload File (Max 10 MB)</h1>

            <form method="POST" action="<?php echo e(route('documents.upload')); ?>" enctype="multipart/form-data" class="mb-6">
                <?php echo csrf_field(); ?>
                <label for="file" class="block text-sm font-medium text-viridian dark:text-greenLight mb-2">Select File</label>
                <input type="file" name="file" id="file" required class="border rounded px-2 py-1 w-full mb-4 bg-articleBlue text-viridian">

                <?php if (isset($component)) { $__componentOriginald411d1792bd6cc877d687758b753742c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald411d1792bd6cc877d687758b753742c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.primary-button','data' => ['type' => 'submit']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('primary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit']); ?>Upload file <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $attributes = $__attributesOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__attributesOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $component = $__componentOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__componentOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>

                <p id="file-info" class="mt-2 text-sm text-gray-700"></p>
            </form>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalff09156f73c896030ee75284e9b2c466)): ?>
<?php $attributes = $__attributesOriginalff09156f73c896030ee75284e9b2c466; ?>
<?php unset($__attributesOriginalff09156f73c896030ee75284e9b2c466); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalff09156f73c896030ee75284e9b2c466)): ?>
<?php $component = $__componentOriginalff09156f73c896030ee75284e9b2c466; ?>
<?php unset($__componentOriginalff09156f73c896030ee75284e9b2c466); ?>
<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterContainer = document.getElementById('filter-container');

        if (filterContainer) {
            filterContainer.addEventListener('click', function (e) {
                // Reageer alleen op klikken op een knop met een data-filter attribuut
                const button = e.target.closest('button[data-filter]');
                if (!button) return;

                const clickedFilter = button.dataset.filter;

                // Haal de huidige URL en zijn parameters op
                const currentUrl = new URL(window.location.href);
                const params = currentUrl.searchParams;

                // Haal de lijst van actieve filters op
                let activeFilters = params.getAll('filters[]');

                if (clickedFilter === 'all') {
                    // Als op 'Alles' wordt geklikt, verwijder alle filters
                    params.delete('filters[]');
                } else {
                    const index = activeFilters.indexOf(clickedFilter);
                    if (index > -1) {
                        // Filter is al actief, dus verwijder het
                        activeFilters.splice(index, 1);
                    } else {
                        // Filter is niet actief, dus voeg het toe
                        activeFilters.push(clickedFilter);
                    }

                    // Werk de URL parameters bij
                    params.delete('filters[]'); // Verwijder de oude lijst
                    if (activeFilters.length > 0) {
                        activeFilters.forEach(filter => {
                            params.append('filters[]', filter);
                        });
                    }
                }

                // Navigeer naar de nieuwe URL
                window.location.href = currentUrl.toString();
            });
        }
    });
    function openModal(id) {
        document.getElementById('modal-' + id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById('modal-' + id).classList.add('hidden');
    }
</script><?php /**PATH C:\Users\Senna\CMGT Jaar 2\TLE2_Startup\resources\views/alldocuments/documents-overview.blade.php ENDPATH**/ ?>