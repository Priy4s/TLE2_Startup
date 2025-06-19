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
    <div class="min-h-full flex flex-col justify-between">
        <div>
            <h1 class="text-6xl font-bold">Workspaces</h1>
            <ul class="mt-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-[2vw]">
                <?php $__currentLoopData = $workspaces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workspace): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="bg-articleBlue dark:bg-accentBlue p-4 rounded shadow relative w-[18vw]">
                        <div class="flex justify-between items-center">
                            <a href="<?php echo e(route('workspaces.show', $workspace)); ?>" class="block font-bold dark:text-greenLight">
                                <?php echo e($workspace->name); ?>

                            </a>

                            <button class="menu-toggle" data-id="menu-<?php echo e($workspace->id); ?>">
                                <img src="<?php echo e(asset('images/dots.png')); ?>" alt="menu" class="h-4 w-auto hidden dark:block">
                                <img src="<?php echo e(asset('images/dotsLight.png')); ?>" alt="menu" class="h-4 w-auto block dark:hidden">
                            </button>
                        </div>

                        <div id="menu-<?php echo e($workspace->id); ?>" class="dropdown-menu hidden absolute right-8 top-2 bg-articleBlue dark:bg-accentBlue border border-viridian rounded shadow z-10 min-w-32 p-2">
                            <button onclick="openModal('<?php echo e($workspace->id); ?>')" class="block w-full text-left text-sm text-viridian dark:text-greenLight hover:bg-accentGreen p-1 rounded">Rename</button>
                            <form method="POST" action="<?php echo e(route('workspaces.destroy', $workspace)); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="block w-full text-left text-sm text-viridian dark:text-greenLight hover:bg-accentGreen p-1 rounded">
                                    Delete Workspace
                                </button>
                            </form>
                        </div>

                        <div id="modal-<?php echo e($workspace->id); ?>" class="fixed inset-0 flex items-center justify-center hidden z-50">
                            <div class="absolute inset-0 bg-greenLight dark:bg-viridian bg-opacity-50 dark:bg-opacity-50" onclick="closeModal('<?php echo e($workspace->id); ?>')"></div>
                            <div class="relative bg-articleBlue dark:bg-accentBlue p-6 rounded shadow-lg w-full max-w-md z-10">
                                <button class="absolute top-2 right-2 text-viridian hover:text-accentGreen text-xl" onclick="closeModal('<?php echo e($workspace->id); ?>')">&times;</button>
                                <h1 class="text-xl font-bold">Edit Workspace Name</h1>
                                <form method="POST" action="<?php echo e(route('workspaces.update', $workspace)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <label for="name-<?php echo e($workspace->id); ?>" class="block mt-2 text-sm font-medium text-viridian dark:text-greenLight mb-2">
                                        New Name
                                    </label>
                                    <input type="text" id="name-<?php echo e($workspace->id); ?>" name="name" value="<?php echo e($workspace->name); ?>" required
                                            class="w-full px-4 py-2 border rounded border-gray-300 bg-greenLight text-viridian dark:border-gray-600 dark:bg-articleBlue dark:text-viridian focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    >
                                    <?php if (isset($component)) { $__componentOriginald411d1792bd6cc877d687758b753742c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald411d1792bd6cc877d687758b753742c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.primary-button','data' => ['type' => 'submit','class' => 'mt-4 px-4 py-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('primary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','class' => 'mt-4 px-4 py-2']); ?>
                                        Rename
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $attributes = $__attributesOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__attributesOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $component = $__componentOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__componentOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
                                </form>
                            </div>
                        </div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <p id="openModal2" class="underline text-lg text-accentBlue dark:text-articleBlue hover:text-viridian dark:hover:text-accentGreen rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 cursor-pointer">Nieuwe workspace maken</p>
    </div>

<!--START MODAL CODES-->
    <div id="modalOverlay2" class="fixed inset-0 bg-greenLight dark:bg-viridian dark:bg-opacity-50 bg-opacity-50 hidden z-40"></div>
    <div id="modal2" class="fixed inset-0 flex items-center justify-center hidden z-50">
        <div class="relative bg-articleBlue dark:bg-accentBlue p-6 rounded shadow-lg w-full max-w-md z-10">
            <button id="closeModal2" class="absolute top-2 right-2 text-viridian hover:text-gray-800 text-xl">&times;</button>

            <form method="POST" action="<?php echo e(route('workspaces.store')); ?>">
                <?php echo csrf_field(); ?>
                <h1 class="text-xl font-bold">New Workspace</h1>
                <label for="name" class="block mt-2 text-sm font-medium text-viridian dark:text-greenLight mb-2">Name</label>
                <input
                        type="text"
                        id="name"
                        name="name"
                        required
                        class="w-full px-4 py-2 border rounded border-gray-300 dark:border-gray-600 bg-greenLight text-viridian dark:bg-articleBlue dark:text-viridian focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <?php if (isset($component)) { $__componentOriginald411d1792bd6cc877d687758b753742c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald411d1792bd6cc877d687758b753742c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.primary-button','data' => ['type' => 'submit','class' => 'mt-4 px-4 py-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('primary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','class' => 'mt-4 px-4 py-2']); ?>
                    Submit
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $attributes = $__attributesOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__attributesOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $component = $__componentOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__componentOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.addEventListener('click', function (e) {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    if (!menu.contains(e.target) && !menu.previousElementSibling.contains(e.target)) {
                        menu.classList.add('hidden');
                    }
                });
            });

            document.querySelectorAll('.menu-toggle').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.stopPropagation(); // prevent body click from closing it
                    const menuId = this.getAttribute('data-id');
                    const menu = document.getElementById(menuId);
                    // Hide all other menus
                    document.querySelectorAll('.dropdown-menu').forEach(m => {
                        if (m !== menu) m.classList.add('hidden');
                    });
                    // Toggle current
                    menu.classList.toggle('hidden');
                });
            });
        });
        function openModal(id) {
            document.getElementById(`modal-${id}`).classList.remove('hidden');
        }
        function closeModal(id) {
            document.getElementById(`modal-${id}`).classList.add('hidden');
        }
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('modal2');
            const overlay = document.getElementById('modalOverlay2');
            const openBtn = document.getElementById('openModal2');
            const closeBtn = document.getElementById('closeModal2');

            function openModal2() {
                modal.classList.remove('hidden');
                overlay.classList.remove('hidden');
            }

            function closeModal2() {
                modal.classList.add('hidden');
                overlay.classList.add('hidden');
            }

            openBtn.addEventListener('click', openModal2);
            closeBtn.addEventListener('click', closeModal2);
            overlay.addEventListener('click', closeModal2);
        });
    </script>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalff09156f73c896030ee75284e9b2c466)): ?>
<?php $attributes = $__attributesOriginalff09156f73c896030ee75284e9b2c466; ?>
<?php unset($__attributesOriginalff09156f73c896030ee75284e9b2c466); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalff09156f73c896030ee75284e9b2c466)): ?>
<?php $component = $__componentOriginalff09156f73c896030ee75284e9b2c466; ?>
<?php unset($__componentOriginalff09156f73c896030ee75284e9b2c466); ?>
<?php endif; ?><?php /**PATH C:\Users\Senna\CMGT Jaar 2\TLE2_Startup\resources\views/workspaces/index.blade.php ENDPATH**/ ?>