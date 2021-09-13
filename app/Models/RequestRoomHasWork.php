<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestRoomHasWork extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'work_type_id',
        'work_action_id',
        'quantity',
        'double_current_id',
        'double_replace_id'
    ];

    public function workType()
    {
        return $this->hasOne(RequestWorkType::class, 'id', 'work_type_id');
    }
    
    public function workAction()
    {
        return $this->hasOne(RequestWorkAction::class, 'id', 'work_action_id');
    }

    public function doubleCurrent()
    {
        return $this->hasOne(RequestWorkReplace::class, 'id', 'double_current_id');
    }

    public function doubleReplace()
    {
        return $this->hasOne(RequestWorkReplace::class, 'id', 'double_replace_id');
    }
}
