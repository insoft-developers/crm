<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Supplier extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function province():BelongsTo
    {
        return $this->belongsTo(Province::class, 'provinsi', 'province_id');
    }


    public function city():BelongsTo
    {
        return $this->belongsTo(Kota::class, 'kota', 'city_id');
    }


    public function district():BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan', 'subdistrict_id');
    }
}
