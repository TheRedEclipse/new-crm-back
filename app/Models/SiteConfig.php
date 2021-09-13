<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteConfig extends Model
{
    use HasFactory;

    public function logo()
    {
        return $this->morphToMany(
            Attachment::class,
            'model',
            'model_has_attachments',
            'model_id',
            'attachment_id'
        )->where([
            'attachment_type_id' => AttachmentUsageType::getIdByName('Logo'),
            'model_has_attachments.deleted_at' => NULL
        ]);
    }
}
