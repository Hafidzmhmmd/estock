<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockGudang extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stock_gudang';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'stock_id';

    public function hasBarang()
    {
        return $this->belongsTo('App\Barang', 'barang_id', 'id');
    }
}
