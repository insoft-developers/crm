<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>CRM - CUSTOMER MANAGEMENT RELATIONSHIP</title>

    @include('partials._head')
</head>
<body class="" id="app">
    @include('partials._body')
        

    
   

</body>
</html>
