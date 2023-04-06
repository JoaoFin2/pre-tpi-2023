@extends('layouts.app')
@section('content')

<main class="container mx-auto mt-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-4xl font-bold mb-4">Méteo du jour</h1>

        <div class="flex items-center">
            @if ($currentTemp > 25)
            <img src="{{ asset('img/hot.png') }}" alt="Chaud" class="h-16">
            @elseif ($currentTemp < 10)
            <img src="{{ asset('img/cold.png') }}" alt="Froid" class="h-16">
            @else
            <img src="{{ asset('img/normal.png') }}" alt="Normal" class="h-16">
            @endif

            <div class="text-left">
                <h2 class="text-2xl font-bold">Lausanne</h2>
                <p class="text-3xl font-bold mt-2">{{ $currentTemp }}°C</p>
                @if ($currentPrecip > 0.1)
                <img src="{{ asset('img/rain.png') }}" alt="Pluie" class="h-12">
                
                @else
                <img src="{{ asset('img/sun.png') }}" alt="Normal" class="h-12">
                @endif
                <p class="text-gray-500">{{ date('d-m-Y', strtotime($currentDate)) }}</p>
            </div>
            
            <img src="img/lausanne-olympique.png" alt="Lausanne" class="h-28 w-auto ml-20">
        </div>

    </div>

    <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
    <h2 class="text-2xl font-bold mb-4">
        @if ($display==0) 
            Pluie journalière de Lausanne 
            @if(!isset($from)) 
                (des derniers 3 mois) 
            @endif 
        @else 
            Méteo journalière de Lausanne 
            @if(!isset($from)) 
                (des derniers 3 mois) 
            @endif
        @endif
    </h2>

    <div class="flex items-center mb-4">
        <form action="" method="post">
            @csrf  
            <label for="from" class="mr-4">De :</label>
            <input type="date" id="from" name="from" class="rounded-lg border-gray-400 border py-2 px-4" 
            @if(isset($from)) 
                value="{{ $from }}"
            @else 
                value="{{ reset($dates) }}" 
            @endif min="2009-01-01" max="{{ $currentDate }}">

            <label for="to" class="mx-4">À :</label>
            <input type="date" id="to" name="to" class="rounded-lg border-gray-400 border py-2 px-4" 
            @if(isset($to)) 
                value="{{ $to }}" 
            @else 
                value="{{ end($dates) }}" 
            @endif min="2009-01-01" max="{{ $currentDate }}">
            
            <button id="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg ml-4">Afficher le graphique</button>
        </form>
    </div>

    <div class="flex justify-center">
        <div id="graph" style="width:100%;height:400px"></div>
    </div>

    <script type="text/javascript">
        var dates = <?php echo json_encode($dates); ?>;
        var data = <?php echo json_encode($display == 0 ? $precipitations : $maxTemp); ?>;
        var display = <?php echo json_encode($display); ?>;
        var detailsUrlTemplate = "{{ route('details', ['year' => ':year', 'month' => ':month', 'day' => ':day', 'display' => $display]) }}";
    </script>

    @vite('resources/js/graph.js')


    
    <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
    <h2 class="text-2xl font-bold mb-4 m">Jours où il y a eu le plus de pluie</h2>
        <div class="flex items-center justify-center">
            @foreach (($display == 0 ? $mostRain : $hottest) as $item) 
            <?php
            $date = date('d-m-Y', strtotime($item['date']));
            list($day, $month, $year) = explode('-', $date); 
            ?>

            <a href="{{ route('details', ['year' => $year, 'month' => $month, 'day' => $day, 'display' => $display]) }}">
            <div class="bg-white rounded-lg shadow-lg p-6 mr-5 ml-5">
                <h3 class="text-xl font-bold mb-2">{{ date('d-m-Y', strtotime($date)) }}</h3>
                <p>{{ $display == 0 ? 'Quantité de pluie : ' . $item['precipitation'] . ' mm' : 'Température maximale : ' . $item['maxTemp'] . '°C' }}</p>
            </div>
            </a>
            @endforeach
        </div>
    </div>
</main>



@endsection
