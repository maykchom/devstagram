<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            //Aca en el constrained no se le pasa valor porque automáticamente reconoce que la clave primaria (user_id) es de la tabla 'users' por la convención de larevel
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            //Aca en el constrained se le pasa 'users' porque la tabla donde se traerá el Id no es 'followers' sino 'users'.
            $table->foreignId('follower_id')->constrained('users')->onDelete('cascade');
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
        Schema::dropIfExists('followers');
    }
};
