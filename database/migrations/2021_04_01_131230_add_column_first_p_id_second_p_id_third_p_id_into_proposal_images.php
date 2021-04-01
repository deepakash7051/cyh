<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnFirstPIdSecondPIdThirdPIdIntoProposalImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proposal_images', function (Blueprint $table) {
            $table->unsignedInteger('first_p_id')->nullable()->after('proposal_id');
            $table->unsignedInteger('second_p_id')->nullable()->after('proposal_id');
            $table->unsignedInteger('third_p_id')->nullable()->after('proposal_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proposal_images', function (Blueprint $table) {
            $table->dropColumn('first_p_id');
            $table->dropColumn('second_p_id');
            $table->dropColumn('third_p_id');
        });
    }
}
