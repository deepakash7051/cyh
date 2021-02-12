<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMcqoptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcqoptions', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->id();
            $table->integer('question_id')->nullable();
            $languages = config('panel.available_languages');
            if(count($languages) > 0){
                foreach($languages as $key => $value){
                    $table->text($key.'_option_a')->nullable();
                    $table->text($key.'_option_b')->nullable();
                    $table->text($key.'_option_c')->nullable();
                    $table->text($key.'_option_d')->nullable();
                }
            }
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
        Schema::dropIfExists('mcqoptions');
    }
}
