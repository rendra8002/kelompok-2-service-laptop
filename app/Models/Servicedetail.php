<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicedetail extends Model
{
    use SoftDeletes;

    protected $table = 'servicedetails';
    protected $guarded = [];

    // Relasi ke service item
    public function serviceitem()
    {
        return $this->belongsTo(\App\Models\ServiceItem::class, 'service_type_id')->withTrashed();
    }
}
