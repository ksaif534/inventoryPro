<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'type',
        'quantity',
        'before_quantity',
        'after_quantity',
        'reference',
        'notes',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public static function createMovement($productId, $type, $quantity, $reference = null, $notes = null)
    {
        $product = Product::findOrFail($productId);
        $beforeQuantity = $product->quantity;

        if ($type === 'in') {
            $afterQuantity = $beforeQuantity + $quantity;
        } elseif ($type === 'out') {
            $afterQuantity = max(0, $beforeQuantity - $quantity);
        } else { // adjustment
            $afterQuantity = $quantity;
        }

        $product->update(['quantity' => $afterQuantity]);

        return static::create([
            'product_id' => $productId,
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'type' => $type,
            'quantity' => $quantity,
            'before_quantity' => $beforeQuantity,
            'after_quantity' => $afterQuantity,
            'reference' => $reference,
            'notes' => $notes,
        ]);
    }
}
