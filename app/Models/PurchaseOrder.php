<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'order_number',
        'status',
        'total_amount',
        'order_date',
        'expected_date',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'order_date' => 'date',
        'expected_date' => 'date',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    protected static function booted()
    {
        static::creating(function ($order) {
            $order->order_number = 'PO-' . str_pad(static::max('id') + 1, 6, '0', STR_PAD_LEFT);
            $order->order_date = now()->toDateString();
            $order->status = 'pending';
        });
    }
}
