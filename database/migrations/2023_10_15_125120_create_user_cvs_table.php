<?php

use App\Models\UserCv;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_cvs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(UserCv::USER_ID);
            $table->string(UserCv::TITLE);
            $table->text(UserCv::ATTACHMENT);
            $table->integer(UserCv::IS_DEFAULT)->default(0);
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
        Schema::dropIfExists('user_cvs');
    }
}
