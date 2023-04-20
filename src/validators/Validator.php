<?php
namespace App\Validators;

use App\Repositories\Repository;
use App\Utils\Consts;

abstract class Validator
{
    protected Repository $repository;
    protected bool $success;
    protected array $errors;
    protected int $code;

    protected function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    abstract public function validate(array $params, int $id): array;

    protected function initializeValidationProperties() : void 
    {
        $this->success = true;
        $this->code = Consts::HTTP_CODE_OK;
        $this->errors = [];
    }

    private function validationFail(int $code, string $paramName, string $message): void
    {
        $this->success = false;
        $this->code = $code;
        $this->errors[$paramName][] = ['message' => $message];
    }

    /**
     * Validate if the received ID exists in the database
     *
     * @param integer $id
     * @return void
     */
    protected function validateIfIdExists(int $id): void
    {
        $result = $this->repository->findById($id);
        if (empty($result['data'])) {
            $this->validationFail(Consts::HTTP_CODE_NOT_FOUND, 'id', 'ID not found in database.');
        }
    }

    protected function validateEmptyNumeric(string $paramName, mixed $paramValue): void
    {
        if ($paramValue === null) {
            $this->validationFail(Consts::HTTP_CODE_BAD_REQUEST, $paramName, 'Must not be empty.');
        }
    }

    protected function validateEmptyString(string $paramName, ?string $paramValue): void
    {
        if (empty($paramValue)) {
            $this->validationFail(Consts::HTTP_CODE_BAD_REQUEST, $paramName, 'Must not be empty.');
        }

    }

    protected function validateMaxCharacters(string $paramName, string $paramValue, int $maxCharacters): void
    {
        if (strlen($paramValue) > 100) {
            $this->validationFail(Consts::HTTP_CODE_BAD_REQUEST, $paramName, 'Max size is {$maxCharacters} characters.');
        }
    }

    protected function validatePositiveNumeric(string $paramName, string $paramValue): void 
    {
        if ($paramValue < 0) {
            $this->validationFail(Consts::HTTP_CODE_BAD_REQUEST, $paramName, 'Must not be negative.');
        }
    }

}