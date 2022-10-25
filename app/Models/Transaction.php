<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\PaymentMethod;

class Transaction extends Model
{
    use HasFactory;

    public function Product() {
        return $this->hasOne(Product::class, 'id','product_id');
    }
    public function PaymentMethod() {
        return $this->hasOne(PaymentMethod::class, 'id','payment_method_id');
    }
}
