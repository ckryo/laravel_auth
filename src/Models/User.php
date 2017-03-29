<?php

namespace Ckryo\AdminAuth\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'admin_users';
    protected $connection = 'mysql';
}