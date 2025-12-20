<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Modules\Admin\Http\Requests\ProductRequest;
use App\Modules\Admin\Models\Currency;
use App\Modules\Admin\Models\Category;
use App\Modules\Admin\Models\City;
use App\Modules\Admin\Models\Country;
use App\Modules\Admin\Models\Language;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use COM;

/**
 * Class ProductCrudController
 * @package App\Modules\Admin\Http\Controllers
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
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
        CRUD::setModel(\App\Modules\Admin\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings(__('product'), __('products'));
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
        $this->crud->addClause('where', 'country_id', app('country'));
        $this->crud->addClause('where', 'city_id', app('city'));

        CRUD::column([
            'name' => 'name',
            'label' => __('name'),
        ]);
        CRUD::column([
            'name' => 'category_id',
            'label' => __('category'),
            'type' => 'select',
            'entity' => 'category',
            'model' => Category::class,
            'attribute' => 'name',
        ]);
        CRUD::column([
            'name' => 'price',
            'label' => __('price'),
        ]);
        CRUD::column([
            'name' => 'currency_id',
            'label' => __('currency'),
            'type' => 'select',
            'entity' => 'currency',
            'model' => Currency::class,
            'attribute' => 'name',
        ]);
        CRUD::column([
            'name' => 'unit',
            'label' => __('unit'),
        ]);
        CRUD::column([
            'name' => 'quantity',
            'label' => __('quantity'),
        ]);
        CRUD::column([
            "name" => 'quantity_sold',
            "label" => __('quantity sold'),
        ]);

        CRUD::column([
            'name' => 'language_id',
            'label' => __('language'),
            'type' => 'select',
            'entity' => 'language',
            'model' => Language::class,
            'attribute' => 'name',
        ]);
        CRUD::column([
            'name' => 'country_id',
            'label' => __('country'),
            'type' => 'select',
            'entity' => 'country',
            'model' => Country::class,
            'attribute' => 'name',
        ]);
        CRUD::column([
            'name' => 'city_id',
            'label' => __('city'),
            'type' => 'select',
            'entity' => 'city',
            'model' => City::class,
            'attribute' => 'name',
        ]);

        CRUD::column([
            'name' => 'discount',
            'label' => __('discount'),
        ]);
        CRUD::column([
            'name' => 'is_quantity_finished',
            'label' => __('is quantity finished'),
        ]);
        CRUD::column([
            "name" => 'description',
            "label" => __('description'),
        ]);


        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProductRequest::class);
        // CRUD::setFromDb(); // set fields from db columns.

        CRUD::field([
            'name' => 'name',
            'label' => __('name'),
            'type' => 'text',
            'wrapper' => [
                'class' => 'form-group col-md-6',
            ],
        ]);
        //  CRUD::addColumn([
        //     'name' => 'categories',
        //     'label' => 'التصنيف',
        //     'type' => 'select_multiple',
        //     'entity' => 'categories',
        //     'attribute' => 'name_with_parents',
        //     'model' => Category::class,
        // ]);
        CRUD::field([
            'name' => 'category_id',
            'label' => __('category'),
            'type' => 'select',
            'entity' => 'category',
            'attribute' => 'name_with_parents',
            'model' => Category::class,
            'wrapper' => [
                'class' => 'form-group col-md-6',
            ],

        ]);
        CRUD::field([
            'name' => 'description',
            'label' => __('description'),
            'type' => 'summernote',
        ]);
        CRUD::field([
            'name' => 'price',
            'type' => 'number',
            'wrapper' => [
                'step' => '0.01',
                'class' => 'form-group col-md-6',
            ],
            'label' => __('price'),
        ]);
        CRUD::field([
            'name' => 'unit',
            'type' => 'text',
            'wrapper' => [
                'class' => 'form-group col-md-6',
            ],
            'label' => __('unit'),
        ]);
        CRUD::field([
            'name' => 'quantity',
            'type' => 'number',
            'wrapper' => [
                'class' => 'form-group col-md-6',
                'step' => '0.1',
            ],
            'label' => __('quantity'),
        ]);
        CRUD::field([
            'name' => 'discount',
            'type' => 'number',
            'wrapper' => [
                'class' => 'form-group col-md-6',
                'max' => '100',
                'min' => '0',
                'step' => '1',
            ],
            'label' => __('discount'),
        ]);

        CRUD::field([
            'name' => 'currency_id',
            'label' => __('currency'),
            'type' => 'select',
            'entity' => 'currency',
            'model' => Currency::class,
            'attribute' => 'name',
        ]);
        CRUD::field([
            'name' => 'language_id',
            'label' => __('language'),
            'type' => 'select',
            'entity' => 'language',
            'model' => Language::class,
            'attribute' => 'name',
        ]);
        CRUD::field([
            'name' => 'country_id',
            'label' => __('country'),
            'type' => 'select',
            'entity' => 'country',
            'model' => Country::class,
            'attribute' => 'name',
        ]);
        CRUD::field([
            'name' => 'city_id',
            'label' => __('city'),
            'type' => 'select',
            'entity' => 'city',
            'model' => City::class,
            'attribute' => 'name',
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
