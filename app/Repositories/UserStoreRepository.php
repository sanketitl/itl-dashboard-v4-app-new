<?php
namespace ITL\Repositories;

interface UserStoreRepository
{
    /**
     *  Find user_store model by id
     * @param int $id
     * @return mixed
     */
    public function findById(int $id): array|null|string;
}