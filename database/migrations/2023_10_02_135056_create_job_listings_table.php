<?php

use App\Models\JobListing;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(JobListing::USER_ID);
            $table->string(JobListing::JOB_REFERENCE);
            $table->unsignedBigInteger(JobListing::CATEGORY_ID);
            $table->text(JobListing::TITLE);
            $table->text(JobListing::TITLE_SLUG);
            $table->text(JobListing::DESCRIPTION);
            $table->enum(JobListing::CONTRACT_TYPE, ['contract', 'full time', 'part time', 'internship', 'freelance']);
            $table->text(JobListing::EXPERIENCE);
            $table->text(JobListing::CITY);
            $table->text(JobListing::COUNTRY);
            $table->enum(JobListing::PRIORITY, ['urgent', 'medium', 'low']);
            $table->text(JobListing::SALARY)->nullable();
            $table->text(JobListing::EXPIRY_DATE)->nullable();
            $table->text(JobListing::HOURS)->nullable();
            $table->text(JobListing::SKILLS)->nullable();
            $table->enum(JobListing::STATUS, ['draft', 'open', 'closed', 'discarded', 'expired'])->default('draft');
            $table->integer(JobListing::VIEWS)->default(0);
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
        Schema::dropIfExists('job_listings');
    }
}
