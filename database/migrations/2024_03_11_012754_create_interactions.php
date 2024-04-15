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
            $table->id();
            $table->text('description');
            $table->date('event_date');
            
            $table->unsignedBigInteger('lead_id');
            $table->unsignedBigInteger('interaction_type_id');
            

            $table->foreign('lead_id')->references('id')->on('leads')->cascadeOnDelete();
            
            $table->foreignUuid('user_id')->references('id')->on('users');
            
            $table->foreign('interaction_type_id')->references('id')->on('interaction_types')->cascadeOnDelete();
            
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
