<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class StudentTest extends TestCase
{
    //    protected $expectedSchema = [
    //         'id'         => 'bigint',
    //         'diakNev'       => 'varchar',
    //         'schoolclassId'         => 'bigint',
    //         'neme'         => 'tinyint',
    //         'iranyitoszam'       => 'varchar',
    //         'lakHelyseg'         => 'varchar',
    //         'lakCim'       => 'varchar',
    //         'szulHelyseg'         => 'varchar',
    //         'szulDatum'         => 'date',
    //         'igazolvanyszam'       => 'varchar',
    //         'atlag'         => 'decimal',
    //         'osztondij'         => 'decimal',

    //     ];
    protected $table = 'students';
    public static function expectedSchemaDataProvider()
    {
        return [
            'id oszlop' => ['id', 'bigint'],
            'diakNev oszlop' => ['diakNev', 'varchar'],
            'schoolclassId oszlop' => ['schoolclassId', 'bigint'],
            'neme oszlop' => ['neme', 'tinyint'],
            'iranyitoszam oszlop' => ['iranyitoszam', 'varchar'],
            'lakHelyseg oszlop' => ['lakHelyseg', 'varchar'],
            'lakCim oszlop' => ['lakCim', 'varchar'],
            'szulHelyseg oszlop' => ['szulHelyseg', 'varchar'],
            'szulDatum oszlop' => ['szulDatum', 'date'],
            'igazolvanyszam oszlop' => ['igazolvanyszam', 'varchar'],
            'atlag oszlop' => ['atlag', 'decimal'],
            'osztondij oszlop' => ['osztondij', 'decimal'],
        ];
    }

    #[DataProvider('expectedSchemaDataProvider')]
    public function test_exists_students_table(): void
    {
        //Ellenőrizze, hogy megvan-e a tábla

        $this->assertTrue(Schema::hasTable($this->table), "A students tábla nem létezik");
    }

    #[DataProvider('expectedSchemaDataProvider')]
    public function test_does_the_students_table_contain_all_fields(string $expectedColumn, string $expectedType): void
    {
        //Ellenőrizze, hogy megvannak-e a tábla mezői
        $this->assertTrue(Schema::hasColumn($this->table, $expectedColumn), "A '$expectedColumn' oszlop nem letezik");
    }

    #[DataProvider('expectedSchemaDataProvider')]
    public function test_the_students_table_columns_have_the_expected_types($expectedColumn, $expectedType)
    {
        //Ellenőrizze, hogy jók-e a típusai

        $actualDbSqlType = Schema::getColumnType($this->table, $expectedColumn);

        
        $isTypeMatch = $actualDbSqlType == $expectedType;
        $this->assertTrue(
            $isTypeMatch,
            "A '{$expectedColumn}' oszlop típusa nem egyezik. Várt: '{$expectedType}', Kapott DB-típus: '{$actualDbSqlType}'."
        );
    }

}
