<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'photo',
        'price',
        'qty',  // ← Sudah ada
        'description'
    ];

    // Relasi ke Category (many to one)
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    // Accessor untuk format harga
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    // Scope untuk produk yang aktif (punya stok)
    public function scopeInStock($query)
    {
        return $query->where('qty', '>', 0);
    }

    // Scope untuk produk yang stoknya habis
    public function scopeOutOfStock($query)
    {
        return $query->where('qty', '<=', 0);
    }
}
