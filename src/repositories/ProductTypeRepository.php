<?php
namespace App\Repositories;

use App\Entities\Product;
use App\Entities\ProductType;
use PDO;

class ProductTypeRepository extends Repository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll(): array
    {
        $statement = $this->db->query('
        SELECT id, name, tax_percentage
        FROM public.product_type;');
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(ProductType $productType): ?ProductType
    {
        $statement = $this->db->prepare('
        INSERT INTO public.product_type(name, tax_percentage)
            VALUES (:name, :tax_percentage);'
        );
        $statement->execute([
            'name' => $productType->getName(),
            'tax_percentage' => $productType->getTaxPercentage()
        ]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return null;
        }
        $productType = new ProductType($result['id'], $result['name'], $result['tax_percentage']);
        return $productType;
    }
}