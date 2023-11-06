<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->text('titre');
            $table->longText('contenu');
            $table->unsignedBigInteger('category_id');
            $table->date('date_debut')->default(date('Y-m-d'));
            $table->date('date_expiration')->nullable();
            $table->foreign('category_id')
                    ->references('id')
                    ->on('categories')
                    ->onUpdate('CASCADE')
                    ->onDelete('CASCADE');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
