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
        Schema::table('admins', function (Blueprint $table) {
            $table->foreign('company_id', 'admins_company_id_foreign')->references('id')->on('companies');
            $table->foreign('admin_role_id', 'admins_admin_role_id_foreign')->references('id')->on('admin_roles');
        });

        Schema::table('user_samples', function (Blueprint $table) {
            $table->foreign('admin_id', 'user_samples_admin_id_foreign')->references('id')->on('admins');
            $table->foreign('postcode_id', 'user_samples_postcode_id_foreign')->references('id')->on('postcodes');
        });

        Schema::table('images_sample', function (Blueprint $table) {
            $table->foreign('sample_id', 'images_sample_id_foreign')->references('id')->on('samples');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropForeign('admins_company_id_foreign');
            $table->dropForeign('admins_admin_role_id_foreign');
        });

        Schema::table('user_samples', function (Blueprint $table) {
            $table->dropForeign('user_samples_admin_id_foreign');
            $table->dropForeign('user_samples_postcode_id_foreign');
        });

        Schema::table('images_sample', function (Blueprint $table) {
            $table->dropForeign('images_sample_id_foreign');
        });
    }
};
