<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'counter_nomor';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
}
