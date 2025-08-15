<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Karyawan extends Model
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

    public function branch():BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function jabatans():BelongsTo
    {
        return $this->belongsTo(Jabatan::class, 'jabatan', 'id');
    }

    public function department():BelongsTo
    {
        return $this->belongsTo(Department::class, 'departemen', 'id');
    }


}
