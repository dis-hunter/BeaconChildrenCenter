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
            $table->foreignId('visit_id')
                ->nullable()
                ->constrained('visits','id')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreignId('child_id')
                ->nullable()
                ->constrained('children','id')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreignId('staff_id')
                ->nullable()
                ->constrained('staff','id')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreignId('payment_mode_id')
                ->nullable()
                ->constrained('payment_modes','id')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->decimal('amount',10,2);
            $table->date('payment_date');
            $table->string('invoice_numnber')->unique();
            $table->string('receipt_number')->unique();
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
