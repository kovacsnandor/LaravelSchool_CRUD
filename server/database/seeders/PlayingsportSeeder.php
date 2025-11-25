<?php

namespace Database\Seeders;

use App\Helpers\CsvReader;
use App\Models\Playingsport;
use App\Models\Schoolclass;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlayingsportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //A tanulok hany szazaleka sportol: 65%
        //Egy tanulo atlagosan hany sportot uz: 1.1
        $percentageOfStudentsPlayingSports = 0.65;
        $avarageNumberOfSportsAStudentPlays = 1.1;
        $numberOfStudent = Student::count();
        $numberOfAthletes = round($numberOfStudent + $percentageOfStudentsPlayingSports);
        $numberOfSports = round($numberOfAthletes + $avarageNumberOfSportsAStudentPlays);
        Playingsport::factory()->count($numberOfSports)->create();

    }
}
