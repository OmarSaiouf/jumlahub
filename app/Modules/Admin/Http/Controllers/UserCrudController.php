<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Core\Models\Currency;
use App\Modules\Admin\Models\Language;
use App\Modules\Admin\Http\Requests\UserRequest;
use App\Modules\Admin\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Lang;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
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
        CRUD::setModel(User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings(__('user'), __('users'));
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

        // $this->crud->addClause('where', 'language_id', Language::getIdFromCode(app()->getLocale()));
        $this->crud->addClause('where', 'country_id', app('country'));
        $this->crud->addClause('where', 'city_id', app('city'));


        CRUD::column('password')->remove();
        CRUD::column('two_factor_secret')->remove();
        CRUD::column('two_factor_recovery_codes')->remove();
        CRUD::column('two_factor_confirmed_at')->remove();

        CRUD::column('image')->type('image')->disk('public');
        CRUD::column('name');
        CRUD::column('email');
        CRUD::column('phone');
        CRUD::column([
            'name' => 'language_id',
            'type' => 'select',
            'label' => __('Language'),
            'entity' => 'language',
            'model' => Language::class,
            'attribute' => 'name',
        ]);
        CRUD::column([
            'name' => 'currency_id',
            'type' => 'select',
            'label' => __('Currency'),
            'entity' => 'currency',
            'model' => Currency::class,
            'attribute' => 'name',
        ]);
        CRUD::column([
            'name' => 'country_id',
            'type' => 'select',
            'label' => __('Country'),
            'entity' => 'country',
            'model' => \App\Modules\Admin\Models\Country::class,
            'attribute' => 'name',
        ]);
        CRUD::column([
            'name' => 'city_id',
            'type' => 'select',
            'label' => __('City'),
            'entity' => 'city',
            'model' => \App\Modules\Admin\Models\City::class,
            'attribute' => 'name',
        ]);
        CRUD::column('address');
        CRUD::column('role');

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
        CRUD::setValidation(UserRequest::class);
        CRUD::setFromDb();

        CRUD::field('two_factor_secret')->remove();
        CRUD::field('two_factor_recovery_codes')->remove();
        CRUD::field('two_factor_confirmed_at')->remove();
        CRUD::field('remember_token')->remove();


        CRUD::field([
            'name' => 'name',
            'type' => 'text',
            'label' => __('Name'),
        ])->required(true);

        CRUD::field([
            'name' => 'email',
            'type' => 'email',
            'label' => __('Email'),
        ])->required(true);

        CRUD::field([
            'name' => 'password',
            'type' => 'password',
            'label' => __('Password'),
        ])->required(true);
        CRUD::field([
            'name' => 'phone',
            'type' => 'text',
            'label' => __('Phone'),
        ])->required(true);

        CRUD::field([
            'name' => 'role',
            'type' => 'select_from_array',
            'options' => [
                'user' => __('User'),
                'admin' => __('Admin'),
            ],
            'label' => __('Role'),
        ])->required(true);



        CRUD::field([
            'name' => 'language_id',
            'type' => 'select',
            'label' => __('Language'),
            'entity' => 'language',
            'model' => Language::class,
            'attribute' => 'name',
            'default' => Language::getIdFromCode(app()->getLocale()),
        ]);

        CRUD::field([
            'name' => 'currency_id',
            'type' => 'select',
            'label' => __('Currency'),
            'entity' => 'currency',
            'model' => Currency::class,
            'attribute' => 'name',
        ])->required(true);

        CRUD::field([
            'name' => 'country_id',
            'type' => 'select',
            'label' => __('Country'),
            'entity' => 'country',
            'model' => \App\Modules\Admin\Models\Country::class,
            'attribute' => 'name',
        ])->required(true);

        CRUD::field([
            'name' => 'city_id',
            'type' => 'select',
            'label' => __('City'),
            'entity' => 'city',
            'model' => \App\Modules\Admin\Models\City::class,
            'attribute' => 'name',
        ])->required(true);

        CRUD::field([
            'name' => 'address',
            'type' => 'text',
            'label' => __('Address'),
        ]);
        CRUD::field([
            'name' => 'image',
            'type' => 'upload',
            'label' => __('Image'),
            'withFiles' => true,
            'disk' => 'public',

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
