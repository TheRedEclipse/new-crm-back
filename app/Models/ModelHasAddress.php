<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModelHasAddress extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'address_id',
        'model_type',
        'model_id'
    ];

    public function address()
    {
        return $this->hasOne(Address::class, 'id', 'address_id');
    }
}
