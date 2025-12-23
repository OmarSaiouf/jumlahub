<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Modules\Admin\Http\Requests\InvoiceRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class InvoiceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class InvoiceCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Modules\Admin\Models\Invoice::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/invoice');
        CRUD::setEntityNameStrings('invoice', 'invoices');
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
            'name' => 'user_id',
            'label' => __('User'),
            'type' => 'select',
            'entity' => 'user',
            'model' => \App\Modules\Admin\Models\User::class,
            'attribute' => 'name',
        ]);
        CRUD::column([
            'name' => 'payment_id',
            'label' => __('Payment'),
            'type' => 'select',
            'entity' => 'payment',
            'model' => \App\Modules\Admin\Models\Payment::class,
            'attribute' => 'id',
        ]);
        CRUD::column([
            'name' => 'amount',
            'label' => __('Amount'),
        ]);

        CRUD::column([
            'name' => 'currency_id',
            'label' => __('Currency'),
            'type' => 'select',
            'entity' => 'currency',
            'model' => \App\Modules\Admin\Models\Currency::class,
            'attribute' => 'name',
        ]);
        CRUD::column([
            'name' => 'url_pdf',
            'label' => __('PDF URL'),
            'type' => 'url',
        ]);
        CRUD::column([
            'name' => 'invoice_number',
            'label' => __('Invoice Number'),
        ]);

        CRUD::column([
            'name' => 'status',
            'label' => __('Status'),
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
        CRUD::setValidation(InvoiceRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

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
