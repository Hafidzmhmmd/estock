<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserBidang extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_bidang';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
}
