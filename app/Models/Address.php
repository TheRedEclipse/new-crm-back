<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'address',
        'street',
        'state',
        'city',
        'zip'
    ];

    public static function createWithRelation($data)
    {
        $address = Self::create($data);
        ModelHasAddress::create((array) $data + [
            'address_id' => $address->id
        ]);
        return $address;
    }
}
