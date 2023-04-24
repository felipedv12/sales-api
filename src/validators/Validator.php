<?php
namespace App\Validators;

use App\Repositories\Repository;
use App\Utils\Consts;
use App\Utils\MessagesPT;

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

    abstract public function validateDelete(int $id): array;
    protected function initializeValidationProperties(): void
    {
        $this->success = true;
        $this->code = Consts::HTTP_CODE_OK;
        $this->errors = [];
    }

    protected function validationFail(int $code, string $paramName, string $message): void
    {
        $this->success = false;
        $this->code = $code;
        $this->errors[$paramName]= ['message' => $message];
    }

    /**
     * Validate if the received ID exists in the database
     *
     * @param integer $id
     * @return void
     */
    protected function validateIfIdExists(int $id): void
    {
        if ($this->success) {
            $result = $this->repository->findById($id);
            if (empty($result['data'])) {
                $this->validationFail(Consts::HTTP_CODE_NOT_FOUND, 'id', MessagesPT::MESSAGE_ID_NOT_FOUND);
            }
        }
    }

    protected function validateEmptyNumeric(string $paramName, mixed $paramValue): void
    {
        if ($this->success) {
            if ($paramValue === null) {
                $this->validationFail(Consts::HTTP_CODE_BAD_REQUEST, $paramName, MessagesPT::MESSAGE_NOT_EMPTY);
            }
        }
    }

    protected function validateEmptyString(string $paramName, mixed $paramValue): void
    {
        if ($this->success) {
            if (empty($paramValue)) {
                $this->validationFail(Consts::HTTP_CODE_BAD_REQUEST, $paramName, MessagesPT::MESSAGE_NOT_EMPTY);
            }
        }
    }

    protected function validateEmptyArray(string $paramName, ?array $paramValue): void
    {
        if ($this->success) {
            if (empty($paramValue)) {
                $this->validationFail(Consts::HTTP_CODE_BAD_REQUEST, $paramName, MessagesPT::MESSAGE_NOT_EMPTY);
            }
        }
    }


    protected function validateMaxCharacters(string $paramName, mixed $paramValue, int $maxCharacters): void
    {
        if ($this->success) {
            if (strlen($paramValue) > $maxCharacters) {
                $this->validationFail(Consts::HTTP_CODE_BAD_REQUEST, $paramName, MessagesPT::MESSAGE_MAX_CHARACTERS . $maxCharacters);
            }
        }
    }

    protected function validatePositiveNumeric(string $paramName, mixed $paramValue): void
    {
        if ($this->success) {
            if ($paramValue < 0) {
                $this->validationFail(Consts::HTTP_CODE_BAD_REQUEST, $paramName, MessagesPT::MESSAGE_MUST_BE_POSITIVE);
            }
        }
    }

    protected function validateGreaterThanZero(string $paramName, mixed $paramValue): void
    {
        if ($this->success) {
            if ($paramValue <= 0) {
                $this->validationFail(Consts::HTTP_CODE_BAD_REQUEST, $paramName, MessagesPT::MESSAGE_GREATER_THAN_ZERO);
            }
        }
    }

    protected function validateUniqueField(string $paramName, string $field, mixed $value, int $id): void
    {
        if ($this->success) {
            $result = $this->repository->list([
                ['field' => $field, 'operator' => '=', 'value' => $value]
            ]);
            if (!empty($result['data'])) {
                foreach($result['data'] as $data){
                    if ($data->id !== $id) {
                        $this->validationFail(Consts::HTTP_CODE_BAD_REQUEST, $paramName, MessagesPT::MESSAGE_ALREADY_EXISTS);
                    }
                }
            }
        }
    }

    protected function getValidationResults(array $params): array
    {
        return ['code' => $this->code, 'success' => $this->success, 'data' => $params, 'errors' => $this->errors];
    }

}