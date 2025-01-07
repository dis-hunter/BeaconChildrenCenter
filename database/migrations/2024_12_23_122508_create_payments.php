<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->constrained('visits','id');
            $table->foreignId('child_id')->constrained('children','id');
            $table->foreignId('staff_id')->constrained('staff','id');
            $table->string('payment_mode');
            $table->integer('amount');
            $table->date('payment_date');
            $table->string('invoice_numnber');
            $table->string('receipt_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
