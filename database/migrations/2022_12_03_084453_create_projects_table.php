<?php

use App\Constants\ProjectStatus;
use App\Constants\Status;
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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('company')->nullable();
            $table->string('number_of_book')->nullable();
            $table->date('date_of_book')->nullable();
            $table->unsignedBigInteger('chosen_department_id')->nullable();
            $table->unsignedInteger('status')->default(ProjectStatus::CREATED);
            $table->unsignedInteger('active')->default(Status::UNACTIVE);
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
        Schema::dropIfExists('offers');
    }
};
