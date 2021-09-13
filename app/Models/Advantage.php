<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advantage extends Model
{
    use HasFactory;

    protected $fillable = [
        'advantage_type_id',
        'title',
        'description',
        'sort'
    ];

    public function AdvantageType()
    {
        return $this->hasOne(AdvantageType::class, 'id', 'advantage_type_id');
    }
}
