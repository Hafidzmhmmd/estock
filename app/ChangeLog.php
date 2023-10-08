<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChangeLog extends Model
{
       /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stock_change_log';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
}
