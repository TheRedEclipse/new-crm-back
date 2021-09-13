<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'created_by_id',
        'user_id',
        'status_id',
        'stage_id',
        'project_stage_date_id',
        'building_type_id',
        'building_stage_id',
        'request_information',
        'attachment_link_sent_at',
        'project_started_at',
    ];

    protected $appends = [
        'lead',
        'address',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->search_fields = [
            'id',
        ];
        $this->order_fields = [
            'id',
        ];
    }

    public static function createWithRelation(array $data)
    {
        $request = Self::create($data);
        ModelHasRequest::create($data + [
            'request_id' => $request->id
        ]);
        return $request;
    }

    public function getAddressAttribute()
    {
        return $this->addresses()->first();
    }

    public function getLeadAttribute() 
    {
        return $this->leads()->first();
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

    public function leads()
    {
        return $this->morphedByMany(
            Lead::class,
            'model',
            'model_has_requests',
            'request_id',
            'model_id',
        );
    }

    public function rooms()
    {
        return $this->hasMany(RequestHasRoom::class, 'request_id')->with('works')->with(['countable' => function($q) {
            return $q->where('count', '>', 0);
        }])->with('roomType')->with('renovationType')->with('styles')->with('styleAttachments');
    }

    public function questions()
    {
        return $this->morphToMany(
            Question::class,
            'model',
            'model_has_questions',
            'model_id',
            'question_id'
        )->with('createdBy')->orderBy('created_at', 'desc');
    }
    
    public function status()
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    public function buildingStage()
    {
        return $this->hasOne(BuildingStage::class, 'id', 'building_stage_id');
    }

    public function buildingType()
    {
        return $this->hasOne(BuildingType::class, 'id', 'building_type_id');
    }

    public function projectStageDate()
    {
        return $this->hasOne(ProjectStageDate::class, 'id', 'project_stage_date_id');
    }

    public function stage()
    {
        return $this->hasOne(RequestStage::class, 'id', 'stage_id');
    }

    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
