<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>RentEase</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-sand text-midnight font-body">
@csrf

<div id="app"></div>
</body>
</html>
