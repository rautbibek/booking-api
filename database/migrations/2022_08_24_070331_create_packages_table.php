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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id');
            $table->foreign('business_id')
                  ->references('id')
                  ->on('businesses');
            $table->string('title');
            $table->string('package_name');
            $table->string('pacakge_type')->nullable();
            $table->boolean('price_per_person')->default(false);
            
            $table->integer('room_capacity')->nullable();
            $table->integer('total_room')->nullable();
            $table->jsonb('facilites')->nullable();
            $table->double('price',8,2);
            $table->text('detail');
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
        Schema::dropIfExists('packages');
    }
};
