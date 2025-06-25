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
    <h1><?php echo e($workspace->name); ?></h1>
    <p>Dit is de detailpagina voor workspace "<?php echo e($workspace->name); ?>"</p>
    <p>Hier kan je in de toekomst verder informatie specifiek per workspace invullen (zie vieuws/workspaces/show.blade.php)</p>

    <a href="<?php echo e(route('workspaces.index')); ?>">Terug naar overzicht</a>

    <!-- Notes Section -->
    <div class="mt-8">
        <h2 class="text-xl font-semibold mb-2">Notities</h2>

        <!-- Add Note Form -->
        <form action="<?php echo e(route('notes.store')); ?>" method="POST" class="mb-4">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="workspace_id" value="<?php echo e($workspace->id); ?>">
            <textarea name="content" rows="3" class="w-full border rounded p-2" placeholder="Schrijf een notitie..." required></textarea>
            <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded">Notitie toevoegen</button>
        </form>

        <!-- Notes List -->
        <?php if($workspace->notes->count()): ?>
            <ul class="space-y-2">
                <?php $__currentLoopData = $workspace->notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="border p-3 rounded flex justify-between items-center">
                        <span><?php echo e($note->content); ?></span>
                        <form action="<?php echo e(route('notes.destroy', $note)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-red-600 hover:underline">Verwijder</button>
                        </form>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php else: ?>
            <p class="text-gray-500 mt-2">Er zijn nog geen notities voor deze workspace.</p>
        <?php endif; ?>
    </div>

    <!-- Links Section -->
    <div class="mt-12">
        <h2 class="text-xl font-semibold mb-2">Links</h2>

        <!-- Add Link Form -->
        <form action="<?php echo e(route('links.store')); ?>" method="POST" class="mb-4">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="workspace_id" value="<?php echo e($workspace->id); ?>">

            <input type="url" name="url" class="w-full border rounded p-2 mb-2" placeholder="https://voorbeeld.com" required>
            <input type="text" name="label" class="w-full border rounded p-2" placeholder="Optionele naam (bv. Google Docs)">

            <button type="submit" class="mt-2 px-4 py-2 bg-green-600 text-white rounded">Link toevoegen</button>
        </form>

        <!-- Show Existing Links -->
        <?php if($workspace->links->count()): ?>
            <ul class="space-y-2">
                <?php $__currentLoopData = $workspace->links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="border p-3 rounded flex justify-between items-center">
                        <a href="<?php echo e($link->url); ?>" target="_blank" class="text-blue-600 hover:underline">
                            <?php echo e($link->label ?? $link->url); ?>

                        </a>
                        <form action="<?php echo e(route('links.destroy', $link)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-red-600 hover:underline">Verwijder</button>
                        </form>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php else: ?>
            <p class="text-gray-500 mt-2">Er zijn nog geen links voor deze workspace.</p>
        <?php endif; ?>

        <!-- Calendar items -->
        <h2 class="text-xl font-semibold mb-2">Events</h2>
        <?php if($events->count()): ?>
            <ul class="space-y-2">
                <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="border p-3 rounded flex justify-between items-center">
                        <?php echo e($event->event); ?> on <?php echo e($event->date); ?>

                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php else: ?>
            <p class="text-gray-500 mt-2">Er zijn nog geen events voor deze workspace.</p>
        <?php endif; ?>
    </div>

    <ul>
        <?php $__currentLoopData = $workspace->cloudFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <a href="<?php echo e($file->web_view_link); ?>" target="_blank"><?php echo e($file->name); ?></a>
                <form method="POST" action="<?php echo e(route('workspaces.removeDocument')); ?>" style="display:inline;">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="workspace_id" value="<?php echo e($workspace->id); ?>">
                    <input type="hidden" name="cloudfile_id" value="<?php echo e($file->id); ?>">
                    <button type="submit" class="text-red-500 hover:text-red-700">Remove</button>
                </form>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
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
<?php /**PATH C:\CMGT\Jaar_2\TLE2_Startup\resources\views/workspaces/show.blade.php ENDPATH**/ ?>