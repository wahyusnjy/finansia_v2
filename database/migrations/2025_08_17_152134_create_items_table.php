<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->integer('transaction_id');
            $table->string('type')->nullable();
            $table->string('name')->nullable();
            $table->string('quantity')->nullable();
            $table->string('uom')->nullable();
            $table->decimal('total',16,2)->nullable();
            $table->decimal('grand_total',16,2)->nullable();
             $table->timestamp('tr_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
