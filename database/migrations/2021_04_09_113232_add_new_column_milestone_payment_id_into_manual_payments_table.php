<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnMilestonePaymentIdIntoManualPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manual_payments', function($table) {
            $table->unsignedInteger('milestone_payment_id')->nullable()->after('proposal_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manual_payments', function($table) {
            $table->dropColumn('milestone_payment_id');
        });
    }
}
