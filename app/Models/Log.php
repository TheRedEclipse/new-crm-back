<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\BaseModel;
use App\Models\LogType;
use App\Models\ModelHasLog;

class Log extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'ip',
        'message',
        'user_message',
        'count',
        'type_id',
    ];

    public static function createWithRelation(array $data)
    {
        $log = Self::create($data + [
            'ip' => request()->ip(),
            'type_id' => LogType::getIdByName($data['log_type'])
        ]);
        ModelHasLog::create($data + [
            'log_id' => $log->id
        ]);
    }
}
