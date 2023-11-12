<?php

use App\Models\JobNotification;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(JobNotification::JOB_LISTING_ID);
            $table->unsignedBigInteger(JobNotification::USER_ID);
            $table->enum(JobNotification::STATUS, ['read', 'unread'])->default('unread');
            $table->text(JobNotification::MESSAGE);
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
        Schema::dropIfExists('job_notifications');
    }
}
