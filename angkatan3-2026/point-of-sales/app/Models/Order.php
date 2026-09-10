<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_code',
        'customer_name',
        'payment_method',
        'order_amount',
        'order_change',
        'order_status'
    ];

    // Relasi ke OrderDetail
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    // Scope untuk status
    public function scopePending($query)
    {
        return $query->where('order_status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('order_status', 'completed');
    }

    // Accessor untuk format total
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->order_amount, 0, ',', '.');
    }
}
