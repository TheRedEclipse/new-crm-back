<?php

namespace App\Services;

use App\Models\Attachment;
use App\Models\AttachmentUsageType;
use App\Models\ModelHasAttachment;
use Illuminate\Support\Facades\Request;
use Spatie\Valuestore\Valuestore;

class SiteConfigService
{

    public function __construct()
    {
        $this->valueStore = Valuestore::make(storage_path('siteconfig.json'));
    }

    public function index()
    {
        $model = ModelHasAttachment::where([
            'attachment_type_id' => AttachmentUsageType::getIdByName('Logo'),
            'model_type' => 'SiteConfig',
            'model_id' => '1',
            'deleted_at' => NULL
            ])->first();

        return [
            'settings' => $this->valueStore->all(),
            'logo' => $model ? Attachment::where('id', $model->attachment_id)->first() : null
        ];
    }

    public function store(object $request)
    {
        // $this->valueStore->put([
        //     'title' => $request->title ?? $this->valueStore->get('title'),
        //     'email' => $request->email ?? $this->valueStore->get('email'),
        //     'link_terms' => $request->link_terms ?? $this->valueStore->get('link_terms'),
        //     'link_policy' => $request->link_policy ?? $this->valueStore->get('link_policy'),
        //     'states' => $request->states ?? $this->valueStore->get('states'),
        // ]);

        $this->valueStore->put(
            array_merge(
                $this->valueStore->all(),
                $request->all()
            )
        );

        if ($request->logo) {

            $logoId = AttachmentUsageType::getIdByName('Logo');

            ModelHasAttachment::where(['attachment_type_id' => $logoId, 'model_type' => 'SiteConfig', 'model_id' => '1'])->delete();

              Attachment::createWithRelation((array) $request + [
              'model_id' => 1,
              'model_type' => 'SiteConfig',
              'attachment_type_id' => $logoId,
              'url' => $request->logo['url'],
              'path'  => $request->logo['path']
          ]);

        } 

    }

}
