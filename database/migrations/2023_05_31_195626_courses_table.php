<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection($this->connection)->create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->tinyInteger('numOfPeople');
            $table->integer('totalTime');
            $table->string('difficulty');
            $table->text('description');
            // $table->string('image')->nullable();
            $table->timestamps();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('professor_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection($this->connection)->dropIfExists('courses');
    }
}
