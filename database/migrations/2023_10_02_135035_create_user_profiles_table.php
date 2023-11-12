<?php

use App\Models\UserProfile;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(UserProfile::USER_ID)->unique();
            $table->string(UserProfile::UNIQUE_ID)->unique();
            $table->string(UserProfile::TITLE)->nullable();
            $table->string(UserProfile::PHONE)->nullable();
            $table->text(UserProfile::DESCRIPTION)->nullable();
            $table->string(UserProfile::DOB)->nullable();
            $table->enum(UserProfile::GENDER, ['male', 'female', 'others'])->nullable();
            $table->text(UserProfile::EXPERIENCE)->nullable();
            $table->string(UserProfile::EDUCATION)->nullable();
            $table->string(UserProfile::CITY)->nullable();
            $table->string(UserProfile::COUNTRY)->nullable();
            $table->text(UserProfile::SKILLS)->nullable();
            $table->text(UserProfile::RATING)->nullable();
            $table->string(UserProfile::IMAGE)->nullable();
            $table->text(UserProfile::FB_LINK)->nullable();
            $table->text(UserProfile::TW_LINK)->nullable();
            $table->text(UserProfile::IN_LINK)->nullable();
            $table->text(UserProfile::LINKEDIN_LINK)->nullable();
            $table->text(UserProfile::WEBSITE)->nullable();
            $table->enum(UserProfile::SEXUAL_ORIENTATION, ['Heterosexual', 'Gay', 'Lesbian', 'Bisexual', 'Prefer not to say'])->nullable();
            $table->enum(UserProfile::DISABILITY, ['Yes', 'No', 'Prefer not to say'])->nullable();
            $table->enum(UserProfile::RELIGION, ['Christianity', 'Buddhist', 'Muslim', 'Hindu', 'Other', 'Prefer not to say'])->nullable();
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
        Schema::dropIfExists('user_profiles');
    }
}
