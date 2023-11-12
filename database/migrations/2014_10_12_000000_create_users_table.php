<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string(User::NAME);
            $table->string(User::EMAIL)->unique();
            $table->timestamp(User::EMAIL_VERIFIED_AT)->nullable();
            $table->string(User::PASSWORD);
            $table->enum(User::STATUS, ['active', 'disabled'])->default('active');
            $table->string(User::IS_COMPLETE)->default(0);
            $table->enum(User::ROLE, [User::ROLE_CANDIDATE, User::ROLE_EMPLOYER])->default(User::ROLE_CANDIDATE);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
