<?php
namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Carbon\Carbon;
use App\Models\Weather;

class WeatherControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testGetAll() 
    {
        $valuesNumber = 10;

        // Créer des données de test
        Weather::factory()->count($valuesNumber)->create();

        // Appeler la méthode all
        $response = $this->call('GET', '/weather/all');

        // Vérifier la réponse
        $this->assertEquals(200, $response->status());
        $data = json_decode($response->getContent());
        $this->assertCount($valuesNumber, $data);
    }

    public function testGetLastThreeMonths()
    {
         // Créer des données de test pour les 3 derniers mois
        Weather::factory()->count(5)->create(['date' => Carbon::now()->subMonth()]);
        Weather::factory()->count(5)->create(['date' => Carbon::now()->subMonths(2)]);
        Weather::factory()->count(5)->create(['date' => Carbon::now()->subMonths(3)]);

        // Créer des données de test pour les mois précédents
        Weather::factory()->count(10)->create(['date' => Carbon::now()->subMonths(4)]);
        Weather::factory()->count(10)->create(['date' => Carbon::now()->subMonths(5)]);

        // Appeler la méthode index
        $response = $this->call('GET', '/weather');
    
        // Vérifier la réponse
        $this->assertEquals(200, $response->status());
        $data = json_decode($response->getContent());
        $this->assertCount(15, $data);
    }

    public function testGetLatest()
    {
        // Créer des données de test
        $weather1 = Weather::factory()->create(['date' => '2022-01-01']);
        $weather2 = Weather::factory()->create(['date' => '2022-02-01']);
        $weather3 = Weather::factory()->create(['date' => '2022-03-01']);

        // Appeler la méthode latest
        $response = $this->call('GET', '/weather/latest');

        // Vérifier la réponse
        $this->assertEquals(200, $response->status());
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($weather3->id, $data['id']);
    }

    public function testGetByDate() 
    {
        $year = 2022;
        $month = 3;
        $day = 15;

        // Créer des données de test
        Weather::factory()->count(10)->create();
        $weather = Weather::factory()->create(['date' => "$year-$month-$day"]);

        // Appeler la méthode date
        $response = $this->call('GET', "/weather/$year/$month/$day");

        // Vérifier la réponse
        $this->assertEquals(200, $response->status());
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($weather->id, $data[0]['id']);
    }

    public function testGetChooseDates() 
    {
        $start = '2022-01-01';
        $end = '2022-01-31';
    
        // Créer des données de test pour la plage de dates spécifiée
        Weather::factory()->create(['date' => "2022-01-02"]);
        Weather::factory()->create(['date' => "2022-01-03"]);
        Weather::factory()->create(['date' => "2022-01-04"]);
        
        // Créer des données de test qui ne sont pas dans la plage de dates
        Weather::factory()->create(['date' => "2022-03-02"]);
        Weather::factory()->create(['date' => "2020-03-22"]);
        Weather::factory()->create(['date' => "2018-12-06"]);

        // Appeler la méthode chooseDates
        $response = $this->call('GET', "/weather/from=$start/to=$end");
        
       
        // Vérifier la réponse
        $this->assertEquals(200, $response->status());
        $data = json_decode($response->getContent()); 
        
        
        $this->assertCount(3, $data);
    }
}