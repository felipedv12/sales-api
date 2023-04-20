<?php
namespace App\Repositories;

class ProductRepository extends Repository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll(): array
    {
        return [];
    }

    public function findById(int $id): array
    {
        return [];
    }

    public function create(\App\Entities\Entity $entity): array
    {
        return [];
    }

    public function update(\App\Entities\Entity $entity): array
    {
        return [];
    }
    public function delete(int $id): array
    {
        return [];
    }

}