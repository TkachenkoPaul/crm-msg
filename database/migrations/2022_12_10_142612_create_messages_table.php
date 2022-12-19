<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->text('fio');
            $table->text('address');
            $table->text('house');
            $table->integer('type_id');
            $table->text('phone');
            $table->integer('admin_id');
            $table->dateTime('closed')->default('0000-00-00 00:00:00');
            $table->dateTime('status_updated_at')->default('0000-00-00 00:00:00');
            $table->date('plan')->nullable();
            $table->boolean('status_id')->default(0);
            $table->integer('responsible_id');
            $table->string('uid')->nullable();
            $table->integer('contract')->default(0);
            $table->integer('photo')->default(0);
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
        Schema::dropIfExists('messages');
    }
};
