<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class AuctionProduct.
 *
 * @package namespace App\Entities;
 */
class AuctionProduct extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'offer',
        'product_type_id',
        'city_id',
        'description',
        'created_by',
        'updated_by'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['can_update','can_delete'];

    /**
     * Get the Created By.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the Updated By.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updatedBy() {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the Product Type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productType() {
        return $this->belongsTo(ProductType::class);
    }

    /**
     * Get the City.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city() {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the Bids.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bids() {
        return $this->hasMany(Bid::class);
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
        return $this->bids()->count() < 1 && $this->users()->count() < 1;
    }
}
