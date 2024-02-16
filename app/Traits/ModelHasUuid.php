<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait ModelHasUuid
{
    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->{'uuid'} = (string) Str::uuid()->toString();
        });
    }

    public function initializeHasUuid()
    {
        $this->incrementing = false;
        $this->keyType = 'string';
    }
}
