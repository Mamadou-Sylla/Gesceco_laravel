<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyFactureIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('cantine_id')->nullable()->unsigned();
            // $table->foreignId('customer_id')->constrained('customers');
            $table->foreign('cantine_id')->references('id')->on('cantines')->onDelete('cascade');
            $table->bigInteger('facture_id')->nullable()->unsigned();
            // $table->foreignId('customer_id')->constrained('customers');
            $table->foreign('facture_id')->references('id')->on('factures')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_cantines_id_foreign'); 
            $table->dropForeign('users_factures_id_foreign'); 
        });
        Schema::drop('users');
    }
}
