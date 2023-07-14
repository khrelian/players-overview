<?php

namespace App\Traits;

use App\Exceptions\ForeignReferenceDoesNotExistException;
use App\Services\DataMapper;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * Model trait that allows model to seed from csv files
 */
trait SeedFromCSVTrait
{
    /**
     * seeds table from CSV data
     *
     * @param Type $var Description
     * @return void
     **/
    public function seedFromCSV(): void
    {
        $dataMapper = new DataMapper(base_path('database/data/' . $this->CSVName));
        $table = $this->getTable();
        $dataMapper->executeBetweenCSVLines(
            function ($line, $count) use ($table) {

                // limit for testing purpose only. remove this later on when needed.
                if ($count >= 2000) {
                    return $count;
                }

                $obj = new self;
                $values = [];
                foreach ($line as $property => $value) {
                    if (isset($obj->CSVMap[$property])) {

                        $values[$obj->CSVMap[$property]] = $obj->CSVMap[$property] == $obj->getKeyName() ? (int) $value : $value;
                    } else {
                        $values[$property] = $property == $obj->getKeyName() ? (int) $value : $value;
                    }
                }
                try {
                    $obj->firstOrCreate($values);
                } catch (QueryException $e) {
                    die($e->getMessage());
                }

                // clear console
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    system('cls');
                } else {
                    system('clear');
                }
                (new ConsoleOutput)->writeln("\tPopulating \e[34m{$table}\e[0m table");
                (new ConsoleOutput)->writeln("\t\e[32m{$count}\e[0m records added.");
            }
        );
        // (new ConsoleOutput)->writeln("\t{$this->table} table seeded successfully.");
        (new ConsoleOutput)->writeln("\t{$this->table} done.");
    }

    /**
     * sets the CSV name property
     *
     * @param String $name name of the csv file for the model
     * @return void
     **/
    public function setCSVName(String $name): void
    {
        $this->CSVName = $name;
    }

    /**
     * sets the map of csv header to model property
     *
     * @return void
     **/
    public function setCSVMap(array $map): void
    {
        $this->CSVMap = $map;
    }
}
