<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Magic Potion</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    </head>

    <body class="antialiased" style="margin: 10%">
        @if (session('error'))
            <div class="alert alert-warning">{{ session('error') }}</div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

    	<div id="app"></div>

    	<script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>

