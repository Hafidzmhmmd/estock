<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubSubKelompok extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'm_sub_subkel_barang';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'sub_subkel_id';
}
