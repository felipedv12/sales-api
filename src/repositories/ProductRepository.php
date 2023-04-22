<?php
namespace App\Repositories;

use App\DTOs\ProductDTO;
use App\Entities\Entity;
use App\Entities\Product;
use App\Utils\Consts;

class ProductRepository extends Repository
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getInsertStatement(): string
    {   
        return 'INSERT INTO public.product(
            name, barcode, description, price, product_type_id, created_at, updated_at)
            VALUES (:name, :barcode, :description, :price, :product_type_id, :created_at, :updated_at)
            RETURNING id;';
    }

    protected function getUpdateStatement(): string
    {
        return 'UPDATE public.product
        SET name=:name, barcode=:barcode, description=:description, price=:price, product_type_id=:product_type_id, updated_at=:updated_at
        WHERE id=:id;';
    }

    protected function getListStatement(): string
    {
        return 'SELECT p.id, p.name, barcode, description, price, product_type_id, p.created_at, p.updated_at
        FROM public.product p';
    }

    protected function getFindByIdStatement(): string
    {
        return 'SELECT p.id, p.name, barcode, description, price, product_type_id, pt.name as type_name, pt.tax_percentage, p.created_at, p.updated_at
        FROM public.product p 
        INNER JOIN public.product_type pt ON pt.id = p.product_type_id
        WHERE p.id = :id;';
    }

    protected function getDeleteByIdStatement(): string
    {
        return 'DELETE FROM public.product
        WHERE id=:id;';
    }

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
        
        return $dto->toEntity();
    }

}