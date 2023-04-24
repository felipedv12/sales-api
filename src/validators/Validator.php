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

    /**
     * Injects the repository dependency
     *
     * @param Repository $repository
     */
    protected function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Abstract validate method
     *
     * @param array $params
     * @param integer $id
     * @return array
     */
    abstract public function validate(array $params, int $id): array;

    /**
     * Abstract validate delete method
     *
     * @param integer $id
     * @return array
     */
    abstract public function validateDelete(int $id): array;

    /**
     * Initialize the properties that will be used in the validation response
     *
     * @return void
     */
    protected function initializeValidationProperties(): void
    {
        $this->success = true;
        $this->code = Consts::HTTP_CODE_OK;
        $this->errors = [];
    }

    /**
     * Builds the response for validation errors
     *
     * @param integer $code
     * @param string $paramName
     * @param string $message
     * @return void
     */
    protected function validationFail(int $code, string $paramName, string $message): void
    {
        $this->success = false;
        $this->code = $code;
        $this->errors[$paramName]= ['message' => $message];
    }

    /**
     * Validates if the received ID exists in the database
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

    /**
     * Validates if numeric field is empty
     *
     * @param string $paramName
     * @param mixed $paramValue
     * @return void
     */
    protected function validateEmptyNumeric(string $paramName, mixed $paramValue): void
    {
        if ($this->success) {
            if ($paramValue === null) {
                $this->validationFail(Consts::HTTP_CODE_BAD_REQUEST, $paramName, MessagesPT::MESSAGE_NOT_EMPTY);
            }
        }
    }

    /**
     * Validates if string field is empty
     *
     * @param string $paramName
     * @param mixed $paramValue
     * @return void
     */
    protected function validateEmptyString(string $paramName, mixed $paramValue): void
    {
        if ($this->success) {
            if (empty($paramValue)) {
                $this->validationFail(Consts::HTTP_CODE_BAD_REQUEST, $paramName, MessagesPT::MESSAGE_NOT_EMPTY);
            }
        }
    }

    /**
     * Validates if array object is empty
     *
     * @param string $paramName
     * @param array|null $paramValue
     * @return void
     */
    protected function validateEmptyArray(string $paramName, ?array $paramValue): void
    {
        if ($this->success) {
            if (empty($paramValue)) {
                $this->validationFail(Consts::HTTP_CODE_BAD_REQUEST, $paramName, MessagesPT::MESSAGE_NOT_EMPTY);
            }
        }
    }


    /**
     * Validates max characters for strings
     *
     * @param string $paramName
     * @param mixed $paramValue
     * @param integer $maxCharacters
     * @return void
     */
    protected function validateMaxCharacters(string $paramName, mixed $paramValue, int $maxCharacters): void
    {
        if ($this->success) {
            if (strlen($paramValue) > $maxCharacters) {
                $this->validationFail(Consts::HTTP_CODE_BAD_REQUEST, $paramName, MessagesPT::MESSAGE_MAX_CHARACTERS . $maxCharacters);
            }
        }
    }

    /**
     * Validates numeric fields that can be only positive
     *
     * @param string $paramName
     * @param mixed $paramValue
     * @return void
     */
    protected function validatePositiveNumeric(string $paramName, mixed $paramValue): void
    {
        if ($this->success) {
            if ($paramValue < 0) {
                $this->validationFail(Consts::HTTP_CODE_BAD_REQUEST, $paramName, MessagesPT::MESSAGE_MUST_BE_POSITIVE);
            }
        }
    }

    /**
     * Validates if numeric field value is greater than zero
     *
     * @param string $paramName
     * @param mixed $paramValue
     * @return void
     */
    protected function validateGreaterThanZero(string $paramName, mixed $paramValue): void
    {
        if ($this->success) {
            if ($paramValue <= 0) {
                $this->validationFail(Consts::HTTP_CODE_BAD_REQUEST, $paramName, MessagesPT::MESSAGE_GREATER_THAN_ZERO);
            }
        }
    }
    
    /**
     * Validates fields that can't be duplicated 
     *
     * @param string $paramName
     * @param string $field
     * @param mixed $value
     * @param integer $id
     * @return void
     */
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

    /**
     * Returns the validation result
     *
     * @param array $params
     * @return array
     */
    protected function getValidationResults(array $params): array
    {
        return ['code' => $this->code, 'success' => $this->success, 'data' => $params, 'errors' => $this->errors];
    }

}