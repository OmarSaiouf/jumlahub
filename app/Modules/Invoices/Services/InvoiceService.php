<?php

namespace App\Modules\Invoices\Services;

use App\Modules\Invoices\Models\Invoice;

class InvoiceService
{
    public function create(array $data)
    {
        return Invoice::create($data);
    }
}