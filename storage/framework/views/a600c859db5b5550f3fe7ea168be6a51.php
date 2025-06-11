<!DOCTYPE html>
<html>
<head>
    <title>Workspace aanmaken</title>
</head>
<body>
<h1>Nieuwe workspace</h1>
<form method="POST" action="<?php echo e(route('workspaces.store')); ?>">
    <?php echo csrf_field(); ?>
    <label for="name">Naam:</label>
    <input type="text" name="name" required>
    <button type="submit">Aanmaken</button>
</form>
</body>
</html><?php /**PATH C:\Users\Senna\CMGT Jaar 2\TLE2_Startup\resources\views/workspaces/create.blade.php ENDPATH**/ ?>