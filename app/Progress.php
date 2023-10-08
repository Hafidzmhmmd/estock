<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
       /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pengajuan_progress';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
}
