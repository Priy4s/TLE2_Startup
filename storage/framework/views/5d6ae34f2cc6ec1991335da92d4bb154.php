<!DOCTYPE html>
<html>
<head>
    <title>Workspaces</title>
</head>
<body>
<h1>Workspaces</h1>
<a href="<?php echo e(route('workspaces.create')); ?>">Nieuwe workspace maken</a>

<ul>
    <?php $__currentLoopData = $workspaces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workspace): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li>
            <a href="<?php echo e(route('workspaces.show', $workspace)); ?>">
                <?php echo e($workspace->name); ?>

            </a>
            <a href="<?php echo e(route('workspaces.edit', $workspace)); ?>">Bewerken</a>
            <form method="POST" action="<?php echo e(route('workspaces.destroy', $workspace)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit">Verwijderen</button>
            </form>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
</body>
</html><?php /**PATH C:\Users\Senna\CMGT Jaar 2\TLE2_Startup\resources\views/workspaces/index.blade.php ENDPATH**/ ?>