<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class QuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection($this->connection)->create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('passing_points');
            $table->unsignedInteger('course_id');
            $table->foreign('course_id')->references('id')
                ->on('courses');
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
        Schema::connection($this->connection)->dropIfExists('quizzes');
    }
}
