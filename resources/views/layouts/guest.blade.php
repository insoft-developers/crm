<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />
        
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/backend.css') }}">

        <!-- remixicon -->
        <link rel="stylesheet" href="{{ asset('vendor/remixicon/fonts/remixicon.css') }}"/>
       <style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }
</style>


    </head>
    <body class="" style="background: url({{ asset('images/background.png') }}); background-attachment: fixed; background-size: cover;">

        <div class="wrapper">
            {{ $slot }}
        </div>
         @include('partials._scripts')
    </body>
</html>
