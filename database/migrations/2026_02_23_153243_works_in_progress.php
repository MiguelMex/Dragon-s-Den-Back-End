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
        /**
         * All tables necesary to store the works in progress
         */
        Schema::create('wips', function (Blueprint $table) {
            $table->uuid('work_in_progress_id')->primary();
            $table->foreignUuid('work_in_progress_author')->constrained('users', 'user_id')->cascadeOnDelete();
            $table->string('work_in_progress_title',length:50)->default('Nuevo Proyecto');
        });

        Schema::create('drafts',function (Blueprint $table){
            $table->uuid('draft_id')->primary();
            $table->foreignUuid('draft_work_in_progress')->constrained('wips','work_in_progress_id')->cascadeOnDelete();
            $table->string('draft_name',length:50)->default('Nuevo Borrador');
            $table->string('draft_route',length:200);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wips');
        Schema::dropIfExists('drafts');
    }
};
