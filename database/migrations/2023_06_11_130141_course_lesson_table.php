<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CourseLessonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection($this->connection)->create('course_lesson', function (Blueprint $table) {
            $table->id();
            $table->integer('course_id');
            $table->integer('lesson_id');
            $table->foreign('course_id')->references('id')
                ->on('courses');
            $table->foreign('lesson_id')->references('id')
                ->on('lessons');

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
        Schema::connection($this->connection)->dropIfExists('course_lesson');
    }
}
