<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\{AsCollection, Attribute};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany, HasMany};
use Illuminate\Support\{Collection, Number};

/**
 * @property int|mixed $amount
 * @property int $brand_id
 * @property int $category_id
 * @property int $id
 * @property Collection $library
 * @property string $name
 * @property float $price
 * @property Category $category
 * @property Brand $brand
 * @property mixed $cover
 */
class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'library' => AsCollection::class,
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'products_likes');
    }

    public function sales(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function carts(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    protected function priceHuman(): Attribute
    {
        return Attribute::make(
            get: fn (?float $value) => $this->price ? Number::currency($this->price) : 0
        );
    }
}
