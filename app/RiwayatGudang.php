<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class RiwayatGudang extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'riwayat_gudang';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    public function hasPengajuan()
    {
        return $this->belongsTo('App\Pengajuan', 'draftcode', 'draftcode');
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y h:i');
    }
}
