<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminProposalFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_proposal_files', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('proposal_id');
            
            $table->unsignedInteger('admin_proposal_id')->nullable();
            // $table->unsignedInteger('first_p_id')->nullable();
            // $table->unsignedInteger('second_p_id')->nullable();
            // $table->unsignedInteger('third_p_id')->nullable();

            $table->string('attachment_file_name')->nullable();
            $table->integer('attachment_file_size')->nullable();
            $table->string('attachment_content_type')->nullable();
            $table->timestamp('attachment_updated_at')->nullable();
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
        Schema::dropIfExists('admin_proposal_files');
    }
}
