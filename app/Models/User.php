<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany, HasMany};
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property-read string $firstName
 * @property-read string $email
 * @property-read string $email_verified_at
 * @property-read string $password
 * @property-read string $remember_token
 * @property-read string $created_at
 * @property-read string $updated_at
 * @property-read int $id
 * @property-read Country $country
 * @property-read Order[] $orders
 * @property-read Product[] $likes
 * @property string $name
 * @property string $avatar
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function likes(): BelongsToMany
    {
        return $this->BelongsToMany(Product::class, 'products_likes');
    }

    protected function firstName(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => ucfirst(str($this->name)->explode(' ')->first())
        );
    }
}
