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
         * Modifications for the wips table
         */
        Schema::table('wips', function (Blueprint $table){
            $table->renameColumn('work_in_progress_title','title');
            $table->renameColumn('work_in_progress_author','author');
            $table->timestamps();
        });

        /**
         * Modifications for the drafts table
         */
        Schema::table('drafts',function (Blueprint $table){
            $table->renameColumn('draft_name','name');
            $table->renameColumn('draft_work_in_progress','work_in_progress');
            $table->renameColumn('draft_route','route');
            $table->timestamps();
        });

        /**
         * Modifications for age in progress table
         */
        Schema::table('age_restrictions',function (Blueprint $table){
            $table->renameColumn('age_restriction_name','name');
            $table->renameColumn('age_restriction_desciption','description');
            $table->timestamps();
        });

        /**
         * Modifications for works table
         */
        Schema::table('works', function (Blueprint $table){
            $table->renameColumn('work_author','author');
            $table->renameColumn('work_age_restriction','age_restriction');
            $table->renameColumn('work_title','title');
            $table->renameColumn('work_description','description');
            $table->renameColumn('work_status','status');
            $table->renameColumn('work_cover','cover');
            $table->timestamps();
        });

        /**
         * Modificatations of chapters table
         */
        Schema::table('chapters', function (Blueprint $table){
            $table->renameColumn('chapter_work','work');
            $table->renameColumn('chaper_name','name');
            $table->renameColumn('chaper_cover','cover');
            $table->renameColumn('chapter_route','route');
            $table->timestamps();
        });

        /**
         * Modifications of genres table
         */
        Schema::table('genres', function (Blueprint $table){
            $table->renameColumn('genre_name','name');
            $table->timestamps();
        });

        /**
         * Modifications of genres_work table
         */
        Schema::table('genre_works', function (Blueprint $table){
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //None needed
    }
};
