<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class AuctionProductPhoto.
 *
 * @package namespace App\Entities;
 */
class AuctionProductPhoto extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'auction_product_id',
        'photo_url'
    ];

    /**
     * Get the Auction Product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function auctionProduct() {
        return $this->belongsTo(AuctionProduct::class);
    }

}
