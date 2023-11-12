<?php

use App\Models\UserExperience;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_experiences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(UserExperience::USER_ID);
            $table->string(UserExperience::TITLE);
            $table->string(UserExperience::INSTITUTION);
            $table->string(UserExperience::START_DATE);
            $table->string(UserExperience::END_DATE)->nullable();
            $table->integer(UserExperience::IS_PRESENT)->default(0);
            $table->text(UserExperience::DESCRIPTION);
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
        Schema::dropIfExists('user_experiences');
    }
}
