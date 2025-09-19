<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function vendor():BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }

    public function alamat():BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'vendor_address_id', 'id');
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'request_user_id', 'id');
    }

    public function payment_methods():BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method','id');
    }

    public function delivery_methods():BelongsTo
    {
        return $this->belongsTo(DeliveryMethod::class, 'delivery_method', 'id');
    }

    public function gudang():BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'vendor_address_id', 'id');
    }

    public function item():HasMany
    {
        return $this->hasMany(PurchaseOrderItem::class, 'purchase_order_id', 'id');
    }
}
