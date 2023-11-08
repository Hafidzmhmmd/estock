<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GolonganBarang extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'm_gol_barang';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'gol_id';
}
