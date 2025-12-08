<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class SportTest extends TestCase
{
    protected $table = 'sports';

    protected $expectedSchema = [
        'id' => 'bigint',
        'sportNev' => 'varchar',
    ];

    public static function expectedSchemaDataProvider()
    {
        return [
            'id oszlop' => ['id', 'bigint'],
            'sportNev oszlop' => ['sportNev', 'varchar'],
        ];
    }

    public function test_exists_sports_table(): void
    {
        //Ellenőrizze, hogy megvan-e a tábla

        $this->assertTrue(Schema::hasTable($this->table), "A sports tábla nem létezik");
    }

    #[DataProvider('expectedSchemaDataProvider')]
    public function test_does_the_sports_table_contain_all_fields(string $expectedColumn, string $expectedType): void
    {
        //Ellenőrizze, hogy megvannak-e a tábla mezői
        $this->assertTrue(Schema::hasColumn($this->table, $expectedColumn), "A '$expectedColumn' oszlop nem letezik");

    }

    #[DataProvider('expectedSchemaDataProvider')]
    public function test_the_sports_table_columns_have_the_expected_types(string $expectedColumn, string $expectedType)
    {
        //Ellenőrizze, hogy jók-e a típusai

        $columns = Schema::getColumnListing('sports');


        $this->assertEmpty(
            array_diff(array_keys($this->expectedSchema), $columns),
            'Hiányzó oszlopok a sports táblában.'
        );


        foreach ($this->expectedSchema as $columnName => $expectedLaravelType) {

            $actualDbSqlType = Schema::getColumnType('sports', $columnName);

            $isTypeMatch = $actualDbSqlType == $expectedLaravelType;
            $this->assertTrue(
                $isTypeMatch,
                "A '{$columnName}' oszlop típusa nem egyezik. Várt: '{$expectedLaravelType}', Kapott DB-típus: '{$actualDbSqlType}'."
            );
        }
    }


}
