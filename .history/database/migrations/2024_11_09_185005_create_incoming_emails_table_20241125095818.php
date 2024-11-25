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
            $table->id(); // Primary key
            $table->unsignedBigInteger('user_id'); // Foreign key to users table
            $table->string('from'); // Email sender (max 255 characters)
            $table->string('subject')->nullable(); // Email subject, nullable for emails without a subject
            $table->text('content')->nullable(); // Email content, nullable if no content exists
            $table->timestamp('received_at')->nullable(); // Timestamp for when the email was received
            $table->timestamps(); // Laravel's created_at and updated_at fields

            // Define foreign key constraint
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade'); // Cascade delete emails when a user is deleted

            // Indexing for faster lookups
            $table->index('user_id'); // Index on user_id for queries filtering by user
            $table->index('received_at'); // Index on received_at for sorting and filtering by date
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
