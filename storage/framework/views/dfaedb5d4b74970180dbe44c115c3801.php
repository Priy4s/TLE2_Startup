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

    <button id="openModal2" class="bg-accentBlue text-white px-4 py-2 rounded m-4">
        Add Event
    </button>

<?php
    // Use passed month/year or default to current
    $month = $currentMonth ?? now()->month;
    $year = $currentYear ?? now()->year;
    $carbonDate = \Carbon\Carbon::create($year, $month, 1);

    $daysInMonth = $carbonDate->daysInMonth;
    $firstDayOfMonth = $carbonDate->copy()->startOfMonth()->dayOfWeek;

    // For navigation
    $prev = $carbonDate->copy()->subMonth();
    $next = $carbonDate->copy()->addMonth();
?>

<div class="container mx-auto">
    <div class="wrapper rounded shadow w-full">
        <div class="header flex justify-between border-b border-accentBlue p-2">
        <span class="text-lg font-bold">
          <?php echo e($carbonDate->format('F Y')); ?>

        </span>
            <div class="buttons">
                <a href="<?php echo e(route('calendar.index', ['month' => $prev->month, 'year' => $prev->year])); ?>" class="p-1">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-left-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path fill-rule="evenodd" d="M8.354 11.354a.5.5 0 0 0 0-.708L5.707 8l2.647-2.646a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708 0z"/>
                        <path fill-rule="evenodd" d="M11.5 8a.5.5 0 0 0-.5-.5H6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 .5-.5z"/>
                    </svg>
                </a>
                <a href="<?php echo e(route('calendar.index', ['month' => $next->month, 'year' => $next->year])); ?>" class="p-1">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path fill-rule="evenodd" d="M7.646 11.354a.5.5 0 0 1 0-.708L10.293 8 7.646 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0z"/>
                        <path fill-rule="evenodd" d="M4.5 8a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5z"/>
                    </svg>
                </a>
            </div>
        </div>
        <table class="w-full">
            <thead>
            <tr>
                <th class="p-2 border-r border-l border-accentBlue h-10 xl:w-40 lg:w-30 md:w-30 sm:w-20 w-10 xl:text-sm text-xs">
                    <span class="xl:block lg:block md:block sm:block hidden">Sunday</span>
                    <span class="xl:hidden lg:hidden md:hidden sm:hidden block">Sun</span>
                </th>
                <th class="p-2 border-r border-accentBlue h-10 xl:w-40 lg:w-30 md:w-30 sm:w-20 w-10 xl:text-sm text-xs">
                    <span class="xl:block lg:block md:block sm:block hidden">Monday</span>
                    <span class="xl:hidden lg:hidden md:hidden sm:hidden block">Mon</span>
                </th>
                <th class="p-2 border-r border-accentBlue h-10 xl:w-40 lg:w-30 md:w-30 sm:w-20 w-10 xl:text-sm text-xs">
                    <span class="xl:block lg:block md:block sm:block hidden">Tuesday</span>
                    <span class="xl:hidden lg:hidden md:hidden sm:hidden block">Tue</span>
                </th>
                <th class="p-2 border-r border-accentBlue h-10 xl:w-40 lg:w-30 md:w-30 sm:w-20 w-10 xl:text-sm text-xs">
                    <span class="xl:block lg:block md:block sm:block hidden">Wednesday</span>
                    <span class="xl:hidden lg:hidden md:hidden sm:hidden block">Wed</span>
                </th>
                <th class="p-2 border-r border-accentBlue h-10 xl:w-40 lg:w-30 md:w-30 sm:w-20 w-10 xl:text-sm text-xs">
                    <span class="xl:block lg:block md:block sm:block hidden">Thursday</span>
                    <span class="xl:hidden lg:hidden md:hidden sm:hidden block">Thu</span>
                </th>
                <th class="p-2 border-r border-accentBlue h-10 xl:w-40 lg:w-30 md:w-30 sm:w-20 w-10 xl:text-sm text-xs">
                    <span class="xl:block lg:block md:block sm:block hidden">Friday</span>
                    <span class="xl:hidden lg:hidden md:hidden sm:hidden block">Fri</span>
                </th>
                <th class="p-2 border-r border-accentBlue h-10 xl:w-40 lg:w-30 md:w-30 sm:w-20 w-10 xl:text-sm text-xs">
                    <span class="xl:block lg:block md:block sm:block hidden">Saturday</span>
                    <span class="xl:hidden lg:hidden md:hidden sm:hidden block">Sat</span>
                </th>
            </tr>
            </thead>
            <?php
                // $daysInMonth, $firstDayOfMonth already set above
            ?>

            <tbody>
            <?php for($week = 0; $week < ceil(($daysInMonth + $firstDayOfMonth) / 7); $week++): ?>
                <tr class="text-center h-20">
                    <?php for($day = 0; $day < 7; $day++): ?>
                        <?php
                            $currentDay = $week * 7 + $day - $firstDayOfMonth + 1;
                            $currentDate = ($currentDay > 0 && $currentDay <= $daysInMonth)
                                ? $carbonDate->copy()->startOfMonth()->addDays($currentDay - 1)->toDateString()
                                : null;
                        ?>

                        <td class="border border-accentBlue p-1 h-40 xl:w-40 lg:w-30 md:w-30 sm:w-20 w-10 overflow-auto">
                            <?php if($currentDay > 0 && $currentDay <= $daysInMonth): ?>
                                <div class="flex flex-col h-40 mx-auto xl:w-40 lg:w-30 md:w-30 sm:w-full w-10 mx-auto overflow-hidden">
                                    <div class="top h-5 w-full">
                                        <span class="text-gray-500"><?php echo e($currentDay); ?></span>
                                    </div>
                                    <div class="bottom flex-grow h-30 py-1 w-full cursor-pointer">
                                        <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $eventDate = \Carbon\Carbon::parse($event->date);
                                            ?>
                                            <?php if($eventDate->format('Y-m-d') == $currentDate): ?>
                                                <div
                                                        class="event bg-accentBlue text-white rounded p-1 text-sm mb-1 cursor-pointer"
                                                        data-event="<?php echo e($event->event); ?>"
                                                        data-date="<?php echo e($eventDate->format('Y-m-d H:i')); ?>"
                                                        data-id="<?php echo e($event->id); ?>"
                                                        onclick="showEventModal(this)"
                                                >
                                                        <span class="event-name">
                                                            <?php echo e($event->event); ?>

                                                            <span class="event-time text-xs text-gray-200 ml-1"><?php echo e($eventDate->format('H:i')); ?></span>
                                                        </span>
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


    <div id="modalOverlay2" class="fixed inset-0 bg-greenLight dark:bg-viridian dark:bg-opacity-50 bg-opacity-50 hidden z-40"></div>
    <div id="modal2" class="fixed inset-0 flex items-center justify-center hidden z-50">
        <div class="relative bg-articleBlue dark:bg-accentBlue p-6 rounded shadow-lg w-full max-w-md z-10">
            <button id="closeModal2" class="absolute top-2 right-2 text-viridian hover:text-gray-800 text-xl">&times;</button>

            <form method="POST" action="<?php echo e(route('calendar.store')); ?>">
                <?php echo csrf_field(); ?>
                <h1 class="text-xl font-bold">New Event</h1>
                <label for="name" class="block mt-2 text-sm font-medium text-viridian dark:text-greenLight mb-2">Name</label>
                <input
                        type="text"
                        id="event"
                        name="event"
                        required
                        class="w-full px-4 py-2 border rounded border-gray-300 dark:border-gray-600 bg-greenLight text-viridian dark:bg-articleBlue dark:text-viridian focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                <label for="event_datetime" class="block mt-2 text-sm font-medium text-viridian dark:text-greenLight mb-2">Date & Time</label>
                <input
                        type="datetime-local"
                        id="date"
                        name="date"
                        required
                        class="w-full px-4 py-2 border rounded border-gray-300 dark:border-gray-600 bg-greenLight text-viridian dark:bg-articleBlue dark:text-viridian focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
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

    <!-- Event details modal -->
    <div id="eventModal" class="fixed inset-0 flex items-center justify-center hidden z-50">
        <div class="relative bg-white dark:bg-accentBlue p-6 rounded shadow-lg w-full max-w-md z-10">
            <button id="closeEventModal" class="absolute top-2 right-2 text-viridian hover:text-gray-800 text-xl">&times;</button>
            <h1 class="text-xl font-bold" id="modalEventName"></h1>
            <p class="mt-2 text-gray-700 dark:text-greenLight" id="modalEventDate"></p>
            <div class="flex justify-end gap-2 mt-4">
                <a id="editEventBtn" href="#" class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</a>
                <form id="deleteEventForm" method="POST" action="" onsubmit="return confirm('Delete this event?');">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Delete</button>
                </form>
            </div>
        </div>
        <div id="eventModalOverlay" class="fixed inset-0 bg-black bg-opacity-30"></div>
    </div>

    <script>
        function showEventModal(el) {
            document.getElementById('modalEventName').textContent = el.dataset.event;
            document.getElementById('modalEventDate').textContent = el.dataset.date;
            const eventId = el.dataset.id;
            document.getElementById('editEventBtn').href = `/calendar/${eventId}/edit`;
            document.getElementById('deleteEventForm').action = `/calendar/${eventId}`;
            document.getElementById('eventModal').classList.remove('hidden');
        }
        document.getElementById('closeEventModal').onclick = function() {
            document.getElementById('eventModal').classList.add('hidden');
        };
        document.getElementById('eventModalOverlay').onclick = function() {
            document.getElementById('eventModal').classList.add('hidden');
        };
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
<?php endif; ?><?php /**PATH C:\CMGT\Jaar_2\TLE2_Startup\resources\views/calendar/index.blade.php ENDPATH**/ ?>