<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Modules\Admin\Http\Requests\PaymentProviderRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PaymentProviderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PaymentProviderCrudController extends CrudController
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
        CRUD::setModel(\App\Modules\Admin\Models\PaymentProvider::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/payment-provider');
        CRUD::setEntityNameStrings('payment provider', 'payment providers');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // set columns from db columns.

        CRUD::column([
            'name' => 'name',
            'label' => __('Name'),
        ]);
        CRUD::column([
            'name' => 'code',
            'label' => __('Code'),
        ]);
        CRUD::column([
            'name' => 'gateway_class',
            'label' => __('Gateway Class'),
            'type' => 'enum',
            'options' => \App\Modules\Admin\Models\PaymentProvider::getGatewayClassOptions(),
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
        CRUD::setValidation(PaymentProviderRequest::class);
        CRUD::setFromDb(); // set fields from db columns.


        CRUD::field([
            'name' => 'name',
            'label' => __('Name'),
        ]);
        CRUD::field([
            'name' => 'code',
            'label' => __('Code'),
        ]);
        CRUD::field([
            'name' => 'gateway_class',
            'label' => __('Gateway Class'),
            'type' => 'enum',
            'options' => \App\Modules\Admin\Models\PaymentProvider::getGatewayClassOptions(),
        ]);

        CRUD::field([
            'name' => 'config',
            'label' => __('Configuration'),
            'type' => 'textarea',
            'default' => '{}',
        ]);

        CRUD::field([
            'name' => 'is_active',
            'label' => __('Is Active'),
            'type' => 'checkbox',
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
