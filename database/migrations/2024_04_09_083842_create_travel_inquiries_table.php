<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelInquiriesTable extends Migration
{
    public function up()
    {
        Schema::create('travel_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('phone');
            $table->string('email');
            $table->string('destination');
            $table->date('travel_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('travel_inquiries');
    }
}