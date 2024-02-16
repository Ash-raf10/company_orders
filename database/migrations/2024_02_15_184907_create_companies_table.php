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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique()->index();
            $table->string('company_code', 100);
            $table->string('name', 100);
            $table->string('email')->unique();
            $table->string('commercial_record_number', 100);
            $table->string('commercial_record_image')->nullable();
            $table->string('logo')->nullable();
            $table->foreignId('country_code')->nullable()->references('id')
                ->on('countries')->nullOnDelete();
            $table->softDeletes();
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
        Schema::dropIfExists('companies');
    }
};
