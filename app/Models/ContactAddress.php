<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactAddress extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [

        'zip',
        'address',
        'email',
        'map',
        'phone',
        'latitude',
        'longitude',
    ];

    public function state()
    {
        return $this->hasOne(State::class, 'id', 'state_id')->whereDeletedAt(null);
    }
}
