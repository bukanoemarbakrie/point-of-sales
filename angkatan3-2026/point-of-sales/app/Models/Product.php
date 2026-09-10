<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'product_name',         // ← Sesuai ERD
        'product_photo',        // ← Sesuai ERD
        'product_price',        // ← Sesuai ERD
        'product_description',  // ← Sesuai ERD
        'qty',
        'is_active'
    ];

    // Relasi ke Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    // Relasi ke OrderDetail
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'product_id', 'id');
    }

    // Accessor untuk format harga
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->product_price, 0, ',', '.');
    }

    // Scope untuk produk aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    // Scope untuk produk yang ada stok
    public function scopeInStock($query)
    {
        return $query->where('qty', '>', 0);
    }
}
