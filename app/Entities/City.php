<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class City.
 *
 * @package namespace App\Entities;
 */
class City extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'province_id'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['can_update','can_delete'];

    /**
     * Get the Users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users() {
        return $this->hasMany(User::class);
    }

    /**
     * Get the Auction Product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function auctionProducts() {
        return $this->hasMany(AuctionProduct::class);
    }

    /**
     * Get the parent Province
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province() {
        return $this->belongsTo(Province::class);
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
        return $this->auctionProducts()->count() < 1 && $this->users()->count() < 1;
    }

}
