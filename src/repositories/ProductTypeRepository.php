<?php
namespace App\Repositories;

use App\Entities\Entity;
use App\Entities\ProductType;
use App\Utils\Consts;
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
        $productTypes = null;
        $success = true;
        $message = null;
        try {
            $statement = $this->db->prepare('
                SELECT id, name, tax_percentage
                FROM public.product_type
                ORDER BY name ASC;
            ');
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);

            $productTypes = array_map(function ($result) {
                $productType = new ProductType();
                $productType->allParams(
                    $result['name'],
                    $result['tax_percentage'],
                    $result['id']
                );
                return $productType->toArray();
            }, $results);
        } catch (PDOException $e) {
            $message = 'Error connecting to database: ' . $e->getMessage();
            throw new Exception($message);
        } finally {
            return ['success' => $success, 'data' => $productTypes, 'message' => $message];
        }
        return [];
    }

    public function findByName(string $name): array
    {
        $productType = null;
        $success = true;
        $message = null;
        try {
            $statement = $this->db->prepare('
                SELECT id, name, tax_percentage
                FROM public.product_type
                WHERE name = :name;
            ');
            $statement->execute(['name' => $name]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $productType = new ProductType();
                $productType->allParams(
                    $result['name'],
                    $result['tax_percentage'],
                    $result['id']
                );
            }
        } catch (PDOException $e) {
            $message = 'Error connecting to database: ' . $e->getMessage();
            throw new Exception($message);
        } finally {
            return ['success' => $success, 'data' => $productType, 'message' => $message];
        }
        return [];
    }

    public function findById(int $id): array
    {
        $success = true;
        $message = null;
        $foundProductType = null;
        try {
            $statement = $this->db->prepare('
                SELECT id, name, tax_percentage
                FROM public.product_type
                WHERE id = :id;
            ');
            $statement->execute(['id' => $id]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $productType = new ProductType();
                $productType->allParams(
                    $result['name'],
                    $result['tax_percentage'],
                    $result['id']
                );
                $foundProductType = $productType->toArray();
            }
        } catch (PDOException $e) {
            $message = 'Error connecting to database: ' . $e->getMessage();
            throw new Exception($message);
        } finally {
            return ['success' => $success, 'data' => $foundProductType, 'message' => $message];
        }
        return [];
    }

    public function create(Entity $entity): array
    {
        $productType = $entity;
        $success = true;
        $message = null;
        $code = Consts::HTTP_CODE_CREATED;
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

            $rawProductType = new ProductType();
            $rawProductType->allParams($productType->getName(), $productType->getTaxPercentage(), $result['id']);
            $newProductType = $rawProductType->toArray();
        } catch (PDOException $e) {
            $success = false;
            $code = Consts::HTTP_CODE_SERVER_ERROR;
            $message = 'Error connecting to database: ' . $e->getMessage();
            throw new Exception($message);
        } catch (Exception $e) {
            $success = false;
            $code = Consts::HTTP_CODE_SERVER_ERROR;
            $message = 'Error creating product type: ' . $e->getMessage();
            throw new Exception($message);
        } finally {
            return ['code' => $code, 'success' => $success, 'data' => $newProductType, 'message' => $message];
        }
        return [];
    }

    public function update(Entity $entity): array
    {
        $productType = $entity;
        $success = true;
        $code = Consts::HTTP_CODE_OK;
        $message = null;
        try {
            $statement = $this->db->prepare('
            UPDATE public.product_type
	            SET name=:name, tax_percentage=:tax_percentage
	            WHERE id=:id;'
            );
            $statement->execute([
                'name' => $productType->getName(),
                'tax_percentage' => $productType->getTaxPercentage(),
                'id' => $productType->getId()
            ]);

        } catch (PDOException $e) {
            $success = false;
            $code = Consts::HTTP_CODE_SERVER_ERROR;
            $message = 'Error connecting to database: ' . $e->getMessage();
            throw new Exception($message);
        } catch (Exception $e) {
            $success = false;
            $code = Consts::HTTP_CODE_SERVER_ERROR;
            $message = 'Error updating product type: ' . $e->getMessage();
            throw new Exception($message);
        } finally {
            return ['code' => $code, 'success' => $success, 'data' => $productType->toArray(), 'message' => $message];
        }
        return [];
    }

    public function delete(int $id): array
    {
        $success = true;
        $message = null;
        try {
            $statement = $this->db->prepare('
            DELETE FROM public.product_type
	            WHERE id=:id;'
            );
            $statement->execute([
                'id' => $id
            ]);

        } catch (PDOException $e) {
            $success = false;
            $message = 'Error connecting to database: ' . $e->getMessage();
            throw new Exception($message);
        } catch (Exception $e) {
            $success = false;
            $message = 'Error deleting product type: ' . $e->getMessage();
            throw new Exception($message);
        } finally {
            return ['success' => $success, 'data' => ['product-type-id' => $id], 'message' => $message];
        }
        return [];
    }
}