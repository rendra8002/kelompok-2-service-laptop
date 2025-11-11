<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Service;
use App\Models\ServiceItem;


class ServiceDetail extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'servicedetails';

    // Kolom yang boleh diisi mass-assignment
    protected $fillable = [
        'service_id',
        'service_type_id',
        'price',
    ];

    // Relasi ke Service
    // App\Models\Servicedetail.php
    public function serviceType()
    {
        return $this->belongsTo(ServiceItem::class, 'service_type_id');
    }
}
