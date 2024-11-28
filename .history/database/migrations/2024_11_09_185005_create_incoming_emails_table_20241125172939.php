<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomingEmailsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('incoming_emails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // The recipient user ID
            $table->string('from'); // The sender's email
            $table->string('subject'); // The subject of the email
            $table->text('content'); // The content of the email
            $table->timestamp('read_at')->nullable(); // To track if the email is read
            $table->timestamps();
    
            // Foreign key constraint (if you're using a `users` table for recipients)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */

     
    public function down(): void
    {
        Schema::dropIfExists('incoming_emails');
    }
}
