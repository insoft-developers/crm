<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicle extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function merk(): BelongsTo
    {
        return $this->belongsTo(VehicleMerk::class, 'merk_id', 'id');
    }

    public function jenis():BelongsTo
    {
        return $this->belongsTo(VehicleJenis::class, 'jenis_id', 'id');
    }

    public function type():BelongsTo
    {
        return $this->belongsTo(VehicleType::class, 'type_id', 'id');
    }

    public function locations():BelongsTo
    {
        return $this->belongsTo(Location::class, 'location', 'id');
    }


    public function insurance():BelongsTo
    {
        return $this->belongsTo(InsuranceCompany::class, 'insurance_company_id', 'id');
    }

    
}
