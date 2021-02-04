<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->id();
            $table->integer('category_id')->nullable();
            $table->string('ref_code')->nullable();
            $languages = config('panel.available_languages');
            if(count($languages) > 0){
                foreach($languages as $key => $value){
                    $table->text($key.'_title')->nullable();
                    $table->text($key.'_description')->nullable();
                }
            }
            $table->double('price', 8, 2)->default(0);
            $table->double('duration', 8, 2)->default(0);
            $table->integer('seats')->default(0);
            $table->string('image_file_name')->nullable();
            $table->integer('image_file_size')->nullable();
            $table->string('image_content_type')->nullable();
            $table->timestamp('image_updated_at')->nullable();
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
        Schema::dropIfExists('courses');
    }
}
