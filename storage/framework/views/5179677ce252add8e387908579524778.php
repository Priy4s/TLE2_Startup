<!DOCTYPE html>
<html>
<head>
    <title><?php echo e($workspace->name); ?></title>
</head>
<body>
<h1><?php echo e($workspace->name); ?></h1>
<p>Dit is de detailpagina voor workspace "<?php echo e($workspace->name); ?>"</p>
<p>Hier kan je in de toekomst verder informatie specifiek per workspace invullen (zie vieuws/workspaces/show.blade.php)</p>

<a href="<?php echo e(route('workspaces.index')); ?>">Terug naar overzicht</a>
</body>
</html><?php /**PATH C:\Users\Senna\CMGT Jaar 2\TLE2_Startup\resources\views/workspaces/show.blade.php ENDPATH**/ ?>