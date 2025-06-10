<!DOCTYPE html>
<html>
<head>
    <title>Workspace aanmaken</title>
</head>
<body>
<h1>Nieuwe workspace</h1>
<form method="POST" action="{{ route('workspaces.store') }}">
    @csrf
    <label for="name">Naam:</label>
    <input type="text" name="name" required>
    <button type="submit">Aanmaken</button>
</form>
</body>
</html>