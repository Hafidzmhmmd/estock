<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gudang extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gudang';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
}
