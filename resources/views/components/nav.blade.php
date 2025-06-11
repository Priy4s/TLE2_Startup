
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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Tactiq</title>
</head>
<body class="bg-greenLight text-viridian flex min-h-screen">
<nav class="p-4 bg-accentBlue text-greenLight flex w-56">
    <!-- Logo -->

    <!-- Menu -->
    <ul class="ml-4 mt-2 flex flex-col">
        <li class="inline">
            <button id="openModal" class="bg-transparent text-yellow font-medium text-lg">Dashboard</button>
        </li>
        <li class="inline">
            <button id="openModal" class="bg-transparent text-yellow font-medium text-lg">Documents</button>
        </li>
        <li class="inline">
            <button id="openModal" class="bg-transparent text-yellow font-medium text-lg">Workspaces</button>
        </li>
        <li class="inline">
            <button id="openModal" class="bg-transparent text-yellow font-medium text-lg">Calendar</button>
        </li>
    </ul>
</nav>
<main class="min-h-[82vh]">
    {{ $slot }}
</main>
</body>
</html>
