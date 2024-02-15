<?php

namespace ITL\Repositories\MySql;
use ITL\Repositories\UserStoreRepository;
use ITL\Serializer\UserStoreSerializer;
use ITL\Config\DbConnect;
use ITL\Models\UserStore;

class UserStoreRepositoryImpl implements UserStoreRepository
{
    /**
     *  Find UserStoreRepositoriesImpl data model by id
     * @param $id
     */

    public function findById(int $id): array|null|string
    {
        return UserStore::select('id','store_url','access_token')
                        ->where('id', $id)
                        ->where('is_deleted',0)
                        ->first();
    }
}