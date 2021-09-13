<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestWorkType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'icon',
        'type',
        'room_type_id',
    ];

    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function doubleCurrent()
    {
        return $this->morphToMany(
            RequestWorkReplace::class,
            'model',
            'request_work_type_has_request_work_replaces',
            'model_id',
            'replace_id'
        )->where([
            'request_work_type_has_request_work_replaces.type_id' => RequestWorkReplaceType::whereName(['current'])->first()->id
        ]);
    }

    public function doubleReplace()
    {
        return $this->morphToMany(
            RequestWorkReplace::class,
            'model',
            'request_work_type_has_request_work_replaces',
            'model_id',
            'replace_id'
        )->where([
            'request_work_type_has_request_work_replaces.type_id' => RequestWorkReplaceType::whereName(['replace'])->first()->id
        ]);
    }
    


}
