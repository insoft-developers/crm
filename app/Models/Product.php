<?php

namespace App\Models;

use App\Services\ProductCodeGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id'];



    public static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            // Jika kode belum diisi, generate otomatis
            if (empty($product->product_code)) {
                $product->product_code = ProductCodeGenerator::generate('PRD', 5);
            }
        });
    }
}
