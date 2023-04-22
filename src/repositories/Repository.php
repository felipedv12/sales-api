<?php

namespace App\Repositories;

use App\Entities\Entity;
use App\Utils\Consts;
use Config\Database;
use Exception;
use PDO;
use PDOException;

abstract class Repository
{
    protected PDO $db;

    protected bool $success;
    protected ?string $message;
    protected mixed $data;
    protected ?int $code;


    public function __construct()
    {
        $driver = Database::DB_DRIVER;
        $host = Database::DB_HOST;
        $port = Database::DB_PORT;
        $dbname = Database::DB_NAME;
        $user = Database::DB_USER;
        $password = Database::DB_PASSWORD;

        $connectionString = "{$driver}:host={$host};port={$port};dbname={$dbname};user={$user};password={$password}";
        $this->connect($connectionString);
    }

    private function connect(string $connectionString)
    {
        try {
            $this->db = new PDO($connectionString);
        } catch (PDOException $e) {
            http_response_code(500);
            $data = ['success' => false, 'data' => null, 'message' => 'Error connecting to database, try again in a few minutes. ->' . $e->getMessage()];
            echo (json_encode($data));
            throw new Exception('Error connecting to database: ' . $e->getMessage());
        }
    }

    /**
     * Gets a list of rows of the table
     *
     * @param array $conditions Optional array with the format: ['field','operator', 'value']
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

            $this->data = array_map(function ($result) {
                return $this->getListMapping($result)->toDTO();
            }, $results);

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
     * Find a row searching by the ID
     *
     * @param integer $id
     * @return array
     */
    public function findById(mixed $id, string $idColumn = 'id'): array
    {
        $this->initializeRepositoryProperties();
        try {
            $statement = $this->db->prepare($this->getFindByIdStatement());
            $statement->execute([$idColumn => $id]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $this->data = $this->getListMapping($result)->toDTO();
            } else {
                $this->code = Consts::HTTP_CODE_NOT_FOUND;
                $this->message = 'ID not found on database';
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
     * Insert row in the table
     *
     * @param Entity $entity
     * @return array
     */
    public function create(Entity $entity): array
    {
        $this->initializeRepositoryProperties();
        try {
            $statement = $this->db->prepare($this->getInsertStatement());
            $statement->execute($this->getInsertParams($entity));
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->findById($result['id']);
            if (!empty($this->data)) {
                $this->code = Consts::HTTP_CODE_CREATED;
            }
        } catch (PDOException $e) {
            $message = 'Error connecting to database: ' . $e->getMessage();
            $this->setResults(false, $message, Consts::HTTP_CODE_SERVER_ERROR);
            throw new Exception($message);
        } catch (Exception $e) {
            $message = 'Error creating product type: ' . $e->getMessage();
            $this->setResults(false, $message, Consts::HTTP_CODE_SERVER_ERROR);
            throw new Exception($message);
        } finally {
            return $this->getResults();
        }
        return [];
    }

    /**
     * Update an object in the table
     *
     * @param Entity $entity
     * @return array
     */
    public function update(Entity $entity): array
    {
        $this->initializeRepositoryProperties();
        try {
            $statement = $this->db->prepare($this->getUpdateStatement());
            $statement->execute($this->getUpdateParams($entity));

            $this->findById($entity->getId())['data'];
        } catch (PDOException $e) {
            $message = 'Error connecting to database: ' . $e->getMessage();
            $this->setResults(false, $message, Consts::HTTP_CODE_SERVER_ERROR);
            throw new Exception($message);
        } catch (Exception $e) {
            $message = 'Error updating product type: ' . $e->getMessage();
            $this->setResults(false, $message, Consts::HTTP_CODE_SERVER_ERROR);
            throw new Exception($message);
        } finally {
            return $this->getResults();
        }
        return [];
    }

    /**
     * Delete a row from table
     *
     * @param integer $id
     * @return array
     */
    public function deleteById(mixed $id, string $idColumn = 'id'): array
    {
        $this->initializeRepositoryProperties();
        $this->data = [$idColumn => $id];
        try {
            $statement = $this->db->prepare($this->getDeleteByIdStatement());
            $statement->execute([
                $idColumn => $id
            ]);

        } catch (PDOException $e) {
            $message = 'Error connecting to database: ' . $e->getMessage();
            $this->setResults(false, $message, Consts::HTTP_CODE_SERVER_ERROR);
            throw new Exception($message);
        } catch (Exception $e) {
            $message = 'Error deleting product type: ' . $e->getMessage();
            $this->setResults(false, $message, Consts::HTTP_CODE_SERVER_ERROR);
            throw new Exception($message);
        } finally {
            return $this->getResults();
        }
        return [];
    }

    protected function getWhereAndParams(array $conditions): array
    {
        $where = '';
        $params = [];
        $isFirstParam = true;
        foreach ($conditions as $condition) {
            if ($isFirstParam) {
                $where = ' WHERE ' . $condition['field'] . $condition['operator'] . ':' . $condition['field'];
            } else {
                $where .= ' AND ' . $condition['field'] . $condition['operator'] . ':' . $condition['field'];
            }
            $params[$condition['field']] = $condition['value'];
        }

        return ['where' => $where, 'params' => $params];
    }

    protected function initializeRepositoryProperties(): void
    {
        $this->success = true;
        $this->message = null;
        $this->code = Consts::HTTP_CODE_OK;
        $this->data = null;
    }

    protected function setResults(bool $success, string $message, int $code)
    {
        $this->success = $success;
        $this->message = $message;
        $this->code = $code;
    }

    protected function getResults(): array
    {
        return ['code' => $this->code, 'success' => $this->success, 'data' => $this->data, 'message' => $this->message];
    }

    /**
     * Returns the insert statement
     *
     * @return string
     */
    abstract protected function getInsertStatement(): string;

    abstract protected function getUpdateStatement(): string;

    abstract protected function getListStatement(): string;

    abstract protected function getFindByIdStatement(): string;

    abstract protected function getDeleteByIdStatement(): string;

    abstract protected function getInsertParams(Entity $entity): array;

    abstract protected function getUpdateParams(Entity $entity): array;

    abstract protected function getListMapping(array $result): Entity;
}