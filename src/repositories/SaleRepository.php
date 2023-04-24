<?php
namespace App\Repositories;

use App\DTOs\ProductDTO;
use App\DTOs\ProductTypeDTO;
use App\DTOs\SaleDTO;
use App\DTOs\SaleItemDTO;
use App\Entities\Entity;
use App\Utils\Consts;
use Exception;
use PDO;
use PDOException;

class SaleRepository extends Repository
{

    private SaleItemRepository $relationRepository;

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
        return 'INSERT INTO public.sale(
            total_product_value, total_tax_value, created_at, updated_at)
            VALUES (:total_product_value, :total_tax_value,  :created_at, :updated_at)
            RETURNING id;';
    }

    /**
     * Returns the update statement for querying
     *
     * @return string
     */
    protected function getUpdateStatement(): string
    {
        return 'UPDATE public.sale
        SET total_product_value=:total_product_value, total_tax_value=:total_tax_value, updated_at=:updated_at
        WHERE id=:id;';
    }

    /**
     * Returns the select statement for querying
     *
     * @return string
     */
    protected function getListStatement(): string
    {
        return 'SELECT s.id, s.total_product_value, s.total_tax_value, s.created_at, s.updated_at, 
        si.id as item_id, si.item_number, si.sold_amount, si.product_value, si.tax_value,
        p.id as product_id, p.name, p.barcode, p.description, p.price, p.created_at as product_created_at, p.updated_at AS product_updated_at,
        pt.id as type_id, p.name as type_name, pt.tax_percentage
        FROM public.sale s 
        INNER JOIN public.sale_item si ON s.id = si.sale_id
        INNER JOIN public.product p ON si.product_id = p.id
        INNER JOIN public.product_type pt ON p.product_type_id = pt.id';
    }

    /**
     * Returns the select statement for querying
     *
     * @return string
     */
    protected function getFindByIdStatement(): string
    {
        return 'SELECT s.id, s.total_product_value, s.total_tax_value, s.created_at, s.updated_at
        FROM public.sale s 
        WHERE s.id = :id;';
    }

    /**
     * Returns the delete statement for querying
     *
     * @return string
     */
    protected function getDeleteByIdStatement(): string
    {
        return 'DELETE FROM public.sale
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
            'total_product_value' => $entity->getTotalProductValue(),
            'total_tax_value' => $entity->getTotalTaxValue(),
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
            'total_product_value' => $entity->getTotalProductValue(),
            'total_tax_value' => $entity->getTotalTaxValue(),
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
        $dto = new SaleDTO();
        $dto->id = $result['id'];
        $dto->totalProductValue = $result['total_product_value'];
        $dto->totalTaxValue = $result['total_tax_value'];
        $dto->createdAt = $result['created_at'];
        $dto->updatedAt = $result['updated_at'];

        return $dto->toEntity();
    }

    /**
     * Overrides the parent method, queries the table
     *
     * @param array $conditions
     * @return array
     */
    public function list(array $conditions = []): array
    {

        $this->initializeRepositoryProperties();

        $where = $this->getWhereAndParams($conditions);
        try {
            $statement = $this->db->prepare($this->getListStatement() . $where['where']);
            $statement->execute($where['params']);
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            $this->data = $this->getMappingSale($results);
            if (!$this->data) {
                $this->code = Consts::HTTP_CODE_NOT_FOUND;
            }
        } catch (PDOException $e) {
            $message = 'Error connecting to database: ' . $e->getMessage();
            $this->setResults(false, $message, Consts::HTTP_CODE_SERVER_ERROR);
            throw new Exception($message);
        } finally {
            return $this->getResults();
        }
        return [];
    }

    /**
     * Maps the results with the entity
     *
     * @param array $results
     * @return array
     */
    private function getMappingSale(array $results): array
    {
        $sales = [];
        $items = [];
        foreach ($results as $row) {
            // creates the partial DTO
            $saleDTO = new SaleDTO();
            $saleDTO->id = $row['id'];
            $saleDTO->totalProductValue = $row['total_product_value'];
            $saleDTO->totalTaxValue = $row['total_tax_value'];
            $saleDTO->createdAt = $row['created_at'];
            $saleDTO->updatedAt = $row['updated_at'];

            // if index doesn't exists, is a new item
            if (!isset($sales[$saleDTO->id])) {
                $entity = $saleDTO->toEntity();
                $saleDTO->createdAt = $entity->getCreatedAt()->format(Consts::DATE_FORMAT_EXIBITION);
                $saleDTO->updatedAt = $entity->getUpdatedAt()->format(Consts::DATE_FORMAT_EXIBITION);
                
                $sales[$saleDTO->id] = $saleDTO;
            }

            $productTypeDTO = new ProductTypeDTO();
            $productTypeDTO->id = $row['type_id'];
            $productTypeDTO->name = $row['type_name'];
            $productTypeDTO->taxPercentage = $row['tax_percentage'];

            $productDTO = new ProductDTO();
            $productDTO->id = $row['product_id'];
            $productDTO->name = $row['name'];
            $productDTO->barcode = $row['barcode'];
            $productDTO->description = $row['description'];
            $productDTO->price = $row['price'];
            $productDTO->createdAt = $row['product_created_at'];
            $productDTO->updatedAt = $row['product_updated_at'];
            $productDTO->productType = $productTypeDTO;

            $saleItemDTO = new SaleItemDTO();
            $saleItemDTO->id = $row['item_id'];
            $saleItemDTO->itemNumber = $row['item_number'];
            $saleItemDTO->soldAmount = $row['sold_amount'];
            $saleItemDTO->productValue = $row['product_value'];
            $saleItemDTO->taxValue = $row['tax_value'];
            $saleItemDTO->product = $productDTO;
            if (!isset($items[$saleDTO->id][$saleItemDTO->itemNumber])) {
                $items[$saleDTO->id][$saleItemDTO->itemNumber] = $saleItemDTO;
            }
            $sales[$saleDTO->id]->items = $items[$saleDTO->id];
        }

        $resultArray = [];
        $resultItems = [];
        foreach($sales as $sale) {
            foreach($sale->items as $item){
                array_push($resultItems, $item);
            }
            $sale->items = $resultItems;
            array_push($resultArray, $sale);
            
            $resultItems = [];
        }
        return $resultArray;
    }
}