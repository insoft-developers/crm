<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Warehouse extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function rprovince():BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id', 'province_id');
    }


    public function rcity():BelongsTo
    {
        return $this->belongsTo(Kota::class, 'city_id', 'city_id');
    }


    public function rdistrict():BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'district_id', 'subdistrict_id');
    }
}
