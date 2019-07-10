<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Province.
 *
 * @package namespace App\Entities;
 */
class Province extends Model implements Transformable
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
     * Get the Cities.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities() {
        return $this->hasMany(City::class);
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
        return $this->cities()->count() < 1;
    }

}
