@extends('layouts.app')
@section('content')

<main class="flex-grow p-4">
    <div class="flex items-center justify-center my-4">
        
        @if ($maxTemp > 25)
            <img src="{{ asset('img/hot.png') }}" alt="Chaud" class="w-16 h-16 object-contain mr-10">
        @elseif ($maxTemp < 10)
            <img src="{{ asset('img/cold.png') }}" alt="Froid" class="w-16 h-16 object-contain mr-10">
        @else
            <img src="{{ asset('img/normal.png') }}" alt="Normal" class="w-16 h-16 object-contain mr-10">
        @endif
        <div class="ml-4">
        <h2 class="text-xl">Lausanne</h2>
        
        <p class="text-gray-500">{{ $date }}</p>
        
        </div>
        @if ($precipitation > 0.1)
            <img src="{{ asset('img/rain.png') }}" alt="Pluie" class="w-16 h-16 object-contain ml-10">
        @else
            <img src="{{ asset('img/sun.png') }}" alt="Normal" class="w-16 h-16 object-contain ml-10">
        @endif
    </div>
    <div class="grid grid-cols-2 gap-4 my-4">
        <div class="bg-white border border-gray-200 rounded-lg shadow-md p-4">
        <h3 class="text-lg font-medium mb-4">Température minimale</h3>
        <p class="text-5xl font-bold">{{ $minTemp }}°C</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg shadow-md p-4">
        <h3 class="text-lg font-medium mb-4">Température maximale</h3>
        <p class="text-5xl font-bold">{{ $maxTemp }}°C</p>
        </div>
    </div>
    <div class="bg-white border border-gray-200 rounded-lg shadow-md p-4">
        <h3 class="text-lg font-medium mb-4">Précipitations</h3>
        <p class="text-5xl font-bold">{{ $precipitation }} mm</p>
    </div>

    <a href="{{ route('home', ['display' => $display]) }}" class="block text-center text-gray-500 mt-8">Retour à la page d'accueil</a>
</main>


@endsection
