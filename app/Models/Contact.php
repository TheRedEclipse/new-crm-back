<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'last_name',
        'phone',
        'email',
        'created_by_id'
    ];

    protected $appends = [
        'address',
    ];

    public function getAddressAttribute() 
    {
        return $this->addresses()->select('address', 'city', 'state', 'street', 'zip')->first();
    }

    public static function createWithAddress(array $data)
    {
        $contact = Contact::create($data);
        Address::createWithRelation($data + [
            'model_type' => Self::class,
            'model_id' => $contact->id,
        ]);
        return $contact;
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

    public function leads()
    {
        return $this->morphedByMany(
            Lead::class,
            'model',
            'model_has_contacts',
            'contact_id',
            'model_id',
        );
    }
}
