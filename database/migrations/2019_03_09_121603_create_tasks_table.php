<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description');
            $table->enum('priority',['Low', 'Normal', 'High']);
            $table->enum('status',['Created', 'Todo', 'Done', 'Verified']);
            $table->unsignedBigInteger('assigned_to')->nullable();;
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();;
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('assigned_to')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('updated_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
