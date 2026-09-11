<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'order_qty',
        'order_price',
        'order_subtotal'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    // ← PASTIKAN RELASI INI ADA DAN BENAR
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id')
            ->withDefault([
                'product_name' => 'Product Not Found',
                'product_price' => 0,
            ]);
    }
}
