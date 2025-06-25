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
                           class="px-4 py-2 border-gray-300 dark:border-gray-700 dark:bg-articleBlue dark:text-viridian focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-[44vw]">
                    <button type="submit" class="px-4 py-2 rounded-md bg-articleBlue hover:bg-accentGreen text-viridian hover:text-greenLight dark:bg-accentBlue dark:hover:bg-accentGreen dark:text-greenLight">Search</button>
                </form>

                
                <div id="filter-container" class="mb-4 flex flex-wrap items-center gap-2">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">Filter:</span>
                    <?php
                        $filterOptions = ['document', 'powerpoint', 'excel', 'form', 'pdf', 'google', 'microsoft', 'local'];
                        $baseClass = 'px-3 py-1 text-sm font-medium rounded-full cursor-pointer transition';
                        $activeClass = 'bg-accentGreen text-greenLight dark:bg-articleBlue dark:text-viridian';
                        $inactiveClass = 'bg-articleBlue text-viridian dark:bg-accentBlue dark:text-articleBlue hover:bg-accentGreen dark:hover:bg-accentGreen';
                    ?>

                    <button data-filter="all" class="<?php echo e($baseClass); ?> <?php echo e(empty($activeFilters) ? $activeClass : $inactiveClass); ?>">
                        All
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

                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                    Last synced: <?php echo e($lastSyncedAt ? \Carbon\Carbon::parse($lastSyncedAt)->format('d-m-Y H:i') : 'Never'); ?>

                </p>

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
            <ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-[2vw]">
                <?php $__empty_1 = true; $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <li class="bg-articleBlue dark:bg-accentBlue p-4 rounded shadow relative w-[18vw] flex flex-col gap-2">
                        <div class="flex justify-between items-center">
                            <?php if($file->provider === 'local'): ?>
                                
                                <a href="<?php echo e(route('documents.serve.local', $file->id)); ?>" target="_blank" aria-label="<?php echo e($file->name); ?>" class="max-w-[12vw] overflow-hidden overflow-ellipsis whitespace-nowrap text-viridian hover:text-accentBlue dark:text-greenLight dark:hover:text-articleBlue">
                                    <?php echo e($file->name); ?> 
                                </a> 
                            <?php else: ?>
                                
                                <a href="<?php echo e($file->web_view_link); ?>" target="_blank" aria-label="<?php echo e($file->name); ?>" class="max-w-[12vw] overflow-hidden overflow-ellipsis whitespace-nowrap text-viridian hover:text-accentBlue dark:text-greenLight dark:hover:text-articleBlue">
                                    <?php echo e($file->name); ?> 
                                </a> 
                            <?php endif; ?>
                            <div class="w-5 flex justify-between mr-1">
                                <?php if($file->mime_type == 'application/vnd.google-apps.spreadsheet'): ?>
                                    <img src="<?php echo e(asset('images/sheets.png')); ?>" alt="Google_Sheets"/>
                                <?php elseif($file->mime_type == 'application/vnd.openxmlformats-officedocument.presentationml.presentation' || $file->mime_type == 'application/vnd.google-apps.presentation'): ?>
                                    <img src="<?php echo e(asset('images/slides.png')); ?>" alt="Google_Slides"/>
                                <?php elseif($file->mime_type == 'application/vnd.google-apps.form'): ?>
                                    <img src="<?php echo e(asset('images/forms.png')); ?>" alt="Google_Forms"/>
                                <?php elseif($file->mime_type == 'application/vnd.google-apps.document'): ?>
                                    <img src="<?php echo e(asset('images/docs.png')); ?>" alt="Google_Docs"/>
                                <?php elseif($file->mime_type == 'application/pdf'): ?>
                                    <img src="<?php echo e(asset('images/pdf.png')); ?>" alt="File_PDF"/>
                                <?php else: ?>
                                    <img src="<?php echo e(asset('images/other.png')); ?>" alt="File_Other"/>
                                <?php endif; ?>
                            </div>
                        </div>

                        <form method="POST" action="<?php echo e(route('workspaces.addDocumentToSelected')); ?>">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="cloudfile_id" value="<?php echo e($file->id); ?>">

                            <select name="workspace_id" class="w-full px-3 py-2 rounded border-gray-300 mb-2 dark:bg-articleBlue dark:text-viridian dark:border-gray-600">
                                <?php $__currentLoopData = $userWorkspaces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ws): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($ws->id); ?>"><?php echo e($ws->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <button type="submit" class="bg-green-500 text-white px-3 py-2 rounded w-full text-sm hover:bg-green-600">
                                Add to Selected Workspace
                            </button>
                        </form>
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
                const button = e.target.closest('button[data-filter]');
                if (!button) return;

                const clickedFilter = button.dataset.filter;
                const currentUrl = new URL(window.location.href);
                const params = currentUrl.searchParams;
                let activeFilters = params.getAll('filters[]');

                if (clickedFilter === 'all') {
                    params.delete('filters[]');
                } else {
                    const index = activeFilters.indexOf(clickedFilter);
                    if (index > -1) {
                        activeFilters.splice(index, 1);
                    } else {
                        activeFilters.push(clickedFilter);
                    }
                    params.delete('filters[]');
                    activeFilters.forEach(filter => params.append('filters[]', filter));
                }

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

    document.getElementById('file').addEventListener('change', function () {
        const file = this.files[0];
        const info = document.getElementById('file-info');

        if (file && file.size > 10 * 1024 * 1024) {
            info.textContent = 'File is bigger than 10 MB. Please select a smaller file.';
            this.value = '';
        } else if (file) {
            info.textContent = `Selected file: ${file.name} (${(file.size / (1024 * 1024)).toFixed(2)} MB)`;
        } else {
            info.textContent = '';
        }
    });
</script>

<?php /**PATH C:\Users\Senna\CMGT Jaar 2\TLE2_Startup\resources\views/alldocuments/documents-overview.blade.php ENDPATH**/ ?>