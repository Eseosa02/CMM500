<?php

use App\Models\JobApplication;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(JobApplication::JOB_LISTING_ID);
            $table->unsignedBigInteger(JobApplication::USER_ID);
            $table->unsignedBigInteger(JobApplication::CV_ID);
            $table->text(JobApplication::MESSAGE)->nullable();
            $table->enum(JobApplication::STATUS, ['submitted', 'under-review', 'accepted', 'rejected', 'withdrawn'])->default('submitted');
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
        Schema::dropIfExists('job_applications');
    }
}
