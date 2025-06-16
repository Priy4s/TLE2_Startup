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

<div class="container mx-auto mt-10">
    <div class="wrapper bg-white rounded shadow w-full ">
        <div class="header flex justify-between border-b p-2">
        <span class="text-lg font-bold">
          <?php echo e(now()->format('F Y')); ?>

        </span>
            <div class="buttons">
                <button class="p-1">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-left-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path fill-rule="evenodd" d="M8.354 11.354a.5.5 0 0 0 0-.708L5.707 8l2.647-2.646a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708 0z"/>
                        <path fill-rule="evenodd" d="M11.5 8a.5.5 0 0 0-.5-.5H6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 .5-.5z"/>
                    </svg>
                </button>
                <button class="p-1">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path fill-rule="evenodd" d="M7.646 11.354a.5.5 0 0 1 0-.708L10.293 8 7.646 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0z"/>
                        <path fill-rule="evenodd" d="M4.5 8a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5z"/>
                    </svg>
                </button>
            </div>
        </div>
        <table class="w-full">
            <thead>
            <tr>
                <th class="p-2 border-r h-10 xl:w-40 lg:w-30 md:w-30 sm:w-20 w-10 xl:text-sm text-xs">
                    <span class="xl:block lg:block md:block sm:block hidden">Sunday</span>
                    <span class="xl:hidden lg:hidden md:hidden sm:hidden block">Sun</span>
                </th>
                <th class="p-2 border-r h-10 xl:w-40 lg:w-30 md:w-30 sm:w-20 w-10 xl:text-sm text-xs">
                    <span class="xl:block lg:block md:block sm:block hidden">Monday</span>
                    <span class="xl:hidden lg:hidden md:hidden sm:hidden block">Mon</span>
                </th>
                <th class="p-2 border-r h-10 xl:w-40 lg:w-30 md:w-30 sm:w-20 w-10 xl:text-sm text-xs">
                    <span class="xl:block lg:block md:block sm:block hidden">Tuesday</span>
                    <span class="xl:hidden lg:hidden md:hidden sm:hidden block">Tue</span>
                </th>
                <th class="p-2 border-r h-10 xl:w-40 lg:w-30 md:w-30 sm:w-20 w-10 xl:text-sm text-xs">
                    <span class="xl:block lg:block md:block sm:block hidden">Wednesday</span>
                    <span class="xl:hidden lg:hidden md:hidden sm:hidden block">Wed</span>
                </th>
                <th class="p-2 border-r h-10 xl:w-40 lg:w-30 md:w-30 sm:w-20 w-10 xl:text-sm text-xs">
                    <span class="xl:block lg:block md:block sm:block hidden">Thursday</span>
                    <span class="xl:hidden lg:hidden md:hidden sm:hidden block">Thu</span>
                </th>
                <th class="p-2 border-r h-10 xl:w-40 lg:w-30 md:w-30 sm:w-20 w-10 xl:text-sm text-xs">
                    <span class="xl:block lg:block md:block sm:block hidden">Friday</span>
                    <span class="xl:hidden lg:hidden md:hidden sm:hidden block">Fri</span>
                </th>
                <th class="p-2 border-r h-10 xl:w-40 lg:w-30 md:w-30 sm:w-20 w-10 xl:text-sm text-xs">
                    <span class="xl:block lg:block md:block sm:block hidden">Saturday</span>
                    <span class="xl:hidden lg:hidden md:hidden sm:hidden block">Sat</span>
                </th>
            </tr>
            </thead>
            <?php
                $daysInMonth = now()->daysInMonth;
                $firstDayOfMonth = now()->startOfMonth()->dayOfWeek; // 0 = Sunday, 1 = Monday, etc.
            ?>

            <tbody>
            <?php for($week = 0; $week < ceil(($daysInMonth + $firstDayOfMonth) / 7); $week++): ?>
                <tr class="text-center h-20">
                    <?php for($day = 0; $day < 7; $day++): ?>
                        <?php
                            $currentDay = $week * 7 + $day - $firstDayOfMonth + 1;
                            $currentDate = ($currentDay > 0 && $currentDay <= $daysInMonth)
                                ? now()->startOfMonth()->addDays($currentDay - 1)->toDateString()
                                : null;
                        ?>

                        <td class="border p-1 h-40 xl:w-40 lg:w-30 md:w-30 sm:w-20 w-10 overflow-auto transition cursor-pointer duration-500 ease hover:bg-gray-300">
                            <?php if($currentDay > 0 && $currentDay <= $daysInMonth): ?>
                                <div class="flex flex-col h-40 mx-auto xl:w-40 lg:w-30 md:w-30 sm:w-full w-10 mx-auto overflow-hidden">
                                    <div class="top h-5 w-full">
                                        <span class="text-gray-500"><?php echo e($currentDay); ?></span>
                                    </div>
                                    <div class="bottom flex-grow h-30 py-1 w-full cursor-pointer">
                                        <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($event->date == $currentDate): ?>
                                                <div class="event bg-purple-400 text-white rounded p-1 text-sm mb-1">
                                                    <span class="event-name"><?php echo e($event->event); ?></span>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </td>
                    <?php endfor; ?>
                </tr>
            <?php endfor; ?>
            </tbody>
        </table>
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
<?php endif; ?><?php /**PATH C:\CMGT\Jaar_2\TLE2_Startup\resources\views/calendar/index.blade.php ENDPATH**/ ?>