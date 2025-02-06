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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->date('visit_date');
            $table->string('category');
            $table->string('description');
            $table->string('fullname')->nullable(); // Fullname allows NULL
            $table->integer('amount'); // Correct integer field
            $table->string('payment_method');
            
            $table->foreignId('staff_id')
                ->nullable() // Make the foreign key column nullable
                ->constrained('staff', 'id') // Reference the staff table's id column
                ->onDelete('set null') // Set NULL on delete
                ->onUpdate('cascade'); // Update on parent update

            $table->timestamps(); // Adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
};
