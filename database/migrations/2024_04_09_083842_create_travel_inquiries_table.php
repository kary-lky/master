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
            $table->string('title');
            $table->string('destination');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('tags');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('travel_inquiries');
    }
}