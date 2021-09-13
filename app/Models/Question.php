<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'description',
        'status_id',
        'type_id',
        'created_by_id',
    ];

    public static function createWithRelation(array $data)
    {
        $question = Self::create($data);
        ModelHasQuestion::create($data + [
            'question_id' => $question->id
        ]);
        return $question;
    }

    public function status()
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    public function type()
    {
        return $this->hasOne(QuestionType::class, 'id', 'type_id');
    }

    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by_id');
    }
}
