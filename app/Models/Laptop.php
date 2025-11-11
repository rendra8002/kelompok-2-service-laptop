<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laptop extends Model
{
    use SoftDeletes; // ✅ Tambahkan SoftDeletes

    //table
    protected $table = 'laptops';

    //fillable fields
    protected $guarded = [];

    //relasi
}
