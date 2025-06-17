
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
<nav class="p-4 bg-accentBlue text-greenLight w-64 flex flex-col justify-between">
    <div>
    <!-- Logo -->
    <img src="{{ asset('images/tactiqLogo.png') }}" alt="Site Logo" class="h-12 w-56">
    <!-- Menu -->
    <ul class="mt-10 flex flex-col">
        <li class="inline my-4">
            <a href="" class="font-medium text-3xl">Dashboard</a>
        </li>
        <li class="inline my-4">
            <a href="" class="font-medium text-3xl">Documents</a>
        </li>
        <li class="inline my-4">
            <a href="{{ route('workspaces.index') }}" class="font-medium text-3xl">Workspaces</a>
        </li>
        <li class="inline my-4">
            <a href="{{ route('calendar.index') }}" class="font-medium text-3xl">Calendar</a>
        </li>
    </ul>
    </div>
    <div>
        @auth
            <p>Profile</p>
        @else
            <p>Login</p>
        @endauth
    </div>
</nav>
<main class="min-h-full">
    {{ $slot }}
</main>
</body>
</html>
