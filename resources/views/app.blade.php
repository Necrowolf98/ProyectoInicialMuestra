<!DOCTYPE html>
<html>
    <head>
        <link rel="shortcut icon" href="/img/AdminLTELogo.png" />
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <title inertia>{{ config('app.name', 'PInicial') }}</title>
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
        <link href="{{ mix('/css/plantilla.css') }}" rel="stylesheet" />

        <script src="{{ mix('/js/app.js') }}" defer></script>
        <script src="{{ mix('/js/plantilla.js') }}" defer></script>

        @routes
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            @inertia
        </div>
    </body>
</html>