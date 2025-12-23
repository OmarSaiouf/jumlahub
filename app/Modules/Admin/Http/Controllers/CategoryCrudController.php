<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Modules\Admin\Http\Requests\CategoryRequest;
use App\Modules\Admin\Models\Language;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CategoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Modules\Admin\Models\Category::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/category');
        CRUD::setEntityNameStrings(__('category'), __('categories'));
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::setFromDb(); // set columns from db columns.

        $this->crud->addClause('where', 'language_id', Language::getIdFromCode(app()->getLocale()));


        CRUD::column([
            'name' => 'name',
            'label' => __('Name'),
        ]);
        CRUD::column([
            'name' => 'parent_id',
            'label' => __('Parent Category'),
            'type' => 'select',
            'entity' => 'parent',
            'model' => \App\Modules\Admin\Models\Category::class,
            'attribute' => 'name_with_parents',
        ]);
        CRUD::column([
            'name' => 'language_id',
            'type' => 'select',
            'label' => __('Language'),
            'entity' => 'language',
            'model' => \App\Core\Models\Language::class,
            'attribute' => 'name',
        ]);

        CRUD::column([
            'name' => 'description',
            'label' => __('Description'),
        ]);

        CRUD::column([
            'name' => 'image',
            'type' => 'image',
            'label' => __('Image'),
            'disk' => 'categories',

        ]);

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    /**
     * Define what happens when the Create operation is loaded.1
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CategoryRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        CRUD::field([
            'name' => 'name',
            'type' => 'text',
            'label' => __('Name'),
        ])->required(true);
        CRUD::field([
            'name' => 'parent_id',
            'label' => __('Parent Category'),
            'type' => 'select',
            'entity' => 'parent',
            'model' => \App\Modules\Admin\Models\Category::class,
            'attribute' => 'name',
        ]);
        CRUD::field([
            'name' => 'language_id',
            'type' => 'select',
            'label' => __('Language'),
            'entity' => 'language',
            'model' => \App\Core\Models\Language::class,
            'attribute' => 'name',
        ])->required(true);
        CRUD::field([
            'name' => 'description',
            'type' => 'textarea',
            'label' => __('Description'),
        ]);
        CRUD::field([
            'name' => 'image',
            'type' => 'upload',
            'label' => __('Image'),
            'disk' => 'categories',
            'withFiles' => true,
        ]);

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
