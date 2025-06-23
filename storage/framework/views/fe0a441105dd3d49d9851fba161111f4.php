        <?php if (isset($component)) { $__componentOriginalff09156f73c896030ee75284e9b2c466 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalff09156f73c896030ee75284e9b2c466 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalff09156f73c896030ee75284e9b2c466)): ?>
<?php $attributes = $__attributesOriginalff09156f73c896030ee75284e9b2c466; ?>
<?php unset($__attributesOriginalff09156f73c896030ee75284e9b2c466); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalff09156f73c896030ee75284e9b2c466)): ?>
<?php $component = $__componentOriginalff09156f73c896030ee75284e9b2c466; ?>
<?php unset($__componentOriginalff09156f73c896030ee75284e9b2c466); ?>
<?php endif; ?>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <div class="mt-4 flex items-center">
                            <?php if(auth()->user()->google_refresh_token): ?>
                                <div class="flex items-center space-x-4">
                <span class="text-green-600">
                    <i class="fas fa-check-circle mr-2"></i>Connected
                </span>

                                    <!-- Disconnect Button -->
                                    <form method="POST" action="<?php echo e(route('google.disconnect')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="px-3 py-1 text-sm bg-black text-red-600 hover:bg-gray-800 rounded">
                                            Disconnect
                                        </button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <!-- Connect Button -->
                                <a href="<?php echo e(route('google.login')); ?>"
                                   class="px-4 py-2 bg-black text-green-600 rounded-md hover:bg-gray-800">
                                    <i class="fab fa-google-drive mr-2"></i>Connect Google Drive
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="mt-4 flex items-center">
                            <?php if(auth()->user()->microsoft_refresh_token): ?>
                                
                                <div class="flex items-center space-x-4">
            <span class="text-green-600">
                <i class="fab fa-microsoft mr-2"></i>Verbonden met Microsoft
            </span>

                                    <form method="POST" action="<?php echo e(route('microsoft.disconnect')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="px-3 py-1 text-sm bg-black text-red-600 hover:bg-gray-800 rounded">
                                            Verbinding verbreken
                                        </button>
                                    </form>
                                </div>
                            <?php else: ?>
                                
                                <a href="<?php echo e(route('microsoft.login')); ?>"
                                   class="px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800">
                                    <i class="fab fa-microsoft mr-2"></i>Verbinden met Microsoft
                                </a>
                            <?php endif; ?>
                        </div>
                        <?php echo $__env->make('profile.partials.update-profile-information-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <?php echo $__env->make('profile.partials.delete-user-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        </div>
<?php /**PATH C:\Users\nbjja\PhpstormProjects\TLE2_Startup\resources\views/profile/edit.blade.php ENDPATH**/ ?>