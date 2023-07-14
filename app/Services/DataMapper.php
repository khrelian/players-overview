<?php

namespace App\Services;

use stdClass;
use Ramsey\Uuid\Type\Integer;
use App\Http\Interfaces\CSVMapperInterface;
use Symfony\Component\Console\Output\ConsoleOutput;

class DataMapper
{

    private $_headers;
    private $path;
    private $delimeter;

    public function __construct(String $path = '', String $delimeter = ';')
    {
        $this->path = $path;
        $this->delimeter = $delimeter;
    }

    /**
     * Opens CSV file to read
     *
     * Reads CSV file and implements a callback function in every line
     *
     * @param String $path path to csv file
     * @param Callback $callback a callback function to execute every line
     * @return int
     * @throws conditon
     **/
    public function executeBetweenCSVLines($callback): int
    {
        $counter = 0;

        $wholeData = file($this->path);
        $chunks = array_chunk($wholeData, 1000);

        foreach ($chunks as $key1 => $chunk) {
            foreach ($chunk as $key2 => $data) {
                if ($key1 === 0 && $key2 === 0) {
                    $this->_headers = $this->cleanStrings(explode($this->delimeter, $data));
                } else {
                    $callback($this->extractDataObject($data), $counter);
                    $counter++;
                }
            }
        }
        return $counter;
    }

    /**
     * extract data as object with keys from string line
     *
     *
     * @param String $line Line from the csv file
     * @return StdClass
     **/
    private function extractDataObject(String $line): stdClass
    {
        $lineArray = explode(';', $line);
        $lineArray = $this->cleanStrings($lineArray);
        $dataObject = new stdClass;
        $indexCounter = 0;
        foreach ($this->_headers as $header) {
            $dataObject->$header = $lineArray[$indexCounter] != '' ? $lineArray[$indexCounter] : null;
            $indexCounter++;
        }
        return $dataObject;
    }

    /**
     * cleans strings in an array of unicode characters
     *
     *
     * @param Array $data an array that contains strings
     * @return Array
     **/
    private function cleanStrings(array $data): array
    {
        foreach ($data as $index => $datum) {
            // change "\N to blank";
            $data[$index] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $datum);
            $data[$index] = str_replace("\N", '', $data[$index]);
            $data[$index] = str_replace('"', '', $data[$index]);
        }
        return $data;
    }
}
