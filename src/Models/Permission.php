<?php

namespace Ckryo\AdminAuth\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'admin_permissions';
    protected $connection = 'mysql';
    public $timestamps = false;
}
