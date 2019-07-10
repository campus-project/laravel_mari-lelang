<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ProductType.
 *
 * @package namespace App\Entities;
 */
class ProductType extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['can_update','can_delete'];

    /**
     * Get the Auction Products.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function auctionProducts() {
        return $this->hasMany(AuctionProduct::class);
    }

    /**
     * Get the can_update flag for the user.
     *
     * @return bool
     */
    public function getCanUpdateAttribute()
    {
        return true;
    }

    /**
     * Get the can_delete flag for the user.
     *
     * @return bool
     */
    public function getCanDeleteAttribute()
    {
        return $this->auctionProducts()->count() < 1;
    }

}
