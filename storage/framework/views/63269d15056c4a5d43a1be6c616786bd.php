<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <title>Tactiq</title>
</head>
<body class="bg-greenLight text-viridian dark:bg-viridian dark:text-greenLight flex min-h-screen">
<nav class="p-4 bg-accentBlue text-greenLight w-64 flex flex-col justify-between">
    <div>
    <!-- Logo -->
    <img src="<?php echo e(asset('images/tactiqLogo.png')); ?>" alt="Site Logo" class="h-12 w-56">
    <!-- Menu -->
    <ul class="mt-10 flex flex-col">
        <li class="inline my-4">
            <a href="" class="font-medium text-3xl">Dashboard</a>
        </li>
        <li class="inline my-4">
            <a href="<?php echo e(route('documents.overview')); ?>" class="font-medium text-3xl">Documents</a>
        </li>
        <li class="inline my-4">
            <a href="<?php echo e(route('workspaces.index')); ?>" class="font-medium text-3xl">Workspaces</a>
        </li>
        <li class="inline my-4">
            <a href="" class="font-medium text-3xl">Calendar</a>
        </li>
    </ul>
    </div>
    <div>
        <?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(route('profile.edit')); ?>" class="font-medium text-3xl">Profile</a>
        <?php else: ?>
            <a href="<?php echo e(route('login')); ?>" class="font-medium text-3xl">Login</a>
        <?php endif; ?>
    </div>
</nav>
<main class="min-h-full m-8">
    <?php echo e($slot); ?>

</main>
</body>
</html>
<?php /**PATH C:\Users\Senna\CMGT Jaar 2\TLE2_Startup\resources\views/components/nav.blade.php ENDPATH**/ ?>