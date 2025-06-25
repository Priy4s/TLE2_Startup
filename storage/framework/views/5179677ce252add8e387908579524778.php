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
        <h1 class="text-6xl font-bold"><?php echo e($workspace->name); ?></h1>
    <div class="mt-10">
        <div class="flex">
            <div class="w-[40vw]">
                <h2 class="text-2xl font-bold mb-2">Documents</h2>
                <ul>
                    <?php $__empty_1 = true; $__currentLoopData = $workspace->cloudFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li class="bg-articleBlue dark:bg-accentBlue p-3 rounded flex justify-between items-center mb-2">
                            <?php if($file->provider === 'local'): ?>
                                
                                <a href="<?php echo e(route('documents.serve.local', $file->id)); ?>" target="_blank" aria-label="<?php echo e($file->name); ?>" class="max-w-[12vw] overflow-hidden overflow-ellipsis whitespace-nowrap text-viridian hover:text-accentBlue dark:text-greenLight dark:hover:text-articleBlue">
                                    <?php echo e($file->name); ?> 
                                </a> 
                            <?php else: ?>
                                
                                <a href="<?php echo e($file->web_view_link); ?>" target="_blank" aria-label="<?php echo e($file->name); ?>" class="max-w-[12vw] overflow-hidden overflow-ellipsis whitespace-nowrap text-viridian hover:text-accentBlue dark:text-greenLight dark:hover:text-articleBlue">
                                    <?php echo e($file->name); ?> 
                                </a> 
                            <?php endif; ?>
                            <div class="flex">
                                <div class="w-5 flex justify-between mr-4">
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
                                <form method="POST" action="<?php echo e(route('workspaces.removeDocument')); ?>" style="display:inline;">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="workspace_id" value="<?php echo e($workspace->id); ?>">
                                    <input type="hidden" name="cloudfile_id" value="<?php echo e($file->id); ?>">
                                    <button type="submit" class="dark:text-red-200 text-red-600 hover:underline">Delete</button>
                                </form>
                            </div>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-articleBlue">Add documents to this workspace through the documents tab, they'll show up here</p>
                    <?php endif; ?>
                </ul>
            <!-- Notes Section -->
                <div class="mt-12">
                    <!-- Modal Structure -->
                    <div id="noteModal" class="fixed inset-0 bg-viridian bg-opacity-50 flex items-center justify-center z-50 hidden">
                        <div class="bg-articleBlue dark:bg-accentBlue text-viridian dark:text-greenLight w-full max-w-md p-6 rounded shadow-lg relative">
                            <h2 class="text-xl font-semibold mb-4">New Note</h2>

                            <form action="<?php echo e(route('notes.store')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="workspace_id" value="<?php echo e($workspace->id); ?>">
                                <textarea name="content" rows="3" class="w-full border rounded p-2 text-viridian bg-greenLight" placeholder="Start writing note..." required></textarea>
                                <div class="flex justify-end mt-4 space-x-2">
                                    <button type="button" id="closeModalBtn" class="px-4 py-2 bg-accentGreen text-greenLight rounded">Cancel</button>
                                    <?php if (isset($component)) { $__componentOriginald411d1792bd6cc877d687758b753742c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald411d1792bd6cc877d687758b753742c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.primary-button','data' => ['type' => 'submit','class' => 'px-4 py-2 bg-blue-600 text-white rounded']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('primary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','class' => 'px-4 py-2 bg-blue-600 text-white rounded']); ?>Add Note <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $attributes = $__attributesOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__attributesOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $component = $__componentOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__componentOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Notes List -->
                    <h2 class="text-2xl font-bold mb-2">Notes</h2>
                    <?php if($workspace->notes->count()): ?>
                        <ul class="space-y-2">
                            <?php $__currentLoopData = $workspace->notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="bg-articleBlue dark:bg-accentBlue p-3 rounded flex justify-between items-center">
                                    <p class="text-viridian dark:text-greenLight max-w-[32vw] break-words"><?php echo e($note->content); ?></p>
                                    <form action="<?php echo e(route('notes.destroy', $note)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="dark:text-red-200 text-red-600 hover:underline">Delete</button>
                                    </form>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-articleBlue mt-2">Make a new note, it will show up here.</p>
                    <?php endif; ?>
                </div>

                <!-- Links Section -->
                <div class="mt-12">
                    <!-- Modal Structure -->
                    <div id="linkModal" class="fixed inset-0 bg-viridian bg-opacity-50 flex items-center justify-center z-50 hidden">
                        <div class="bg-articleBlue dark:bg-accentBlue text-viridian dark:text-greenLight w-full max-w-md p-6 rounded shadow-lg relative">
                            <h2 class="text-xl font-semibold mb-4">New Link</h2>

                            <form action="<?php echo e(route('links.store')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="workspace_id" value="<?php echo e($workspace->id); ?>">

                                <input type="url" name="url" class="w-full border rounded p-2 mb-2 text-viridian bg-greenLight" placeholder="https://example.com" required>
                                <input type="text" name="label" class="w-full border rounded p-2 text-viridian bg-greenLight" placeholder="Give your link a title">

                                <div class="flex justify-end mt-4 space-x-2">
                                    <button type="button" id="closeLinkModalBtn" class="px-4 py-2 bg-accentGreen text-greenLight rounded">Cancel</button>
                                    <?php if (isset($component)) { $__componentOriginald411d1792bd6cc877d687758b753742c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald411d1792bd6cc877d687758b753742c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.primary-button','data' => ['type' => 'submit','class' => 'px-4 py-2 bg-green-600 text-white rounded']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('primary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','class' => 'px-4 py-2 bg-green-600 text-white rounded']); ?>Add Link <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $attributes = $__attributesOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__attributesOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $component = $__componentOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__componentOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Show Existing Links -->
                    <h2 class="text-2xl font-bold mb-2">Links</h2>
                    <?php if($workspace->links->count()): ?>
                        <ul class="space-y-2">
                            <?php $__currentLoopData = $workspace->links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="p-3 rounded flex justify-between items-center bg-articleBlue dark:bg-accentBlue">
                                    <a href="<?php echo e($link->url); ?>" target="_blank" class="text-viridian dark:text-greenLight hover:underline">
                                        <?php echo e($link->label ?? $link->url); ?>

                                    </a>
                                    <form action="<?php echo e(route('links.destroy', $link)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="dark:text-red-200 text-red-600 hover:underline">Delete</button>
                                    </form>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-articleBlue mt-2">Add a new link, it will show up here.</p>
                    <?php endif; ?>
                </div>
                <div class="fixed bottom-6 right-6 z-50" id="fabContainer">
                    <div id="fabMenu" class="hidden mb-2 space-y-2 text-left flex flex-col bg-accentGreen rounded">
                        <button id="fabAddNote" class="px-4 py-2 text-greenLight rounded hover:bg-accentBlue">Add Note</button>
                        <button id="fabAddLink" class="px-4 py-2 text-greenLight rounded hover:bg-accentBlue">Add Link</button>
                    </div>

                    <button id="fabToggle" class="w-14 h-14 rounded-full bg-accentGreen text-greenLight text-3xl shadow-lg flex items-center align-middle justify-center hover:bg-accentBlue">
                        +
                    </button>
                </div>
            </div>

            <!-- Calendar items -->
            <div class="ml-8">
                <h2 class="text-2xl font-bold mb-2">Events</h2>
                <?php if($events->count()): ?>
                    <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                        <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="bg-articleBlue dark:bg-accentBlue text-viridian dark:text-greenLight p-3 rounded flex flex-col items-center max-w-[12vw]">
                                <div class="text-2xl font-bold pb-1">
                                    <?php echo e(\Carbon\Carbon::parse($event->date)->format('F')); ?>

                                </div>
                                <div class="text-5xl pb-2">
                                    <?php echo e(\Carbon\Carbon::parse($event->date)->format('j')); ?>

                                </div>
                                <div>
                                    <?php echo e($event->event); ?>

                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php else: ?>
                    <p class="text-gray-500 mt-2">Link events to the workspace through the calendar, they'll show up here.</p>
                <?php endif; ?>
            </div>

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
        const openBtn = document.getElementById('openModalBtn');
        const modal = document.getElementById('noteModal');
        const closeBtn = document.getElementById('closeModalBtn');

        // Open modal
        openBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });

        // Close modal
        closeBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        // Close modal when clicking outside the modal content
        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        const openLinkBtn = document.getElementById('openLinkModalBtn');
        const linkModal = document.getElementById('linkModal');
        const closeLinkBtn = document.getElementById('closeLinkModalBtn');

        // Open Link Modal
        openLinkBtn.addEventListener('click', () => {
            linkModal.classList.remove('hidden');
        });

        // Close Link Modal
        closeLinkBtn.addEventListener('click', () => {
            linkModal.classList.add('hidden');
        });

        // Close when clicking outside the modal box
        window.addEventListener('click', (e) => {
            if (e.target === linkModal) {
                linkModal.classList.add('hidden');
            }
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        // Existing modal logic...

        // Floating Action Button (FAB) Logic
        const fabToggle = document.getElementById('fabToggle');
        const fabMenu = document.getElementById('fabMenu');
        const fabAddNote = document.getElementById('fabAddNote');
        const fabAddLink = document.getElementById('fabAddLink');

        // Toggle the dropdown menu
        fabToggle.addEventListener('click', () => {
            fabMenu.classList.toggle('hidden');
        });

        // Click "Add Note" from FAB
        fabAddNote.addEventListener('click', () => {
            document.getElementById('noteModal').classList.remove('hidden');
            fabMenu.classList.add('hidden');
        });

        // Click "Add Link" from FAB
        fabAddLink.addEventListener('click', () => {
            document.getElementById('linkModal').classList.remove('hidden');
            fabMenu.classList.add('hidden');
        });

        // Optional: Hide menu when clicking anywhere else
        document.addEventListener('click', function (event) {
            if (!document.getElementById('fabContainer').contains(event.target)) {
                fabMenu.classList.add('hidden');
            }
        });
    });
</script>
<?php /**PATH C:\Users\Senna\CMGT Jaar 2\TLE2_Startup\resources\views/workspaces/show.blade.php ENDPATH**/ ?>