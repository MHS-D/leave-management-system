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
        Schema::table('projects', function (Blueprint $table) {
            $table->after('chosen_department_id', function ($table) {
                $table->decimal('budget', 10, 2)->nullable();
                $table->date('invitation_date')->nullable();
                $table->longText('project_position')->nullable();
                $table->bigInteger('assignment_book_number')->nullable();
                $table->date('assignment_book_date')->nullable();
                $table->date('assignment_book_submition_day')->nullable();
                $table->bigInteger('contract_book_number')->nullable();
                $table->date('contract_book_date')->nullable();
                $table->date('signature_date')->nullable();
                $table->date('work_starting_date')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('budget');
            $table->dropColumn('invitation_date');
            $table->dropColumn('project_position');
            $table->dropColumn('assignment_book_number');
            $table->dropColumn('assignment_book_date');
            $table->dropColumn('assignment_book_submition_day');
            $table->dropColumn('contract_book_number');
            $table->dropColumn('contract_book_date');
            $table->dropColumn('signature_date');
            $table->dropColumn('work_starting_date');
        });
    }
};
