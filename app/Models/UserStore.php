<?php
namespace ITL\Models;

use Illuminate\Database\Eloquent\Model;

class UserStore extends Model{

    /**
     * Default table name will be `user_stores`,
     * but here our table name is `user_store`,
     * so we have a define a propert called $table and assign the actual table name in order to use non-default table.
     */

    protected $table = 'user_store';
}