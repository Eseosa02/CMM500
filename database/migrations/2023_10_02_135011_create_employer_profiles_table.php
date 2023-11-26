<?php

use App\Models\EmployerProfile;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployerProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employer_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(EmployerProfile::USER_ID)->unique();
            $table->string(EmployerProfile::UNIQUE_ID)->unique();
            $table->text(EmployerProfile::DESCRIPTION)->nullable();
            $table->string(EmployerProfile::PHONE)->nullable();
            $table->text(EmployerProfile::INDUSTRY)->nullable();
            $table->string(EmployerProfile::COMPANY_SIZE)->nullable();
            $table->string(EmployerProfile::FOUNDED)->nullable();
            $table->text(EmployerProfile::ADDRESS)->nullable();
            $table->string(EmployerProfile::CITY)->nullable();
            $table->string(EmployerProfile::COUNTRY)->nullable();
            $table->text(EmployerProfile::IMAGE)->nullable();
            $table->text(EmployerProfile::DOCUMENT)->nullable();
            $table->text(EmployerProfile::FB_LINK)->nullable();
            $table->text(EmployerProfile::TW_LINK)->nullable();
            $table->text(EmployerProfile::IN_LINK)->nullable();
            $table->text(EmployerProfile::LINKEDIN_LINK)->nullable();
            $table->enum(EmployerProfile::APPROVAL, ['unverified', 'verified', 'rejected'])->default('unverified');
            $table->text(EmployerProfile::WEBSITE)->nullable();
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
        Schema::dropIfExists('employer_profiles');
    }
}
