<?php
namespace App\Repositories;

use App\DTOs\ProductTypeDTO;
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
        return 'SELECT DISTINCT pt.id, pt.name, tax_percentage, CASE WHEN (p.id IS NULL) THEN 1 ELSE 0 END AS allow_delete
        FROM public.product_type pt 
        LEFT JOIN public.product p ON pt.id = p.product_type_id';
    }

    protected function getFindByIdStatement(): string
    {
        return 'SELECT DISTINCT pt.id, pt.name, tax_percentage, CASE WHEN (p.id IS NULL) THEN 1 ELSE 0 END AS allow_delete
        FROM public.product_type pt 
        LEFT JOIN public.product p ON pt.id = p.product_type_id
        WHERE pt.id= :id';
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
        $dto = new ProductTypeDTO();
        $dto->id = $result['id'];
        $dto->name = $result['name'];
        $dto->taxPercentage = $result['tax_percentage'];
        $dto->allowDelete = $result['allow_delete'];
        
        return $dto->toEntity();
    }
}