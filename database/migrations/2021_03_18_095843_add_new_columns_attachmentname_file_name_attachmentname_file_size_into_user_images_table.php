<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsAttachmentnameFileNameAttachmentnameFileSizeIntoUserImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_images', function (Blueprint $table) {
            $table->string('attachment_file_name')->nullable()->after('mime');
            $table->integer('attachment_file_size')->nullable()->after('attachment_file_name');
            $table->string('attachment_content_type')->nullable()->after('attachment_file_size');
            $table->timestamp('attachment_updated_at')->nullable()->after('attachment_content_type');
            
            $table->dropColumn('image_name');
            $table->dropColumn('image_url');
            $table->dropColumn('mime');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_images', function (Blueprint $table) {
            $table->dropColumn('attachment_file_name');
            $table->dropColumn('attachment_file_size');
            $table->dropColumn('attachment_content_type');
            $table->dropColumn('attachment_updated_at');
        });
    }
}
