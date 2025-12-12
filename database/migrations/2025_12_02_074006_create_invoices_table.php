<?php

use App\Core\Enums\InvoiceStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('payment_id')->constrained();
            $table->string('invoice_number');
            $table->decimal('amount', 10, 2);
            $table->foreignId('currency_id')->constrained();
            $table->enum('status', InvoiceStatus::values())->default(InvoiceStatus::UNPAID->getValue());
            $table->date('due_date')->nullable();
            $table->date('issued_at')->nullable();
            $table->json('metadata')->nullable();
            $table->string('url_pdf')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
