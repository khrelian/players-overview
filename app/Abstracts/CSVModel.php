<?php

namespace App\Abstracts;

use Illuminate\Database\Eloquent\Model;

abstract class CSVModel extends Model
{

    // the separator character in the csv file
    protected $CSVDelimeter = ';';

    // the CSV file name of the model
    protected $CSVName;

    // the CSV map of the model's properties
    protected $CSVMap;

    abstract public function setCSVName(String $name): void;
    abstract public function setCSVMap(array $map): void;
}
