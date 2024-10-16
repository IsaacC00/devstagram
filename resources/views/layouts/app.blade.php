<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!---el stack sirve para almacenar un espacio para agregar
        hojas de estilo y que no se requieran importar en todas las vistas
        incluso existe para javascript con scripts---->
    @stack('styles')

    <title>DevStagram @yield('titulo') </title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @livewireStyles()
</head>

<body class="bg-gray-100">

    <x-nav-bar />


    <main class="container mx-auto mt-10">

        <h2 class="font-black text-center text-3xl mb-10">
            @yield('titulo')
        </h2>

        @yield('contenido')

    </main>

    <footer class="mt-10 text-center p-5 text-gray-500 font-bold uppercase">

        DevStagram - todos los derechos reservados
        {{ //objeto de fechas de blade para imprimir fechas
        now()->year }}

    </footer>

    <!--en blades existen direcctivas para poder poder crear Contenedoores-->
    <!--para crear un layout en laravel debemos utilizar CONTENEDORES-->
    <!---->
    <!--para crear un layout en laravel debemos utilizar CONTENEDORES-->
    <!--
        <nav>
            <a href="/">Principal</a>
            <a href="/nosotros">Nosotros</a>
            <a href="/tienda">Tienda</a>
            <a href="/contacto">Contacto</a>
            
        </nav>
        
    para poder tener contenedores dinamicos utilizamos yields
    esto nos permitira reutilizar etiquetas en diferentes paginas
    OJO seguir la directivas de laravle

    <h1 class="text-4xl font-extrabold">@yield('tituloPrincipal')</h1>
-->
    @livewireScripts()
</body>

</html>