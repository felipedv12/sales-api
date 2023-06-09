<?php
namespace App\Controllers;

use App\Services\Service;
use App\Utils\Consts;

abstract class Controller
{
    private Service $service;

    abstract protected function getServiceClass(): string;

    /**
     * Returns an object array
     *
     * @return array
     */
    public function list(): array
    {
        $status = Consts::HTTP_CODE_OK;
        $results = $this->getService()->list();
        if (empty($results['data'])) {
            $status = Consts::HTTP_CODE_NOT_FOUND;
        }
        http_response_code($status);
        return $results;
    }

    /**
     * Returns an array with the object
     *
     * @param integer $id
     * @return array
     */
    public function find(int $id): array
    {
        $status = Consts::HTTP_CODE_OK;
        $results = $this->getService()->find($id);
        if (empty($results['data'])) {
            $status = Consts::HTTP_CODE_NOT_FOUND;
        }
        http_response_code($status);
        return $results;
    }

    /**
     * Creates or updates a register
     *
     * @param string $bodyParams $bodyParams Body params received via POST
     * @param integer $id Optional param ID, 0 means create
     * @return array
     */
    public function save(string $bodyParams, int $id = 0): array
    {
        $validation = $this->getService()->validateParams($bodyParams, $id);
        if ($validation['success']) {
            $result = $this->getService()->preparePersist($validation['data']);
            http_response_code($result['code']);
            return $result;
        }
        http_response_code($validation['code']);
        return $validation;
    }

    /**
     * Delete a register from the database
     *
     * @param integer $id
     * @return array
     */
    public function delete(int $id): array
    {
        $validation = $this->getService()->validateDelete($id);
        if ($validation['success']) {
            $results = $this->getService()->delete($id);
            http_response_code($results['code']);
            return $results;
        }
        http_response_code($validation['code']);
        return $validation;
    }

    /**
     * Returns an instance of the service
     *
     * @return Service
     */
    protected function getService(): Service
    {
        $serviceClass = $this->getServiceClass();
        if (!isset($this->service)) {
            $this->service = new $serviceClass();
        }
        return $this->service;
    }
}