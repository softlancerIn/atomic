<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refund_request', function (Blueprint $table) {
            $table->id();
            $table->string('company_id')->nullable();
            $table->string('ref_id')->nullable();
            $table->enum('status', ['0', '1', '2'])->default('0')->comment('0: Initiate, 1: approved, 2: reject');
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
        Schema::dropIfExists('refund_request');
    }
}
