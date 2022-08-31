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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('user_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->string('business_name');
            $table->string('business_email')->unique();
            $table->string('contact_number')->nullable()->unique();
            $table->string('business_logo')->nullable();
            $table->text('business_started_date')->nullable();
            $table->text('about')->nullable();
            $table->string('slug');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('user_id')->references('id')->on('users');
            $table->boolean('service_status')->default(true);
            $table->string('full_address')->nullable();
            $table->jsonb('location')->nullable();
            $table->jsonb('facilities')->nullable();
            $table->jsonb('extra')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('businesses');
    }
};
