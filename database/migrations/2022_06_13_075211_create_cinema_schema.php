<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration
{
    /** ToDo: Create a migration that creates all tables for the following user stories

    For an example on how a UI for an api using this might look like, please try to book a show at https://in.bookmyshow.com/.
    To not introduce additional complexity, please consider only one cinema.

    Please list the tables that you would create including keys, foreign keys and attributes that are required by the user stories.

    ## User Stories

     **Movie exploration**
     * As a user I want to see which films can be watched and at what times
     * As a user I want to only see the shows which are not booked out

     **Show administration**
     * As a cinema owner I want to run different films at different times
     * As a cinema owner I want to run multiple films at the same time in different showrooms

     **Pricing**
     * As a cinema owner I want to get paid differently per show
     * As a cinema owner I want to give different seat types a percentage premium, for example 50 % more for vip seat

     **Seating**
     * As a user I want to book a seat
     * As a user I want to book a vip seat/couple seat/super vip/whatever
     * As a user I want to see which seats are still available
     * As a user I want to know where I'm sitting on my ticket
     * As a cinema owner I dont want to configure the seating for every show
     */
    public function up()
    {
        // throw new \Exception('implement in coding task 4, you can ignore this exception if you are just running the initial migrations.');
        
        // Table for movies
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Table for showtimes
        Schema::create('showtimes', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start_time');
            $table->unsignedBigInteger('movie_id');
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->timestamps();
        });

        // Table for showrooms
        Schema::create('showrooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Pivot table for showtimes and showrooms
        Schema::create('showtime_showroom', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('showtime_id');
            $table->unsignedBigInteger('showroom_id');
            $table->foreign('showtime_id')->references('id')->on('showtimes')->onDelete('cascade');
            $table->foreign('showroom_id')->references('id')->on('showrooms')->onDelete('cascade');
            $table->timestamps();
        });

        // Table for seat types
        Schema::create('seat_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('premium_percentage', 5, 2);
            $table->timestamps();
        });

        // Table for seats
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('showtime_id');
            $table->unsignedBigInteger('seat_type_id');
            $table->string('row');
            $table->string('number');
            $table->timestamps();

            $table->foreign('showtime_id')->references('id')->on('showtimes')->onDelete('cascade');
            $table->foreign('seat_type_id')->references('id')->on('seat_types')->onDelete('cascade');
            $table->unique(['showtime_id', 'row', 'number']);
        });
        
        // Table for bookings
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('showtime_id');
            $table->unsignedBigInteger('seat_id');
            $table->string('customer_name');
            $table->timestamps();

            $table->foreign('showtime_id')->references('id')->on('showtimes')->onDelete('cascade');
            $table->foreign('seat_id')->references('id')->on('seats')->onDelete('cascade');
            $table->unique(['showtime_id', 'seat_id']);
        });

        // Table for prices
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('showtime_id');
            $table->unsignedBigInteger('seat_type_id');
            $table->decimal('price', 8, 2);
            $table->timestamps();

            $table->foreign('showtime_id')->references('id')->on('showtimes')->onDelete('cascade');
            $table->foreign('seat_type_id')->references('id')->on('seat_types')->onDelete('cascade');
            $table->unique(['showtime_id', 'seat_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
        Schema::dropIfExists('showtimes');
        Schema::dropIfExists('showrooms');
        Schema::dropIfExists('showtime_showroom');
        Schema::dropIfExists('seat_types');
        Schema::dropIfExists('seats');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('prices');
    }
}
