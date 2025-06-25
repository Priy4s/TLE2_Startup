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
    <div class="flex flex-col items-center justify-center min-h-screen">
    <div class="flex gap-12 items-center bg-accentBlue p-10 rounded-xl shadow-2xl customizer">
        <!-- De Kikker Visual -->
        <div id="kikker-container" class="relative w-72 h-72">
            <img id="base-kikker" src="<?php echo e(asset('cosmetics/lefrog.png')); ?>" alt="Le Frog" class="absolute top-0 left-0 w-full h-full object-contain">
            <img id="lower-layer" src="" alt="" class="absolute top-0 left-0 w-full h-full object-contain">
            <img id="upper-layer" src="" alt="" class="absolute top-0 left-0 w-full h-full object-contain">
        </div>

        <!-- De Knoppen -->
        <div class="flex flex-col gap-5 controls">
            <!-- Upper Body Controls -->
            <div class="flex items-center gap-4 control-group">
                <h3 class="m-0 w-20 text-white font-semibold">Upper</h3>
                <div class="arrow-btn flex items-center justify-center w-10 h-10 rounded-full border border-gray-300 text-2xl cursor-pointer select-none hover:bg-gray-200 bg-white text-gray-800" data-category="upper" data-direction="-1">&lt;</div>
                <span id="upper-name" class="item-name font-bold w-36 text-center text-white">None</span>
                <div class="arrow-btn flex items-center justify-center w-10 h-10 rounded-full border border-gray-300 text-2xl cursor-pointer select-none hover:bg-gray-200 bg-white text-gray-800" data-category="upper" data-direction="1">&gt;</div>
            </div>
            <!-- Lower Body Controls -->
            <div class="flex items-center gap-4 control-group">
                <h3 class="m-0 w-20 text-white font-semibold">Lower</h3>
                <div class="arrow-btn flex items-center justify-center w-10 h-10 rounded-full border border-gray-300 text-2xl cursor-pointer select-none hover:bg-gray-200 bg-white text-gray-800" data-category="lower" data-direction="-1">&lt;</div>
                <span id="lower-name" class="item-name font-bold w-36 text-center text-white">None</span>
                <div class="arrow-btn flex items-center justify-center w-10 h-10 rounded-full border border-gray-300 text-2xl cursor-pointer select-none hover:bg-gray-200 bg-white text-gray-800" data-category="lower" data-direction="1">&gt;</div>
            </div>
            <!-- Color Controls -->
            <div class="flex items-center gap-4 control-group">
                <h3 class="m-0 w-20 text-white font-semibold">Color</h3>
                <div class="arrow-btn flex items-center justify-center w-10 h-10 rounded-full border border-gray-300 text-2xl cursor-pointer select-none hover:bg-gray-200 bg-white text-gray-800" data-category="color" data-direction="-1">&lt;</div>
                <span id="color-name" class="item-name font-bold w-36 text-center text-white">None</span>
                <div class="arrow-btn flex items-center justify-center w-10 h-10 rounded-full border border-gray-300 text-2xl cursor-pointer select-none hover:bg-gray-200 bg-white text-gray-800" data-category="color" data-direction="1">&gt;</div>
            </div>
            <p><a href="<?php echo e(route('lootbox.index')); ?>" class="bg-viridian text-greenLight px-4 py-2 rounded m-4">Open your daily lootbox!</a></p>
        </div>
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userCosmetics = <?php echo json_encode($cosmetics, 15, 512) ?>;

            const inventory = {
                upper: [{name: 'None', image_path: ''}, ...(userCosmetics.upper || [])],
                lower: [{name: 'None', image_path: ''}, ...(userCosmetics.lower || [])],
                color: [{name: 'None', image_path: ''}, ...(userCosmetics.color || [])]
            };

            const currentIndexes = { upper: 0, lower: 0, color: 0 };

            const baseKikker = document.getElementById('base-kikker');
            const layers = {
                upper: document.getElementById('upper-layer'),
                lower: document.getElementById('lower-layer')
            };
            const names = {
                upper: document.getElementById('upper-name'),
                lower: document.getElementById('lower-name'),
                color: document.getElementById('color-name')
            };

            function updateDisplay(category) {
                const currentIndex = currentIndexes[category];
                const currentItem = inventory[category][currentIndex];
                names[category].textContent = currentItem.name;
                if (category === 'color') {
                    if (currentItem.image_path) {
                        baseKikker.src = `<?php echo e(asset('cosmetics/')); ?>/${currentItem.image_path}`;
                    } else {
                        baseKikker.src = `<?php echo e(asset('cosmetics/lefrog.png')); ?>`;
                    }
                } else {
                    if (currentItem.image_path) {
                        layers[category].src = `<?php echo e(asset('cosmetics/')); ?>/${currentItem.image_path}`;
                        layers[category].style.display = '';
                    } else {
                        layers[category].src = '';
                        layers[category].style.display = 'none';
                    }
                }
            }

            document.querySelectorAll('.arrow-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const category = button.dataset.category;
                    const direction = parseInt(button.dataset.direction);
                    const maxIndex = inventory[category].length - 1;
                    currentIndexes[category] += direction;
                    if (currentIndexes[category] > maxIndex) {
                        currentIndexes[category] = 0;
                    } else if (currentIndexes[category] < 0) {
                        currentIndexes[category] = maxIndex;
                    }
                    updateDisplay(category);
                });
            });

            updateDisplay('upper');
            updateDisplay('lower');
            updateDisplay('color');
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
<?php endif; ?><?php /**PATH C:\CMGT\Jaar_2\TLE2_Startup\resources\views/kikkerman.blade.php ENDPATH**/ ?>