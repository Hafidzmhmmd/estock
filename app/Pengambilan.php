<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengambilan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pengambilan_barang';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
}
