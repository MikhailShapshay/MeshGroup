<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Excel</title>
</head>
<body>
<form method="post" enctype='multipart/form-data' action="{{ route('upload') }}">
    @csrf
    <p><input type="file" name="file"></p>
    <p><button type="submit">Upload</button> </p>
</form>
</body>
</html>
