<?php
namespace App\Repositories;

use App\DTOs\ProductDTO;
use App\Entities\Entity;
use App\Utils\Consts;

class ProductRepository extends Repository
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
        return 'INSERT INTO public.product(
            name, barcode, description, price, product_type_id, created_at, updated_at)
            VALUES (:name, :barcode, :description, :price, :product_type_id, :created_at, :updated_at)
            RETURNING id;';
    }

    /**
     * Returns the update statement for querying
     *
     * @return string
     */
    protected function getUpdateStatement(): string
    {
        return 'UPDATE public.product
        SET name=:name, barcode=:barcode, description=:description, price=:price, product_type_id=:product_type_id, updated_at=:updated_at
        WHERE id=:id;';
    }

    /**
     * Returns the select statement for querying
     *
     * @return string
     */
    protected function getListStatement(): string
    {
        return 'SELECT DISTINCT p.id, p.name, barcode, description, price, product_type_id, p.created_at, p.updated_at, CASE WHEN (si.id IS NULL) THEN 1 ELSE 0 END AS allow_delete
        FROM public.product p 
		LEFT JOIN public.sale_item si ON p.id = si.product_id';
    }

    /**
     * Returns the select statement for querying
     *
     * @return string
     */
    protected function getFindByIdStatement(): string
    {
        return 'SELECT DISTINCT p.id, p.name, barcode, description, price, product_type_id, p.created_at, p.updated_at, CASE WHEN (si.id IS NULL) THEN 1 ELSE 0 END AS allow_delete
        FROM public.product p 
		LEFT JOIN public.sale_item si ON p.id = si.product_id
        WHERE p.id = :id;';
    }

    /**
     * Returns the delete statement for querying
     *
     * @return string
     */
    protected function getDeleteByIdStatement(): string
    {
        return 'DELETE FROM public.product
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
            'barcode' => $entity->getBarcode(),
            'description' => $entity->getDescription(),
            'price' => $entity->getPrice(),
            'product_type_id' => $entity->getProductType()->getId(),
            'created_at' => $entity->getCreatedAt()->format(Consts::DATE_FORMAT_DATABASE),
            'updated_at' => $entity->getUpdatedAt()->format(Consts::DATE_FORMAT_DATABASE)
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
            'barcode' => $entity->getBarcode(),
            'description' => $entity->getDescription(),
            'price' => $entity->getPrice(),
            'product_type_id' => $entity->getProductType()->getId(),
            'updated_at' => $entity->getUpdatedAt()->format(Consts::DATE_FORMAT_DATABASE),
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
    
        $relationRepository = new ProductTypeRepository();
        $productType = $relationRepository->findById($result['product_type_id'])['data'];
        $dto = new ProductDTO();
        $dto->id = $result['id'];
        $dto->name = $result['name'];
        $dto->barcode = $result['barcode'];
        $dto->description = $result['description'];
        $dto->price = $result['price'];
        $dto->productType = $productType;
        $dto->createdAt = $result['created_at'];
        $dto->updatedAt = $result['updated_at'];
        $dto->allowDelete = $result['allow_delete'];
        
        return $dto->toEntity();
    }

}