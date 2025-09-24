<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GoodReceiveItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id','id');
    }

    public function goodReceive(): BelongsTo
    {
        return $this->belongsTo(GoodReceive::class, 'gr_id', 'id');
    }


    public function retur():HasMany
    {
        return $this->hasMany(StockReturnDetail::class, 'stock_id', 'id');
    }
}
