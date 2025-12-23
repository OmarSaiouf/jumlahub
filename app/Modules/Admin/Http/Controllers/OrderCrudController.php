<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Core\Enums\OrderStatus;
use App\Modules\Admin\Http\Requests\OrderRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class OrderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class OrderCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
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
        CRUD::setModel(\App\Modules\Admin\Models\Order::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/order');
        CRUD::setEntityNameStrings('order', 'orders');
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
            'name' => 'product_id',
            'label' => __('Product'),
            'type' => 'select',
            'entity' => 'product',
            'model' => \App\Modules\Admin\Models\Product::class,
            'attribute' => 'name',
        ]);
        CRUD::column('amount');
        CRUD::column('quantity');
        CRUD::column('status');
        CRUD::column('transaction_id');
        CRUD::column([
            'name' => 'payment_provider_id',
            'label' => __('Payment Provider'),
            'type' => 'select',
            'entity' => 'paymentProvider',
            'model' => \App\Modules\Admin\Models\PaymentProvider::class,
            'attribute' => 'name',
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
        CRUD::setValidation(OrderRequest::class);
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
        CRUD::field([
            'name' => 'status',
            'type' => 'enum',
            'label' => __('Status'),
            'options' => OrderStatus::getAllKeyValues(),
        ]);
        CRUD::field([
            'name' => 'transaction_id',
            'type' => 'text',
            'label' => __('Transaction ID'),
        ]);
        CRUD::field([
            'name' => 'amount',
            'type' => 'number',
            'label' => __('Amount'),
            'attributes' => ["step" => "0.01"],
        ]);
        CRUD::field([
            'name' => 'quantity',
            'type' => 'number',
            'label' => __('Quantity'),
        ]);
        CRUD::field([
            'name' => 'payment_provider_id',
            'label' => __('Payment Provider'),
            'type' => 'select',
            'entity' => 'paymentProvider',
            'model' => \App\Modules\Admin\Models\PaymentProvider::class,
            'attribute' => 'name',
        ]);

    }
}
