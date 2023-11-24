<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class RoleMenu extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'role_menu';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
}
