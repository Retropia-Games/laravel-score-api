<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">

    <title>{{ config('app.name') }}</title>

    <!-- Styles -->
    <style>
        body {
            background: Black;
            min-height: 100vh;
            padding: 0 0;
            margin: 0 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        div>img {
            width: 33vmax;
            height: auto;
        }
    </style>
</head>

<body class="antialiased">
    <div>
        <img src="{{ asset('images/pixelated.png') }}" alt="Retropia Games Logo">
    </div>
</body>

</html>
