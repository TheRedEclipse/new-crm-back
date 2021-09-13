<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'parent_id',
        'expired_at',
        'created_by_id',
        'status_id',
    ];

    public static function createWithRelation(array $data)
    {
        $task = Self::create($data);
        ModelHasTask::create($data + [
            'task_id' => $task->id
        ]);
        return $task;
    }

    public function status()
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    public function parent()
    {
        return $this->hasOne(Self::class, 'id', 'parent_id');
    }

    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by_id');
    }
}
