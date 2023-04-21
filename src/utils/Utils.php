<?php
namespace App\Utils;
use App\Entities\Entity;

class Utils 
{
    public static function getEntityFromArray(array $array, string $entityClass): Entity
    {
        $entity = new $entityClass();
        foreach ($array as $key => $value) {
            if (property_exists($entity, $key)) {
                // Checks if the value is an array
                if (is_array($value)) {
                    $propertyClassMethod = $key . 'Class';
                    //Checks if the custom method exists in the class
                    if (method_exists($entity, $propertyClassMethod)) {
                        $value = self::getEntityFromArray($value, $entity->$propertyClassMethod());
                    }
                }
                $entity->set($key, $value);
            }
        }
        return $entity;
    }
}