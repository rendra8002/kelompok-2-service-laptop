<?php

namespace App\Models;

use App\Models\User;
use App\Models\Laptop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';
    protected $guarded = [];

    // Relasi ke service
    // App\Models\Service.php
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function laptop()
    {
        return $this->belongsTo(Laptop::class, 'laptop_id');
    }

    public function details()
    {
        return $this->hasMany(Servicedetail::class, 'service_id');
    }

    // public function payments()
    // {
    //     return $this->hasMany(Payment::class, 'service_id');
    // }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($service) {
            // ambil id terakhir
            $latest = self::latest('id')->first();

            // tentukan nomor berikutnya
            $nextNumber = $latest ? $latest->id + 1 : 1;

            // format: INV-YYYYMMDD-000X
            $service->no_invoice = 'INV-' . now()->format('Ymd') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        });
    }
}
