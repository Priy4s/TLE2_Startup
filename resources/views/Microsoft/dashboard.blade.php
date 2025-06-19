<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mijn Dashboard</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; padding: 2em; color: #333; }
        .container { max-width: 800px; margin: 0 auto; }
        h1, h2 { color: #005a9e; }
        ul { list-style-type: none; padding-left: 0; }
        li { display: flex; align-items: center; padding: 8px 12px; border-bottom: 1px solid #eee; transition: background-color 0.2s; }
        li:hover { background-color: #f9f9f9; }
        li span.icon { margin-right: 15px; font-size: 1.2em; }
        a { color: #005a9e; text-decoration: none; font-weight: 500; }
        a:hover { text-decoration: underline; }
        .create-form { background-color: #f0f6fa; padding: 1.5em; border-radius: 8px; margin-top: 2em; }
        .create-form input[type="text"] { padding: 10px; border: 1px solid #ccc; border-radius: 4px; width: 300px; margin-right: 10px; }
        .create-form button { padding: 10px 15px; border: none; border-radius: 4px; color: white; cursor: pointer; }
        .create-form button.word { background-color: #2b579a; }
        .create-form button.ppt { background-color: #d24726; }
    </style>
</head>
<body>
<div class="container">
    <h1>Welkom, {{ $user->getDisplayName() }}</h1>
    <p>Hieronder zie je de bestanden en mappen in de hoofdmap van je OneDrive. Klik op een item om het te openen.</p>



    <hr style="margin-top: 2em;">
    <h2>Jouw bestanden op OneDrive</h2>

    @if (count($files) > 0)
        <ul>
            @foreach ($files as $file)
                <li>
                    <a href="{{ $file->getWebUrl() }}" target="_blank" rel="noopener noreferrer">
                        @if ($file->getFolder())
                            <span class="icon">📁</span>
                        @else
                            <span class="icon">📄</span>
                        @endif

                        <span>{{ $file->getName() }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <p>Je hebt geen bestanden in de hoofmap van je OneDrive.</p>
    @endif
</div>
</body>
</html>