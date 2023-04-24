<?php
namespace App\Repositories;

use App\DTOs\ProductTypeDTO;
use App\Entities\Entity;

class ProductTypeRepository extends Repository
{
    /**
     * Create the object connection with the database, implemented in the parent
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Returns the insert statement for querying
     *
     * @return string
     */
    protected function getInsertStatement(): string
    {
        return 'INSERT INTO public.product_type(name, tax_percentage)
            VALUES (:name, :tax_percentage)
            RETURNING id;';
    }

    /**
     * Returns the update statement for querying
     *
     * @return string
     */
    protected function getUpdateStatement(): string
    {
        return 'UPDATE public.product_type
            SET name=:name, tax_percentage=:tax_percentage
            WHERE id=:id;';
    }

    /**
     * Returns the select statement for querying
     *
     * @return string
     */
    protected function getListStatement(): string
    {
        return 'SELECT DISTINCT pt.id, pt.name, tax_percentage, CASE WHEN (p.id IS NULL) THEN 1 ELSE 0 END AS allow_delete
        FROM public.product_type pt 
        LEFT JOIN public.product p ON pt.id = p.product_type_id';
    }

    /**
     * Returns the select statement for querying
     *
     * @return string
     */
    protected function getFindByIdStatement(): string
    {
        return 'SELECT DISTINCT pt.id, pt.name, tax_percentage, CASE WHEN (p.id IS NULL) THEN 1 ELSE 0 END AS allow_delete
        FROM public.product_type pt 
        LEFT JOIN public.product p ON pt.id = p.product_type_id
        WHERE pt.id= :id';
    }

    /**
     * Returns the delete statement for querying
     *
     * @return string
     */
    protected function getDeleteByIdStatement(): string
    {
        return 'DELETE FROM public.product_type
        WHERE id=:id;';
    }

    /**
     * Maps the object with the params of the table
     *
     * @param Entity $entity
     * @return array
     */
    protected function getInsertParams(Entity $entity): array
    {
        return [
            'name' => $entity->getName(),
            'tax_percentage' => $entity->getTaxPercentage()
        ];
    }

    /**
     * Maps the object with the params of the table
     *
     * @param Entity $entity
     * @return array
     */
    protected function getUpdateParams(Entity $entity): array
    {
        return [
            'name' => $entity->getName(),
            'tax_percentage' => $entity->getTaxPercentage(),
            'id' => $entity->getId()
        ];
    }

    /**
     * Maps the database results with the entity
     *
     * @param array $result
     * @return Entity
     */
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