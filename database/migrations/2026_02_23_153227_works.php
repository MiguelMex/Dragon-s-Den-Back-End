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
         * All tables necessary to store the published works
         */

        /**
         * Age Restrictions table
         */
        Schema::create('age_restrictions',function(Blueprint $table){
            $table->uuid('age_restriction_id')->primary();
            $table->string('age_restriction_name',length:20)->default(null);
            $table->string('age_restriction_desciption',length:300);
        });

        /**
         * Works table
         */
        Schema::create('works',function (Blueprint $table){
            $table->uuid('work_id')->primary();
            $table->foreignUuid('work_author')->constrained('users', 'user_id')->cascadeOnDelete();
            $table->foreignUuid('work_age_restriction')->constrained('age_restrictions','age_restriction_id')->cascadeOnDelete();
            $table->string('work_title',length:50)->default('Nuevo Proyecto');
            $table->string('work_description',length:2000)->default(null);
            $table->boolean('work_status')->default(false);
            //TODO: Crear una ruta a una imagen predeterminada para el cover de la obra
            $table->string('work_cover')->default(null);
        });

        /**
         * Chapters table
         */
        Schema::create('chapters',function (Blueprint $table){
            $table->uuid('chapter_id')->primary();
            $table->foreignUuid('chapter_work')->constrained('works','work_id')->cascadeOnDelete();
            $table->string('chaper_name')->default('Nuevo capitulo');
            $table->string('chaper_cover',length:200)->default(null);
            $table->string('chapter_route');
        });

        /**
         * Tabla de generos
         */
        Schema::create('genres',function(Blueprint $table){
            $table->uuid('genre_id')->primary();
            $table->string('genre_name',length:50)->default(null);
        });

        /**
         * Intermediate table between genres and works
         */
        Schema::create('genre_works',function(Blueprint $table){
            $table->foreignUuid('genre_id')->constrained('genres','genre_id')->cascadeOnDelete();
            $table->foreignUuid('work_id')->constrained('works','work_id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Drop table if It exists
        Schema::dropIfExists('age_restrictions');
        Schema::dropIfExists('works');
        Schema::dropIfExists('chapters');
        Schema::dropIfExists('genres');
        Schema::dropIfExists('genres_works');
    }
};
