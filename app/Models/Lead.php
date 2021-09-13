<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lead extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'created_by_id',
        'lead_referral_source',
        'title',
        'company',
        'industry',
        'phone',
        'status_id',
        'rating',
        'project_type',
        'project_description',
        'budget',
        'current_estimate_budget',
        'contact_initialized_at'
    ];

    protected $appends = [
        'address',
    ];

    public function getAddressAttribute()
    {
        return $this->addresses()->first();
    }

    public static function createWithAddress(array $data)
    {
        $lead = Self::create($data);
        Address::createWithRelation($data + [
            'model_type' => Self::class,
            'model_id' => $lead->id,
        ]);
        return $lead;
    }

    public function addresses()
    {
        return $this->morphToMany(
            Address::class,
            'model',
            'model_has_addresses',
            'model_id',
            'address_id'
        );
    }

    public function notes()
    {
        return $this->morphToMany(
            Note::class,
            'model',
            'model_has_notes',
            'model_id',
            'note_id'
        );
    }

    public function contacts()
    {
        return $this->morphToMany(
            Contact::class,
            'model',
            'model_has_contacts',
            'model_id',
            'contact_id'
        );
    }

    public function questions()
    {
        return $this->morphToMany(
            Question::class,
            'model',
            'model_has_questions',
            'model_id',
            'question_id'
        );
    }

    public function attachments()
    {
        return $this->morphToMany(
            Attachment::class,
            'model',
            'model_has_attachments',
            'model_id',
            'attachment_id'
        );
    }

    public function activities()
    {
        return $this->morphToMany(
            Log::class,
            'model',
            'model_has_logs',
            'model_id',
            'log_id'
        );
    }

    public function tasks()
    {
        return $this->morphToMany(
            Task::class,
            'model',
            'model_has_tasks',
            'model_id',
            'task_id'
        );
    }

    public function requests()
    {
        return $this->morphToMany(
            Request::class,
            'model',
            'model_has_requests',
            'model_id',
            'request_id'
        );
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function status()
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by_id');
    }
}
