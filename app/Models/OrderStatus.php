<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $color
 * @property string|null $icon
 */
class OrderStatus extends Model
{
    use HasFactory;

    public const DRAFT = 1;

    public const ORDER_PLACED = 2;

    public const PAYMENT_CONFIRMED = 3;

    public const SHIPPED = 4;

    public const DELIVERED = 5;
}
