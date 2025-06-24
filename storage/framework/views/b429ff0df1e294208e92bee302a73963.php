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
    <h1 class="text-6xl font-bold">Edit Event</h1>


            <form method="POST" action="<?php echo e(route('calendar.update', $event->id)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <label for="event" class="block mt-2 text-sm font-medium text-viridian dark:text-greenLight mb-2">Name</label>
                <input
                    type="text"
                    id="event"
                    name="event"
                    value="<?php echo e(old('event', $event->event)); ?>"
                    required
                    class="w-full px-4 py-2 border rounded border-gray-300 dark:border-gray-600 bg-greenLight text-viridian dark:bg-articleBlue dark:text-viridian focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                <label for="date" class="block mt-2 text-sm font-medium text-viridian dark:text-greenLight mb-2">Date & Time</label>
                <input
                    type="datetime-local"
                    id="date"
                    name="date"
                    value="<?php echo e(old('date', \Carbon\Carbon::parse($event->date)->format('Y-m-d\TH:i'))); ?>"
                    required
                    class="w-full px-4 py-2 border rounded border-gray-300 dark:border-gray-600 bg-greenLight text-viridian dark:bg-articleBlue dark:text-viridian focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                <div class="flex justify-end gap-2 mt-6">
                    <a href="<?php echo e(route('calendar.index')); ?>" class="bg-gray-400 text-white px-4 py-2 rounded">Cancel</a>
                    <button type="submit" class="bg-accentBlue text-white px-4 py-2 rounded">Update</button>
                </div>
            </form>


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


<?php /**PATH C:\CMGT\Jaar_2\TLE2_Startup\resources\views/calendar/edit.blade.php ENDPATH**/ ?>