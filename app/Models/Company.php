<?php

namespace App\Models;

use App\Traits\ModelHasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
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

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_code', 'id');
    }
}
