<?php
namespace App\Repositories;

use App\Entities\ProductType;
use PDOException;
use Exception;
use PDO;

class ProductTypeRepository extends Repository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll(): array
    {
        try {
            $statement = $this->db->prepare('
                SELECT id, name, tax_percentage
                FROM public.product_type
                ORDER BY name ASC;
            ');
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);

            $productTypes = array_map(function ($result) {
                $productType = new ProductType(
                    $result['name'],
                    $result['tax_percentage'],
                    $result['id']
                );
                return $productType->toArray();
            }, $results);

            return $productTypes;
        } catch (PDOException $e) {
            throw new Exception('Error connecting to database: ' . $e->getMessage());
        }
    }

    public function findByName(string $name): ?ProductType
    {
        try {
            $statement = $this->db->prepare('
                SELECT id, name, tax_percentage
                FROM public.product_type
                WHERE name = :name;
            ');
            $statement->execute(['name' => $name]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if (!$result) {
                return null;
            }

            $productType = new ProductType(
                $result['name'],
                $result['tax_percentage'],
                $result['id']
            );
            return $productType;
        } catch (PDOException $e) {
            throw new Exception('Error connecting to database: ' . $e->getMessage());
        }
    }

    public function create(ProductType $productType): array
    {
        $success = true;
        $message = null;
        $newProductType = null;
        try {
            $statement = $this->db->prepare('
            INSERT INTO public.product_type(name, tax_percentage)
                VALUES (:name, :tax_percentage)
                RETURNING id;'
            );
            $statement->execute([
                'name' => $productType->getName(),
                'tax_percentage' => $productType->getTaxPercentage()
            ]);

            $result = $statement->fetch(PDO::FETCH_ASSOC);

            $rawProductType = new ProductType($productType->getName(), $productType->getTaxPercentage(), $result['id']);
            $newProductType= $rawProductType->toArray();
        } catch (PDOException $e) {
            $success = false;
            $message = 'Error connecting to database: ' . $e->getMessage();
            throw new Exception($message);
        } catch (Exception $e) {
            $success = false;
            $message = 'Error creating product type: ' . $e->getMessage();
            throw new Exception($message);
        } finally {
            return ['success' => $success, 'data' => $newProductType, 'message' => $message];
        }
        return [];
    }

    public function update(ProductType $productType): array
    {
        $success = true;
        $message = null;
        try {
            $statement = $this->db->prepare('
            UPDATE public.product_type
	            SET name=:name, tax_percentage=:tax_percentage
	            WHERE id=:id;'
            );
            $result = $statement->execute([
                'name' => $productType->getName(),
                'tax_percentage' => $productType->getTaxPercentage(),
                'id' => $productType->getId()
            ]);

        } catch (PDOException $e) {
            $success = false;
            $message = 'Error connecting to database: ' . $e->getMessage();
            throw new Exception($message);
        } catch (Exception $e) {
            $success = false;
            $message = 'Error creating product type: ' . $e->getMessage();
            throw new Exception($message);
        } finally {
            return ['success' => $success, 'data' => $productType->toArray(), 'message' => $message];
        }
        return [];
    }
}