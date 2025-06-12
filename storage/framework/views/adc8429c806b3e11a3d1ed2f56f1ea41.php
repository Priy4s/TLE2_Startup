<!DOCTYPE html>
<html>
<head>
    <title>Workspace bewerken</title>
</head>
<body>
<h1>Bewerk workspace</h1>
<form method="POST" action="<?php echo e(route('workspaces.update', $workspace)); ?>">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <label for="name">Naam:</label>
    <input type="text" name="name" value="<?php echo e($workspace->name); ?>" required>
    <button type="submit">Opslaan</button>
</form>
</body>
</html><?php /**PATH C:\Users\Senna\CMGT Jaar 2\TLE2_Startup\resources\views/workspaces/edit.blade.php ENDPATH**/ ?>