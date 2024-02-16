<?php

namespace App\Models;

use App\Traits\ModelHasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, ModelHasUuid;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id', 'uuid'
    ];


    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function orderImages()
    {
        return $this->hasMany(OrderImage::class);
    }
}
