<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'rate',
        'title',
        'description',
        'user_id',
        'sort',
        'place',
        'name',
        'review_link',
        'user_link',
        'social_id'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function social()
    {
        return $this->hasOne(Social::class, 'id', 'social_id')->whereDeletedAt(null);
    }

    public function avatar()
    {
        return $this->morphToMany(
            Attachment::class,
            'model',
            'model_has_attachments',
            'model_id',
            'attachment_id'
        )->where([
            'model_has_attachments.deleted_at' => NULL
        ]);
    }
}
