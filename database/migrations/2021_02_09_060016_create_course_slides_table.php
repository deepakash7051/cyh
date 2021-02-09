<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_slides', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->id();
            $table->integer('course_id')->nullable();
            $table->integer('place')->nullable();
            $languages = config('panel.available_languages');
            if(count($languages) > 0){
                foreach($languages as $key => $value){
                    $table->text($key.'_title')->nullable();
                    $table->string($key.'_attachment_file_name')->nullable();
                    $table->integer($key.'_attachment_file_size')->nullable();
                    $table->string($key.'_attachment_content_type')->nullable();
                    $table->timestamp($key.'_attachment_updated_at')->nullable();
                }
            }
            $table->enum('status', ['1', '0'])->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_slides');
    }
}
