<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('incoming_emails', function (Blueprint $table) {
            $table->string('from')->nullable()->change();  // Make 'from' nullable
        });
    }
    
    public function down()
    {
        Schema::table('incoming_emails', function (Blueprint $table) {
            $table->string('from')->nullable(false)->change();  // Restore 'from' as non-nullable
        });
    }
    
};
