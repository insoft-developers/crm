<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GoodReceive extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function vendor():BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }


    public function warehouse():BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id', 'id');
    }

    public function item():HasMany
    {
        return $this->hasMany(GoodReceiveItem::class, 'gr_id', 'id');
    }


    public function payment_methods():BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id','id');
    }

    public function delivery_methods():BelongsTo
    {
        return $this->belongsTo(DeliveryMethod::class, 'delivery_method_id', 'id');
    }
}
