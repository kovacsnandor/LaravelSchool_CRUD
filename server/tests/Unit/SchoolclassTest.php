<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SchoolclassTest extends TestCase
{
    protected $expectedSchema = [
        'id'         => 'bigint',
        'osztalyNev'       => 'varchar',
    ];

    public function test_exists_schoolclasses_table(): void
    {
        //Ellenőrizze, hogy megvan-e a tábla

        $this->assertTrue(Schema::hasTable('schoolclasses'), "A schoolclasses tábla nem létezik");
    }

    public function test_does_the_schoolclasses_table_contain_all_fields(): void
    {
       //Ellenőrizze, hogy megvannak-e a tábla mezői
        foreach ($this->expectedSchema as $column => $type) {
            $this->assertTrue(Schema::hasColumn('schoolclasses', $column), "A '$column' oszlop nem letezik");
        }
    }

    public function test_the_schoolclasses_table_columns_have_the_expected_types()
    {
        //Ellenőrizze, hogy jók-e a típusai

        
        $columns = Schema::getColumnListing('schoolclasses');

 
     
        $this->assertEmpty(
            array_diff(array_keys($this->expectedSchema), $columns),
            'Hiányzó oszlopok a students táblában.'
        );
 
        foreach ($this->expectedSchema as $columnName => $expectedLaravelType) {
 
            $actualDbSqlType = Schema::getColumnType('schoolclasses', $columnName);
           
            $isTypeMatch = $actualDbSqlType == $expectedLaravelType;
            $this->assertTrue(
                $isTypeMatch,
                "A '{$columnName}' oszlop típusa nem egyezik. Várt: '{$expectedLaravelType}', Kapott DB-típus: '{$actualDbSqlType}'."
            );
        }
    }
}
