<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerAlamat extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function province():BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id', 'province_id');
    }


    public function city():BelongsTo
    {
        return $this->belongsTo(Kota::class, 'city_id', 'city_id');
    }


    public function district():BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'district_id', 'subdistrict_id');
    }
    
}
