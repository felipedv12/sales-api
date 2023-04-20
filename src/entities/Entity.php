<?php
namespace App\Entities;

interface Entity 
{
    public function toArray() : array;

    public function set(string $property, mixed $value) : void;
}
