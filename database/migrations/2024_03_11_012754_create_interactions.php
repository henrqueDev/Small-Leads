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
        Schema::create('interactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('description');
            $table->date('event_date');
            $table->unsignedBigInteger('user_id');
            

            $table->foreignUuid('lead_id')->references('id')->on('leads')->cascadeOnDelete();
            
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->foreignUuid('interaction_type_id')->references('id')->on('interaction_types')->cascadeOnDelete();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interactions');
    }
};
