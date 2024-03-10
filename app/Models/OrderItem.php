<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Number;

/**
 * @property float $price
 * @property float $total
 * @property-read string $priceHuman
 * @property-read string $totalHuman
 * @property-read Order $order
 * @property-read Product $product
 * @property-read int $id
 * @property-read string $created_at
 * @property-read string $updated_at
 * @property int $amount
 */
class OrderItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected function priceHuman(): Attribute
    {
        return Attribute::make(
            get: fn (?float $value) => $this->price ? Number::currency($this->price) : 0
        );
    }

    protected function totalHuman(): Attribute
    {
        return Attribute::make(
            get: fn (?float $value) => $this->total ? Number::currency($this->total) : 0
        );
    }
}
