<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['name', "customer_id", "delivery_id"];



    public function products()
    {
        return $this->hasMany(ProductsOrder::class);
    }

}
