<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title>Tactiq Login/Register</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link rel="icon" href="<?php echo e(asset('images/tactiqicon.png')); ?>" type="image/png">
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>
    <body class="font-sans text-viridian antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-greenLight dark:bg-viridian">
            <div>
                <a href="/">
                    <img src="<?php echo e(asset('images/tactiqLogo.png')); ?>" alt="Site Logo" class="h-20 w-auto">
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-articleBlue dark:bg-accentBlue shadow-md overflow-hidden sm:rounded-lg">
                <?php echo e($slot); ?>

            </div>
        </div>
    </body>
</html>
<?php /**PATH C:\Users\Senna\CMGT Jaar 2\TLE2_Startup\resources\views/layouts/guest.blade.php ENDPATH**/ ?>