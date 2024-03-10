<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Support\{Collection, Number};
use Znck\Eloquent\Traits\BelongsToThrough;

/**
 * @property int $id
 * @property int $status_id
 * @property float $total
 * @property Carbon $created_at
 * @property User $user_id
 * @property Collection $items
 * @property Carbon $date_human
 * @property User $user
 */
class Order extends Model
{
    use HasFactory;
    use BelongsToThrough;

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, 'status_id');
    }

    // Shortcut to make easy to sort by country name
    public function country(): \Znck\Eloquent\Relations\BelongsToThrough
    {
        return $this->belongsToThrough(Country::class, User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // The order is a CART, for now.
    public function scopeIsCart(Builder $query): Builder
    {
        return $query->where('status_id', OrderStatus::DRAFT);
    }

    // This is a REAL order, not a CART anymore
    public function scopeIsNotCart(Builder $query): Builder
    {
        return $query->where('status_id', '<>', OrderStatus::DRAFT);
    }

    protected function totalHuman(): Attribute
    {
        return Attribute::make(
            get: fn (?float $value) => Number::currency($this->total)
        );
    }

    protected function dateHuman(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value): ?string => $value instanceof Carbon ? $value->toFormattedDateString() : null
        );
    }
}
