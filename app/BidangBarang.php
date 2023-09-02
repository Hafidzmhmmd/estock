<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BidangBarang extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'm_bid_barang';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'bid_id';
}
