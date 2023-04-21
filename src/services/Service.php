<?php
namespace App\Services;

use App\Entities\Entity;
use App\Repositories\Repository;
use App\Utils\Utils;
use App\Validators\Validator;

abstract class Service
{

    private Repository $repository;
    private Validator $validator;

    /**
     * Returns the repository class in the implemented method
     *
     * @return string
     */
    abstract protected function getRepositoryClass(): string;

    /**
     * Returns the entity class in the implemented method
     *
     * @return string
     */
    abstract protected function getEntityClass(): string;

    /**
     * Returns the validator class in the implemented method
     *
     * @return string
     */
    abstract protected function getValidatorClass(): string;

    /**
     * Receive the request and dispatch to the correct method
     *
     * @param string $bodyParams
     * @param integer $id
     * @return array|null
     */
    public function preparePersist(array $params): array
    {
        $entity = Utils::getEntityFromArray($params, $this->getEntityClass());

        $result = null;
        if ($entity->getId()) {
            $result = $this->update($entity);
        } else {
            $result = $this->create($entity);
        }
        return $result;
    }

    /**
     * Validate the params and returns an array with the results
     *
     * @param string $bodyParams
     * @param integer $id
     * @return array
     */
    public function validateParams(string $bodyParams, int $id): array
    {
        $jsonParams = json_decode($bodyParams, true);
        $jsonParams['id'] = $id;
        $validation = $this->getValidator()->validate($jsonParams, $id);
        return $validation;
    }



    /**
     * Lists all registers of the table
     *
     * @return array Array list of ProductType objects
     */
    public function list(): array
    {
        $results = $this->getRepository()->list();
        return $results;
    }

    /**
     * Get product type by ID
     *
     * @param integer $id
     * @return array
     */
    public function find(int $id): array
    {
        $results = $this->getRepository()->findById($id);
        return $results;
    }

    /**
     * Creates new register on the table
     *
     * @param Entity $entity
     * @return array
     */
    public function create(Entity $entity): array
    {
        $created = $this->getRepository()->create($entity);
        return $created;
    }

    /**
     * Update the register on the table
     *
     * @param Entity $entity
     * @return array
     */
    public function update(Entity $entity): array
    {
        $created = $this->getRepository()->update($entity);
        return $created;
    }

    /**
     * Delete the register on the table
     *
     * @param integer $id
     * @return array
     */
    public function delete(int $id): array
    {
        $deleted = $this->getRepository()->deleteById($id);
        return $deleted;
    }

    public function validateDelete(int $id): array
    {
        $validation = $this->getValidator()->validateDelete($id);
        return $validation;
    }

    /**
     * Returns an instance of the repository
     *
     * @return Repository
     */
    protected function getRepository(): Repository
    {
        $repositoryClass = $this->getRepositoryClass();
        if (!isset($this->repository)) {
            $this->repository = new $repositoryClass();
        }
        return $this->repository;
    }

    /**
     * Returns an instance of the validator class
     *
     * @return Validator
     */
    protected function getValidator(): Validator
    {
        if (!isset($this->validator)) {
            $validatorClass = $this->getValidatorClass();
            $this->validator = new $validatorClass($this->getRepository());
        }
        return $this->validator;
    }

}