<header class=<?php echo $display == 0 ? "'bg-blue-500 text-white'" : "'bg-red-500 text-white'"; ?>>
    <nav class="flex justify-between items-center py-4">
        <div class="ml-6">
            <a href="{{ route('home', ['display' => $display == 0 ? 0 : 1]) }}" class="font-bold text-lg mr-20"><?php echo $display == 0 ? 'RAINY DAY' : 'WARMY WEATHER' ?></a>
            <a href="{{ route('home', ['display' => $display == 0 ? 1 : 0]) }}" class="font-bold text-lg ml-20"><?php echo $display == 0 ? 'Warmy Weather' : 'Rainy Day' ?></a>
        </div>
    </nav>
</header>