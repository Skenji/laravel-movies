<!DOCTYPE html>
<html lang="es_LA">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Prueba de peliculas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-slate-700">
    
    @include('include.header')

    <section id="main-section" class="container mx-auto p-3">
        <section class="movies-container grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-5">
            @if(is_array($movies))
                @foreach ($movies AS $movie)
                    @include('include.movies-card', array('movie' => $movie, 'boolFromDB' => isset($boolFromDB) ))
                @endforeach
            @else
                <section class="bg-red-300 col-span-5 text-center px-7 py-7 rounded">
                    <h1 class="text-xl font-bold text-red-900 uppercase">Su busqueda no arrojó ningun resultado</h1>
                </section>                
            @endif
        </section>
    </section>

    <script src="{{ asset('js/app.js')}}"></script>
</body>
</html>