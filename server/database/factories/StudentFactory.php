<?php

namespace Database\Factories;

use App\Models\Schoolclass;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    protected function withFaker()
    {
        return \Faker\Factory::create('hu_HU');
    }

    public static function getScholarShip(float $averageGrade): int
    {

        $scholarshipTiers = [
            "4.5" => 42000,
            "3.5" => 25000,
            "2.5" => 16000,
            "2.0" => 8000,
        ];

        $scholarshipAmount = 0;

        // Az 5.0-ás átlag külön kezelése a maximális díj miatt
        if ($averageGrade >= 5.0) {
            return 60000;
        }

        foreach ($scholarshipTiers as $minAverage => $amount) {
            if ($averageGrade >= (float)$minAverage) {
                // Megtaláltuk a legmagasabb szintet, amibe beleesik
                $scholarshipAmount = $amount;
                break;
            }
        }
        return $scholarshipAmount; // 0 Ft-ot ad vissza 2.00 alatti átlag esetén
    }




    public function definition(): array
    {
        // Nem & név
        $neme = $this->faker->boolean;
        $gender = $neme ? 'male' : 'female';

        $firstName = $this->faker->firstName($gender);
        $lastName = $this->faker->lastName();
        $diakNev = "$lastName $firstName";

        // Személyes adatok
        $iranyitoszam = $this->faker->postcode();
        $lakHelyseg = $this->faker->city();
        $szulHelyseg = $this->faker->city();
        $lakCim = $this->faker->streetAddress();
        $igazolvanyszam = strtoupper($this->faker->unique()->bothify('??######'));

        // Átlag – FIX
        $atlag = rand(10, 50) / 10;  // 1.0 - 5.0 pontos tizedes

        // Ösztöndíj
        $osztondij = self::getScholarShip($atlag);

        // Osztály és születési dátum
        $randomClass = Schoolclass::inRandomOrder()->first();
        $schoolclassId = $randomClass->id;

        $grade = (int)substr($randomClass->osztalyNev, 0, 1);
        $ageMin = $grade + 5;
        $ageMax = $grade + 6;

        $szulDatum = $this->faker->dateTimeBetween(
            "-{$ageMax} years",
            "-{$ageMin} years"
        );

        return [
            'diakNev' => $diakNev,
            'schoolclassId' => $schoolclassId,
            'neme' => $neme,
            'iranyitoszam' => $iranyitoszam,
            'lakHelyseg' => $lakHelyseg,
            'lakCim' => $lakCim,
            'szulHelyseg' => $szulHelyseg,
            'szulDatum' => $szulDatum,
            'igazolvanyszam' => $igazolvanyszam,
            'atlag' => $atlag,
            'osztondij' => $osztondij,
        ];
    }
}
