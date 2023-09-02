<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubKelompok extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'm_subkel_barang';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'subkel_id';
}
