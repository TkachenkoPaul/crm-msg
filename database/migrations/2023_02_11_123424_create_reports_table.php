<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->integer('admin_id');
            $table->text('name')->nullable();
            $table->text('desc')->nullable();
            $table->text('file')->nullable();
            $table->text('path')->nullable();
            $table->text('size')->nullable();
            $table->integer('status')->default('0');
            $table->integer('count')->default('0');
            $table->integer('job_id')->nullable();
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
        Schema::dropIfExists('reports');
    }
};
