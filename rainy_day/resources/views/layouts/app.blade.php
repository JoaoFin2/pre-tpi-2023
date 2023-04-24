<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    
    <!-- Script pour les graphiques -->
    <script src="https://cdn.jsdelivr.net/npm/echarts@latest"></script>

    <title>Rainy Day</title>

</head>

<body>
    @include('partials/navbar')
    @yield('content')
    @include('partials/footer')
</body>
   
</html>