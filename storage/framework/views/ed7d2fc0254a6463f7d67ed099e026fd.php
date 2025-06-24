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
    <h1 class="text-6xl font-bold">Profile</h1>
    <div class="flex max-w-[78vw]">
        <div>
            <?php echo $__env->make('profile.partials.update-profile-information-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php echo $__env->make('profile.partials.delete-user-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
        <div class="pl-[5vw] mt-10">
            <h2 class="text-xl font-medium text-viridian dark:text-greenLight">Connect with Google/Microsoft</h2>
            <div class="mt-4 flex items-center">
                <?php if(auth()->user()->google_refresh_token): ?>
                    <div class="flex items-center space-x-4">
                        <span class="text-accentGreen">
                            <i class="fas fa-check-circle mr-2"></i>Google Connected
                        </span>
                        <!-- Disconnect Button -->
                        <form method="POST" action="<?php echo e(route('google.disconnect')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="px-3 py-1 text-sm text-red-600 hover:underline rounded">
                                Disconnect
                            </button>
                        </form>
                    </div>
                <?php else: ?>
                    <!-- Connect Button -->
                    <a href="<?php echo e(route('google.login')); ?>"
                       class="px-4 py-2 bg-articleBlue text-viridian dark:bg-accentBlue dark:text-greenLight rounded-md hover:text-accentBlue dark:hover:text-articleBlue">
                        <i class="fab fa-google-drive mr-2"></i>Connect Google Drive
                    </a>
                <?php endif; ?>
            </div>
            <div class="mt-4 flex items-center">
                <?php if(auth()->user()->microsoft_refresh_token): ?>
                    <div class="flex items-center space-x-4">
                        <span class="text-accentGreen">
                            <i class="fab fa-microsoft mr-2"></i>Microsoft Connected
                        </span>
                        <form method="POST" action="<?php echo e(route('microsoft.disconnect')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="px-3 py-1 text-sm text-red-600 hover:underline rounded">
                                Disconnect
                            </button>
                        </form>
                    </div>
                <?php else: ?>
                    <a href="<?php echo e(route('microsoft.login')); ?>"
                       class="px-4 py-2 bg-articleBlue text-viridian dark:bg-accentBlue dark:text-greenLight rounded-md hover:text-accentBlue dark:hover:text-articleBlue">
                        <i class="fab fa-microsoft mr-2"></i>Connect to Microsoft
                    </a>
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
<?php endif; ?><?php /**PATH C:\Users\Senna\CMGT Jaar 2\TLE2_Startup\resources\views/profile/edit.blade.php ENDPATH**/ ?>