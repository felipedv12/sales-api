<?php
namespace App\Repositories;

use App\Entities\Entity;
use App\Entities\ProductType;

class ProductTypeRepository extends Repository
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getInsertStatement(): string
    {
        return 'INSERT INTO public.product_type(name, tax_percentage)
            VALUES (:name, :tax_percentage)
            RETURNING id;';
    }

    protected function getUpdateStatement(): string
    {
        return 'UPDATE public.product_type
            SET name=:name, tax_percentage=:tax_percentage
            WHERE id=:id;';
    }

    protected function getListStatement(): string
    {
        return 'SELECT id, name, tax_percentage
        FROM public.product_type
        ORDER BY name ASC;';
    }

    protected function getFindByIdStatement(): string
    {
        return 'SELECT id, name, tax_percentage
        FROM public.product_type
        WHERE id = :id;';
    }

    protected function getDeleteByIdStatement(): string
    {
        return 'DELETE FROM public.product_type
        WHERE id=:id;';
    }

    protected function getInsertParams(Entity $entity): array
    {
        return [
            'name' => $entity->getName(),
            'tax_percentage' => $entity->getTaxPercentage()
        ];
    }

    protected function getUpdateParams(Entity $entity): array
    {
        return [
            'name' => $entity->getName(),
            'tax_percentage' => $entity->getTaxPercentage(),
            'id' => $entity->getId()
        ];
    }

    protected function getListMapping(array $result): Entity
    {
        $entity = new ProductType();
        $entity->allParams(
            $result['name'],
            $result['tax_percentage'],
            $result['id']
        );
        return $entity;
    }
}