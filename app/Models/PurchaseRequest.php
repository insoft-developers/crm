<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseRequest extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'request_user_id', 'id');
    }

    public function item():HasMany
    {
        return $this->hasMany(PurchaseRequestItem::class, 'purchase_id', 'id');
    }
}
