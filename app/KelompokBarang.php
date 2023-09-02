<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KelompokBarang extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'm_kel_barang';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'kel_id';
}
