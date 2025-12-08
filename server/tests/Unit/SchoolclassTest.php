<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class SchoolclassTest extends TestCase
{
    protected $table = 'schoolclasses';

    public static function expectedSchemaDataProvider()
    {
        return [
            'id oszlop' => ['id', 'bigint'],
            'osztalyNev oszlop' => ['osztalyNev', 'varchar']
        ];
    }

    public function test_exists_schoolclasses_table(): void
    {
        $this->assertTrue(
            Schema::hasTable($this->table),
            "A '{$this->table}' tábla nem létezik"
        );
    }

    #[DataProvider('expectedSchemaDataProvider')]
    public function test_does_the_schoolclasses_table_contain_all_fields(string $column, string $type): void
    {
        $this->assertTrue(
            Schema::hasColumn($this->table, $column),
            "A '$column' oszlop nem létezik a '{$this->table}' táblában"
        );
    }

    #[DataProvider('expectedSchemaDataProvider')]
    public function test_the_schoolclasses_table_columns_have_the_expected_types($expectedColumn, $expectedType): void
    {
        
        $actualDbSqlType = Schema::getColumnType($this->table, $expectedColumn);

        
        $isTypeMatch = $actualDbSqlType == $expectedType;
        $this->assertTrue(
            $isTypeMatch,
            "A '{$expectedColumn}' oszlop típusa nem egyezik. Várt: '{$expectedType}', Kapott DB-típus: '{$actualDbSqlType}'."
        );
    }
}
