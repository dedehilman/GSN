<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppearanceSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appearance_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('language')->default('en');
            $table->enum('layout', ['sidebar-mini', 'layout-top-nav'])->default('sidebar-mini');
            $table->tinyInteger('dark_mode')->default(0);
            $table->tinyInteger('navbar_fixed')->default(1);
            $table->tinyInteger('sidebar_fixed')->default(1);
            $table->tinyInteger('footer_fixed')->default(1);
            $table->enum('sidebar_theme', ['light', 'dark'])->default('dark');
            $table->string('sidebar_variant')->default('primary');
            $table->integer('sidebar_elevation')->default(1);
            $table->enum('navbar_theme', ['light', 'dark'])->default('light');
            $table->string('navbar_variant')->default('white');
            $table->tinyInteger('navbar_border')->default(1);
            $table->tinyInteger('navbar_show_icon')->default(0);
            $table->string('image')->nullable();
            $table->tinyInteger('small_text')->default(1);
            $table->tinyInteger('sidebar_flat')->default(0);
            $table->tinyInteger('sidebar_legacy')->default(0);
            $table->tinyInteger('sidebar_indent')->default(0);
            $table->enum('type', ['global', 'user'])->default('user');
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appearance_settings');
    }
}
