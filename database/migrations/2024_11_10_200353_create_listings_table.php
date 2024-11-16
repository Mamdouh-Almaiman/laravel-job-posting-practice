<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // this is the foreign id that will be in the listings table with each listing to make a reliationship between the listing and the users who wrote it
            // onDelete('cascade'), so when the user is deleted all his listings gonna be deleted too
            $table->string('title');
            $table->string('logo')->nullable(); // we keep it as a String cuz we are storing the image path not the acutal image
            $table->string('tags');
            $table->string('company');
            $table->string('location');
            $table->string('email');
            $table->string('website');
            $table->longText('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
