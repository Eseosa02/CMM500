<?php

use App\Models\UserEducation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserEducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_education', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(UserEducation::USER_ID);
            $table->string(UserEducation::TITLE);
            $table->string(UserEducation::INSTITUTION);
            $table->string(UserEducation::START_DATE);
            $table->string(UserEducation::END_DATE);
            $table->enum(UserEducation::GRADE, ['merit', 'distinct', 'pass']);
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
        Schema::dropIfExists('user_education');
    }
}
