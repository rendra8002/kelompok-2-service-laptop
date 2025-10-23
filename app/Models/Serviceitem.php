<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Serviceitem extends Model
{
    protected $table = 'serviceitems';

    protected $guarded = [];

    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
