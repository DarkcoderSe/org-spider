<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->string('company_url')->nullable();
            $table->string('source')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('linkedin_profile')->nullable();
            $table->string('job_title')->nullable();
            $table->string('email_address')->nullable();
            $table->string('headquater_address')->nullable();
            $table->integer('status')->default(0);

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
        Schema::dropIfExists('organizations');
    }
}
