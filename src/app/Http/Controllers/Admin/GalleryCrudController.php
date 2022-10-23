<?php

namespace SeanDowney\BackpackGalleryCrud\app\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Storage;

// VALIDATION: change the requests to match your own file names if you need form validation
use SeanDowney\BackpackGalleryCrud\app\Http\Requests\GalleryRequest as StoreRequest;
use SeanDowney\BackpackGalleryCrud\app\Http\Requests\GalleryRequest as UpdateRequest;

class GalleryCrudController extends CrudController {
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }

    public function setupListOperation(): void
    {
        // ------ CRUD FIELDS
        CRUD::addColumn([    // TEXT
                                   'name' => 'title',
                                   'label' => 'Title',
                                   'type' => 'text',
                                   'placeholder' => 'Your title here',
                              ]);
        CRUD::addColumn([
                                  'name' => 'slug',
                                  'label' => 'Slug (URL)',
                                  'type' => 'text',
                                  'hint' => 'Will be automatically generated from your title, if left empty.',
                              ]);

        CRUD::addColumn([    // WYSIWYG
                                   'name' => 'body',
                                   'label' => 'Body',
                                   'type' => 'ckeditor',
                                   'placeholder' => 'Your textarea text here',
                              ]);

        CRUD::addColumn([ // Table
                                'name' => 'image_items',
                                'label' => 'Images',
                                'type' => 'gallery_table',
                                'entity_singular' => 'image_item', // used on the "Add X" button
                                'columns' => [
                                    'image' => 'Upload Image',
                                    'caption' => 'Caption',
                                ],
                                'max' => 50, // maximum rows allowed in the table
                                'min' => 0, // minimum rows allowed in the table
                                'disk' => config('seandowney.gallerycrud.disk'),
                              ]);

        CRUD::addColumn([    // SELECT
                                   'label' => 'Status',
                                   'type' => 'select_from_array',
                                   'name' => 'status',
                                   'allows_null' => true,
                                   'options' => [0 => 'Draft', 1 => 'Published'],
                                   'value' => null,
                              ]);

        // ------ CRUD COLUMNS
        CRUD::addColumn(['title']); // add multiple columns, at the end of the stack
        CRUD::addColumn([
                                   'name' => 'status',
                                   'label' => 'Status',
                                   'type' => 'boolean',
                                   'options' => [0 => 'Draft', 1 => 'Published'],
                               ]);
    }

    protected function setupCreateOperation(): void
    {
        CRUD::addField([    // TEXT
                                   'name' => 'title',
                                   'label' => 'Title',
                                   'type' => 'text',
                                   'placeholder' => 'Your title here',
                              ]);
        CRUD::addField([
                                  'name' => 'slug',
                                  'label' => 'Slug (URL)',
                                  'type' => 'text',
                                  'hint' => 'Will be automatically generated from your title, if left empty.',
                              ]);

        CRUD::addField([    // WYSIWYG
                                   'name' => 'body',
                                   'label' => 'Body',
                                   'type' => 'ckeditor',
                                   'placeholder' => 'Your textarea text here',
                              ]);

        CRUD::addField([ // Table
                                'name' => 'image_items',
                                'label' => 'Images',
                                'type' => 'gallery_table',
                                'entity_singular' => 'image_item', // used on the "Add X" button
                                'columns' => [
                                    'image' => 'Upload Image',
                                    'caption' => 'Caption',
                                ],
                                'max' => 50, // maximum rows allowed in the table
                                'min' => 0, // minimum rows allowed in the table
                                'disk' => config('seandowney.gallerycrud.disk'),
                              ]);

        CRUD::addField([    // SELECT
                                   'label' => 'Status',
                                   'type' => 'select_from_array',
                                   'name' => 'status',
                                   'allows_null' => true,
                                   'options' => [0 => 'Draft', 1 => 'Published'],
                                   'value' => null,
                              ]);
    }

    public function setUp() {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel("SeanDowney\BackpackGalleryCrud\app\Models\Gallery");
        $this->crud->setRoute(config('backpack.base.route_prefix').'/gallery');
        $this->crud->setEntityNameStrings('gallery', 'galleries');
    }


    public function store(StoreRequest $request)
    {
        $store_response = parent::storeCrud($request);

        $disk = config('seandowney.gallerycrud.disk');

        if (!is_dir(Storage::disk($disk)->getAdapter()->getPathPrefix().'/'.$this->crud->entry->slug)) {
            // create the gallery folder
            Storage::disk($disk)->makeDirectory($this->crud->entry->slug);
        }

        return $store_response;
    }

    public function update(UpdateRequest $request)
    {
        return parent::updateCrud($request);
    }
}
