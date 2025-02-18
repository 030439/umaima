<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel Import</title>
</head>
<body>
    <h1>Import Excel Data</h1>
    @if(session('success'))
        <div style="color:green">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div style="color:red;">{{ session('error') }}</div>
    @endif


    <form action="{{ route('import.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required>
        <button type="submit">Import</button>
    </form>
</body>
</html>