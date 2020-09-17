<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('ref');
            $table->string('name');
            $table->string('resume');
            $table->string('category');
            $table->decimal('price_ht');
            $table->decimal('price_ttc');
            $table->longText('description');
            $table->integer('quantity');
            $table->enum('active',['Yes','No']);
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
        Schema::dropIfExists('product');
    }
}
