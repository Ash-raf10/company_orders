<?php

namespace App\Models;

use App\Traits\ModelHasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderImage extends Model
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
}
