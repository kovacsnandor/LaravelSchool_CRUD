<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class PlayingsportTest extends TestCase
{
    protected $table = 'playingsports';

    public static function expectedSchemaDataProvider()
    {
        return [
            'id oszlop' => ['id', 'bigint'],
            'studentId oszlop' => ['studentId', 'bigint'],
            'sportId oszlop' => ['sportId', 'bigint'],
        ];
    }

    #[DataProvider('expectedSchemaDataProvider')]
    public function test_does_the_playingsports_table_contain_all_fields(string $expectedColumn, string $expectedType): void
    {
        //Ellenőrizze, hogy megvannak-e a tábla mezői
        $this->assertTrue(Schema::hasColumn($this->table, $expectedColumn), "A '$expectedColumn' oszlop nem letezik");
    }

    #[DataProvider('expectedSchemaDataProvider')]
    public function test_the_playingsports_table_columns_have_the_expected_types($expectedColumn, $expectedType)
    {
        //Ellenőrizze, hogy jók-e a típusai

        $actualDbSqlType = Schema::getColumnType($this->table, $expectedColumn);

        
        $isTypeMatch = $actualDbSqlType == $expectedType;
        $this->assertTrue(
            $isTypeMatch,
            "A '{$expectedColumn}' oszlop típusa nem egyezik. Várt: '{$expectedType}', Kapott DB-típus: '{$actualDbSqlType}'."
        );
    }



    public function test_exists_playingsports_table(): void
    {
        //Ellenőrizze, hogy megvan-e a tábla

        $this->assertTrue(Schema::hasTable($this->table), "A playingsports tábla nem létezik");
    }

}
