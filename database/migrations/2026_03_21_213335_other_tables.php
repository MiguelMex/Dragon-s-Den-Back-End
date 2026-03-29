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
        //Collections table
        Schema::create('collections',function(Blueprint $table){
            $table->uuid('collection_id')->primary();
            $table->text('description')->default('Sin descripción');
            $table->foreignUuid('user')->constrained('users','user_id');
            $table->timestamps();
        });

        /**
         * Relational table beetwen collections and works
         */
        Schema::create('collections_works',function(Blueprint $table){
            $table->foreignUuid('collection_id')->constrained('collections','collection_id');
            $table->foreignUuid('work_id')->constrained('works','work_id');
            $table->timestamps();
        });

        /**
         * Comments table
         */
        Schema::create('comments',function(Blueprint $table){
            $table->uuid('comment_id')->primary();
            $table->foreignUuid('user')->constrained('users','user_id');
            $table->foreignUuid('chapter')->constrained('chapters','chapter_id');
            $table->timestamps();
        });

        Schema::table('comments',function(Blueprint $table){
            $table->foreignUuid('response')->constrained('comments','comment_id')->nullable();
        });

        /**
         * Relational table beetwen genres and works
         */
        Schema::create('genres_works',function(Blueprint $table){
            $table->foreignUuid('genre_id')->constrained('genres','genre_id');
            $table->foreignUuid('work')->constrained('works','work_id');
            $table->timestamps();
        });

        /**
         * Read history table
         */
        Schema::create('read_histories',function(Blueprint $table){
            $table->uuid('read_history_id')->primary();
            $table->dateTime('read_date');
            $table->foreignUuid('user')->constrained('users','user_id');
            $table->foreignUuid('work')->constrained('works','work_id');
            $table->foreignUuid('chapter')->constrained('chapters','chapter_id');
            $table->timestamps();
        });

        /**
         * Read lists table
         */
        Schema::create('read_lists',function(Blueprint $table){
            $table->uuid('read_list_id')->primary();
            $table->string('name',length:100)->default('Mi lista');
            $table->string('description',length:10000)->nullable();
            $table->foreignUuid('user')->constrained('users','user_id');
            $table->timestamps();
        });

        /**
         * Relational table beetwen Read lists and works
         */
        Schema::create('read_lists_works',function(Blueprint $table){
            $table->foreignUuid('read_list')->constrained('read_lists','read_list_id');
            $table->foreignUuid('work')->constrained('works','work_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections');
        Schema::dropIfExists('collections_works');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('genres_works');
        Schema::dropIfExists('read_histories');
        Schema::dropIfExists('read_lists');
        Schema::dropIfExists('read_lists_works');
    }
};
