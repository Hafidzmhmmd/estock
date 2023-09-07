<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'm_barang';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    public function SubSubKelompok()
    {
        return $this->belongsTo('App\SubSubKelompok', 'sub_subkel_id', 'sub_subkel_id');
    }
}
