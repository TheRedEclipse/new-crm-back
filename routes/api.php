<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Api\v1', 'prefix' => 'v1'], function () {
    Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function () {
        Route::post('login', 'LoginController@login');
        Route::post('logout', 'LoginController@logout');
        Route::post('refresh', 'LoginController@refresh');
        Route::post('me', 'LoginController@me');
    });

    Route::group(['prefix' => 'handler'], function () {
        Route::post('image/{type?}', 'DynamicContentController@loadImage');
        Route::get('resize/{id}', 'DynamicContentController@resizeImage');
    });

    Route::group(['namespace' => 'Control', 'prefix' => 'control'], function () {
        Route::resource('users', 'UserController');
        Route::get('permissions/all', 'PermissionController@all');
        Route::resource('permissions', 'PermissionController', ['except' => ['edit']]);
        Route::get('roles/all', 'RoleController@all');
        Route::resource('roles', 'RoleController', ['except' => ['edit']]);

        Route::resource('contacts/addresses', 'ContactAddressController');

        Route::get('socials/all', 'SocialController@all');
        Route::resource('socials', 'SocialController');

        Route::get('solutions/all', 'SolutionController@all');
        Route::resource('solutions', 'SolutionController', ['except' => ['edit', 'create']]);
    
        Route::get('materials/all', 'MaterialController@all');
        Route::resource('materials', 'MaterialController', ['except' => ['edit', 'create']]);
    
        Route::get('works/all', 'WorkController@all');
        Route::resource('works', 'WorkController', ['except' => ['edit', 'create']]);
    
        Route::get('advantages/all', 'AdvantageController@all');
        Route::resource('advantages', 'AdvantageController', ['except' => ['edit', 'create']]);
    
        Route::get('reviews/all', 'ReviewController@all');
        Route::resource('reviews', 'ReviewController', ['except' => ['edit', 'create']]);
    
        Route::get('services/all', 'ServiceOfferController@all');
        Route::resource('services', 'ServiceOfferController', ['except' => ['edit', 'create']]);
    
        Route::get('pages/all', 'PageController@all');
        Route::resource('pages', 'PageController', ['except' => ['edit', 'create']]);
    
        Route::get('sliders/all', 'SliderController@all');
        Route::resource('sliders', 'SliderController', ['except' => ['edit', 'create']]);

        Route::get('slides/all', 'SlideController@all');
        Route::get('slides/type', 'SlideController@byType');
        Route::resource('slides', 'SlideController', ['except' => ['edit', 'create']]);

        Route::resource('text-items', 'TextItemController', ['except' => ['edit', 'create']]);

        Route::get('page-types/all', 'PageTypeController@all');
        Route::resource('page-types', 'PageTypeController', ['except' => ['edit', 'create']]);

        Route::resource('config', 'SiteConfigController', ['only' => ['index', 'store']]);
    });

    Route::group(['namespace' => 'Reference', 'prefix' => 'references'], function () {
        Route::group(['prefix' => 'requests'], function () {
            Route::get('statuses', 'RequestReferenceController@getStatuses');
            Route::get('projectStateDates', 'RequestReferenceController@getProjectStageDates');
            Route::get('renovationTypes', 'RequestReferenceController@getRenovationTypes');
            Route::get('roomTypes', 'RequestReferenceController@getRoomTypes');
            Route::get('roomStyles/{roomTypeId?}', 'RequestReferenceController@getRoomStyles');
            Route::get('workTypes/{workTypeId?}', 'RequestReferenceController@getWorkTypes');
            Route::get('work-doubles/{actionType}/{workTypeId}', 'RequestReferenceController@getRoomDouble');
            Route::get('workActions', 'RequestReferenceController@getWorkActions');
            Route::get('workCountableTypes/{workTypeId?}', 'RequestReferenceController@getWorkCountableTypes');
        });
        Route::get('advantageTypes', 'RequestReferenceController@getAdvantageTypes');
        Route::get('slideTypes', 'RequestReferenceController@getSlideTypes');

        Route::get('building-types/all', 'BuildingTypeController@all');
        Route::delete('building-types/force-delete/{id}', 'BuildingTypeController@forceDestroy');
        Route::resource('building-types', 'BuildingTypeController', ['except' => ['edit', 'create']]);

        Route::get('building-stages/all', 'BuildingStageController@all');
        Route::delete('building-stages/force-delete/{id}', 'BuildingStageController@forceDestroy');
        Route::resource('building-stages', 'BuildingStageController', ['except' => ['edit', 'create']]);

        Route::get('project-stages/all', 'ProjectStageController@all');
        Route::delete('project-stages/force-delete/{id}', 'ProjectStageController@forceDestroy');
        Route::resource('project-stages', 'ProjectStageController', ['except' => ['edit', 'create']]);

        Route::resource('states', 'StateController', ['except' => ['edit', 'create']]);
    });
    
    Route::get('contacts/addresses', 'ContactAddressController@index');

    Route::post('contacts/model', 'ContactController@getValuesByModel');
    Route::get('contacts/all', 'ContactController@all');
    Route::post('contacts/link', 'ContactController@link');
    Route::post('contacts/unlink', 'ContactController@unlink');

    Route::resource('contacts', 'ContactController', ['except' => ['edit']]);

    Route::post('leads/page', 'LeadController@getPageByModel');
    Route::get('leads/user/{id?}', 'LeadController@showByUserId');
    Route::post('leads/all', 'LeadController@all');
    Route::resource('leads', 'LeadController', ['except' => ['edit']]);

    Route::group(['prefix' => 'requests'], function () {
        Route::post('model', 'RequestController@getValuesByModel');
        Route::get('all', 'RequestController@all');
        Route::patch('{id}/view', 'RequestController@view');
        Route::patch('{id}/status', 'RequestController@changeStatus');
        Route::resource('/', 'RequestController', ['except' => ['edit']])->parameters(['' => 'request']);
    });

    Route::post('notes/model', 'NoteController@getValuesByModel');
    Route::get('notes/all', 'NoteController@all');
    Route::resource('notes', 'NoteController', ['except' => ['edit']]);

    Route::post('attachments/model', 'AttachmentController@getValuesByModel');
    Route::get('attachments/all', 'AttachmentController@all');
    Route::resource('attachments', 'AttachmentController', ['except' => ['edit']]);

    Route::post('activities/model', 'LogController@getValuesByModel');
    Route::get('activities/all', 'LogController@all');
    Route::resource('activities', 'LogController', ['except' => ['edit', 'store', 'update', 'delete']]);

    Route::post('tasks/model', 'TaskController@getValuesByModel');
    Route::get('tasks/all', 'TaskController@all');
    Route::resource('tasks', 'TaskController', ['except' => ['edit']]);

    Route::post('questions/model', 'QuestionController@getValuesByModel');
    Route::get('questions/all', 'QuestionController@all');
    Route::resource('questions', 'QuestionController', ['except' => ['edit']]);

    Route::get('workers', 'WorkerController@index');
    Route::get('workers/all', 'WorkerController@all');

    Route::resource('solutions', 'SolutionController', ['only' => ['index', 'show']]);

    Route::resource('materials', 'MaterialController', ['only' => ['index', 'show']]);

    Route::resource('works', 'WorkController', ['only' => ['index', 'show']]);

    Route::resource('advantages', 'AdvantageController', ['only' => ['index', 'show']]);

    Route::resource('reviews', 'ReviewController', ['only' => ['index', 'show']]);

    Route::resource('services', 'ServiceOfferController', ['only' => ['index', 'show']]);

    Route::resource('pages', 'PageController', ['only' => ['index', 'show']]);

    Route::resource('sliders', 'SliderController', ['only' => ['index', 'show']]);

    Route::get('slides/all', 'SlideController@all');
    Route::get('slides/type', 'SlideController@byType');
    Route::resource('slides', 'SlideController', ['only' => ['index', 'show']]);

    Route::resource('config', 'SiteConfigController', ['only' => ['index']]);
    Route::get('socials', 'SocialController@index');

    Route::get('building-types', 'BuildingTypeController@index');
    Route::get('building-types/paginate', 'BuildingTypeController@paginate');

    Route::get('building-stages', 'BuildingStageController@index');
    Route::get('building-stages/paginate', 'BuildingStageController@paginate');

    Route::get('project-stages', 'ProjectStageController@index');
    Route::get('project-stages/paginate', 'ProjectStageController@paginate');
});
