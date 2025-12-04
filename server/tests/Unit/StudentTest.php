<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class StudentTest extends TestCase
{
   protected $expectedSchema = [
        'id'         => 'bigint',
        'diakNev'       => 'varchar',
        'schoolclassId'         => 'bigint',
        'neme'         => 'tinyint',
        'iranyitoszam'       => 'varchar',
        'lakHelyseg'         => 'varchar',
        'lakCim'       => 'varchar',
        'szulHelyseg'         => 'varchar',
        'szulDatum'         => 'date',
        'igazolvanyszam'       => 'varchar',
        'atlag'         => 'decimal',
        'osztondij'         => 'decimal',
        
    ];

    public function test_exists_students_table(): void
    {
        //Ellenőrizze, hogy megvan-e a tábla

        $this->assertTrue(Schema::hasTable('students'), "A students tábla nem létezik");
    }

    public function test_does_the_students_table_contain_all_fields(): void
    {
       //Ellenőrizze, hogy megvannak-e a tábla mezői
        foreach ($this->expectedSchema as $column => $type) {
            
            $this->assertTrue(Schema::hasColumn('students', $column), "A '$column' oszlop nem letezik");
        }
    }

    public function test_the_students_table_columns_have_the_expected_types()
    {
        //Ellenőrizze, hogy jók-e a típusai

        $columns = Schema::getColumnListing('students');

 
        $this->assertEmpty(
            array_diff(array_keys($this->expectedSchema), $columns),
            'Hiányzó oszlopok a students táblában.'
        );
 
        
        foreach ($this->expectedSchema as $columnName => $expectedLaravelType) {
 
            $actualDbSqlType = Schema::getColumnType('students', $columnName);
           
            $isTypeMatch = $actualDbSqlType == $expectedLaravelType;
            $this->assertTrue(
                $isTypeMatch,
                "A '{$columnName}' oszlop típusa nem egyezik. Várt: '{$expectedLaravelType}', Kapott DB-típus: '{$actualDbSqlType}'."
            );
        }
    }
}
